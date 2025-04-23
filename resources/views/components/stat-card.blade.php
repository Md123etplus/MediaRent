@props(['title', 'value', 'color' => 'gray'])

<div class="bg-white p-6 rounded-xl shadow border-t-4 border-{{ $color }}-500">
    <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
    <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $value }}</p>
</div>
