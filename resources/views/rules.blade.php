<x-app-layout>
    <x-slot name="header">
        {{ __('Knihovní řád') }}
    </x-slot>

    <div class="root">
        <article class="card md:w-2/3">
            {!! $rules !!}
        </article>
    </div>
</x-app-layout>
