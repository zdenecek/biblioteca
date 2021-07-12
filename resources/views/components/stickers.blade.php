@props(['stickers' => []])

@if(count($stickers))
<span {{$attributes->merge(['class' => 'inline-block '])}}>
@foreach ($stickers as $sticker)
<span title="{{$sticker->__toString()}}"
    style="color: {{ $sticker->text_color ?? '#FFFFFF'}}; background-color: {{ $sticker->bg_color ?? '#6B8E23'}};"
    class="leading-tight inline-block py-0.5 px-1  cursor-default text-xs whitespace-nowrap text-center rounded-md "
    >{{$sticker->text}}</span>
@endforeach
</span>
@endif
