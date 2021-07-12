@props(['name', 'value'])

<div {{ $attributes->merge(['class' => "flex gap-2"])}}>
    <div class=" w-40 rounded-lg border-2 bg-gray-200 py-1 px-4 ease-in duration-100  text-gray-700">
        {{ $name }} </div>
    <div
        class="max-w-xs rounded-lg border-2 border-gray-200 py-1 px-4 hover:border-primary hover:text-primary ease-in duration-300 font-semibold text-gray-700">
        {{ $value ?? $slot }}
    </div>
</div>
