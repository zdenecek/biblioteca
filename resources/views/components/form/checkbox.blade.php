@props(['name', 'checked' =>false, 'label' => "", 'type' => 'checkbox'])

<div {{$attributes}} x-data="{ {{$name}}_on: {{$checked ? 'true' : 'false'}}}">

    <label for="{{$name}}" class="block" class="ml-2 text-sm text-gray-600">
        <input @if($type === 'checkbox') name="{{$name}}" @endif id="{{$name}}" type="checkbox" class="checkbox" x-model:checked=" {{$name}}_on"/>
        @if($label)
        <span class="ml-2 text-sm text-gray-600"> {{ $label }}</span>
        @endif
    </label>
    @if($type === 'radio')
    <input type="radio" class="hidden" name="{{$name}}" value="0" x-bind:checked="! {{$name}}_on">
    <input type="radio" class="hidden" name="{{$name}}" value="1" x-bind:checked=" {{$name}}_on">
    @endif
</div>
