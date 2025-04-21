<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $value }}</p>
        </div>
        <div class="p-3 rounded-full bg-{{ $iconColor ?? 'indigo' }}-100 text-{{ $iconColor ?? 'indigo' }}-600 dark:bg-{{ $iconColor ?? 'indigo' }}-900 dark:text-{{ $iconColor ?? 'indigo' }}-300">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
    </div>
    <div class="mt-4">
        <span class="text-{{ $trendColor }}-500 text-sm font-medium">{{ $trend }}</span>
        <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">{{ $description }}</span>
    </div>
</div>