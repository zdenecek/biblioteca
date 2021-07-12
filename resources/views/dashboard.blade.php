<x-app-layout>
    <x-slot name="header">
        {{ __('Nástěnka') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ __("Otevírací hodiny") }}
            </h1>

            <table class="p-2">
                <tbody  x-data="{days: {mon:'Pondělí', tue:'Úterý', wed:'Středa', thu:'Čtvrtek', fri:'Pátek'}}" >

                    @foreach (['mon', 'tue', 'wed', 'thu', 'fri'] as $day)
                    <tr>
                    <td class="py-2 pr-4 text-gray-800" x-text="days.{{$day}}" >  </td>
                    <td class="py-2  font-semibold text-gray-800"> {{$data?->$day ?? __('Zavřeno')}} </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="card md:w-1/2">
            <div>
                {!! $data->about ?? "Vítejte na stránkách knihovny Horního gymnázia v Havířově." !!}
            </div>
        </div>
    </div>
</x-app-layout>
