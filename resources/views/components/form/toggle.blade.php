@props(['on' => false, 'type' => 'checkbox', 'name', 'label' => false])


<div role="checkbox" id="{{ $name }}" {{ $attributes->merge(['class' => 'flex gap-2']) }}
    x-data="{ {{ $name }}_on: {{ $on ? 'true' : 'false' }}}">
    @if ($label)
        <label for="{{ $name }}" class="label"> {{ $label }}</label>
    @endif
    <div class="relative rounded-full w-12 h-6 transition duration-200 ease-linear"
        :class="[ {{ $name }}_on ? 'bg-primary' : 'bg-gray-400']"
        x-on:click=" {{ $name }}_on = ! {{ $name }}_on">
        <label for="{{ $name }}"
            class="absolute left-0 bg-white border-2 my-0.5 mx-1 w-5 h-5 rounded-full transition transform duration-100 ease-linear cursor-pointer"
            :class="[{{ $name }}_on ? 'translate-x-full border-green-400' : 'translate-x-0 border-gray-400']"></label>

        @if ($type === 'radio')
            <input type="radio" class="hidden" name="{{ $name }}" value="0"
                x-bind:checked="! {{ $name }}_on">
            <input type="radio" class="hidden" name="{{ $name }}" value="1"
                x-bind:checked=" {{ $name }}_on">
        @else
            <input type="checkbox" name="{{ $name }}" :checked="{{ $name }}_on"
                class="hidden appearance-none w-full h-full active:outline-none focus:outline-none" />
        @endif
    </div>

</div>
