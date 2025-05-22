#!/usr/bin/env bash

# Explicit socket directory creation
mkdir -p /run/php
chown -R www-data:www-data /run/php
chmod 775 /run/php

# User scripts
if [ -d /var/www/html/.fly/scripts ]; then
    for f in /var/www/html/.fly/scripts/*.sh; do
        [ -f "$f" ] && bash "$f" -e
    done
fi

# Permissions
chown -R www-data:www-data /var/www/html
# In entrypoint.sh, add before PHP-FPM starts:
if [ -f "vite.config.js" ]; then
    npm run build
fi
# Start PHP-FPM (modified from original)
/usr/sbin/php-fpm8.2 --daemonize --fpm-config /etc/php/8.2/fpm/php-fpm.conf

# Verify socket exists (with better error handling)
if ! timeout 10 bash -c 'until [ -S /run/php/php8.2-fpm.sock ]; do sleep 1; done'; then
    echo "ERROR: PHP-FPM socket not created after 10 seconds" >&2
    exit 1
fi

# Launch via Supervisor or direct command
if [ $# -gt 0 ]; then
    exec "$@"
else
    exec supervisord -c /etc/supervisor/supervisord.conf
fi