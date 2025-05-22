# syntax = docker/dockerfile:experimental

ARG PHP_VERSION=8.2
ARG NODE_VERSION=18
FROM ubuntu:22.04 as base
LABEL fly_launch_runtime="laravel"

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION
ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer \
    COMPOSER_MAX_PARALLEL_HTTP=24 \
    PHP_PM_MAX_CHILDREN=10 \
    PHP_PM_START_SERVERS=3 \
    PHP_MIN_SPARE_SERVERS=2 \
    PHP_MAX_SPARE_SERVERS=4 \
    PHP_DATE_TIMEZONE=UTC \
    PHP_DISPLAY_ERRORS=Off \
    PHP_ERROR_REPORTING=22527 \
    PHP_MEMORY_LIMIT=256M \
    PHP_MAX_EXECUTION_TIME=90 \
    PHP_POST_MAX_SIZE=100M \
    PHP_UPLOAD_MAX_FILE_SIZE=100M \
    PHP_ALLOW_URL_FOPEN=Off

# Prepare base container: 
# 1. Install PHP, Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY .fly/php/ondrej_ubuntu_php.gpg /etc/apt/trusted.gpg.d/ondrej_ubuntu_php.gpg
ADD .fly/php/packages/${PHP_VERSION}.txt /tmp/php-packages.txt

RUN apt-get update \
    && apt-get install -y --no-install-recommends gnupg2 ca-certificates git-core curl zip unzip \
                                                  rsync vim-tiny htop sqlite3 nginx supervisor cron \
    && ln -sf /usr/bin/vim.tiny /etc/alternatives/vim \
    && ln -sf /etc/alternatives/vim /usr/bin/vim \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ondrej-ubuntu-php-focal.list \
    && apt-get update \
    && apt-get -y --no-install-recommends install $(cat /tmp/php-packages.txt) \
    && ln -sf /usr/sbin/php-fpm${PHP_VERSION} /usr/sbin/php-fpm \
    && mkdir -p /var/www/html/public && echo "index" > /var/www/html/public/index.php \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# 2. Copy config files to proper locations
COPY .fly/nginx/ /etc/nginx/
COPY .fly/fpm/ /etc/php/${PHP_VERSION}/fpm/
COPY .fly/supervisor/ /etc/supervisor/
COPY .fly/entrypoint.sh /entrypoint
COPY .fly/start-nginx.sh /usr/local/bin/start-nginx
RUN chmod 754 /usr/local/bin/start-nginx
    
# 3. Copy application code, skipping files based on .dockerignore
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Setup application dependencies 
RUN composer install --optimize-autoloader --no-dev \
    && npm install && npm run build \
    && mkdir -p storage/logs \
    && php artisan optimize:clear \
    && chown -R www-data:www-data /var/www/html \
    && echo "MAILTO=\"\"\n* * * * * www-data /usr/bin/php /var/www/html/artisan schedule:run" > /etc/cron.d/laravel \
    && sed -i='' '/->withMiddleware(function (Middleware \$middleware) {/a\
        \$middleware->trustProxies(at: "*");\
    ' bootstrap/app.php; \ 
    if [ -d .fly ]; then cp .fly/entrypoint.sh /entrypoint; chmod +x /entrypoint; fi;

# Multi-stage build: Build static assets
# This allows us to not include Node within the final container
# Note: The npm install commands work once in production (install node...)
FROM node:${NODE_VERSION} as node_modules_go_brrr

RUN mkdir /app

RUN mkdir -p  /app
WORKDIR /app
COPY . .
COPY --from=base /var/www/html/vendor /app/vendor

# Use yarn or npm depending on what type of
# lock file we might find. Defaults to
# NPM if no lock file is found.
# Note: We run "production" for Mix and "build" for Vite
RUN if [ -f "vite.config.js" ]; then \
        ASSET_CMD="build"; \
    else \
        ASSET_CMD="production"; \
    fi; \
    if [ -f "yarn.lock" ]; then \
        yarn install --frozen-lockfile; \
        yarn $ASSET_CMD; \
    elif [ -f "pnpm-lock.yaml" ]; then \
        corepack enable && corepack prepare pnpm@latest-8 --activate; \
        pnpm install --frozen-lockfile; \
        pnpm run $ASSET_CMD; \
    elif [ -f "package-lock.json" ]; then \
        npm ci --no-audit; \
        npm run $ASSET_CMD; \
    else \
        npm install; \
        npm run $ASSET_CMD; \
    fi;

# From our base container created above, we
# create our final image, adding in static
# assets that we generated above
FROM base

# ▼▼▼ Use this updated Node installation instead ▼▼▼
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@9    # ← Downgrade npm to v9 (compatible with Node 18) \
    && rm -rf /var/lib/apt/lists/*

# Keep everything else exactly the same
COPY --from=node_modules_go_brrr /app/public /var/www/html/public-npm
RUN rsync -ar /var/www/html/public-npm/ /var/www/html/public/ \
    && rm -rf /var/www/html/public-npm \
    && chown -R www-data:www-data /var/www/html/public
RUN mkdir -p /run/php && \
    chown -R www-data:www-data /run/php && \
    chmod 775 /run/php
RUN /usr/sbin/php-fpm8.2 --test && \
    nginx -t
# Ensure proper socket configuration
RUN echo '[www]' > /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'user = www-data' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'group = www-data' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'listen = /run/php/php8.2-fpm.sock' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'listen.owner = www-data' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'listen.group = www-data' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'listen.mode = 0660' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'pm = dynamic' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'pm.max_children = 10' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'pm.start_servers = 3' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'pm.min_spare_servers = 2' >> /etc/php/8.2/fpm/pool.d/www.conf && \
    echo 'pm.max_spare_servers = 4' >> /etc/php/8.2/fpm/pool.d/www.conf

# Verify configurations
RUN php-fpm8.2 --test && nginx -t
EXPOSE 8080
ENTRYPOINT ["/entrypoint"]