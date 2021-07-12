@props(['code' => "chyba", 'text' => "Něco se pokazilo"])
<x-guest-layout>
    <div class="text-center flex flex-col justify-center h-screen">
        <div class="text-lg text-primary">
            {{$code}} | {{$text}}
        </div>
        <a href="{{ route('dashboard')}}" class="underline font-medium text-gray-700">  {{ __('Domů') }} </a>

            {{$slot}}
    </div>

</x-guest-layout>
