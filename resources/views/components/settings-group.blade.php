@props(['heading'])

<div {{ $attributes->merge(['class' => "overflow-auto"]) }}>
    <div class="pb-2 text-2xl font-semibold text-gray-800 leading-tight"> {{ $heading }} </div>
    <div class='flex flex-wrap'> {{ $slot }} </div>
</div>
