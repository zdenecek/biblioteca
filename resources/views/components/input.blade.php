@props(['disabled' => false])

@php
    $classes = $disabled ?
        "text-gray-400 input"
        : "input";
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
