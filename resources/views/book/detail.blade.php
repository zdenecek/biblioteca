<x-app-layout>

    <x-slot name="header">
        {{ __('Detail knihy') }}
    </x-slot>


    <div class="root " id="biblioteca">

        <book-card :book="{{ json_encode($book) }}">
        </book-card>
    </div>


</x-app-layout>
