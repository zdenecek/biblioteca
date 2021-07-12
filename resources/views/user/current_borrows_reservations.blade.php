<x-app-layout>
    <x-slot name="header">
        {{ __('Mé výpůjčky a rezervace') }}
    </x-slot>

    <div class="md:flex justify-center">
        <div class="md:flex md:w-1/2 flex-col gap-4">
            <div class="card">
                <h1>
                    {{__('Rezervace')}}
                </h1>
                <table class="min-w-full tbl">
                    <thead>
                        <tr>
                            <th class="w-1/2"> {{ __('Kniha') }} </th>
                            <th class="w-1/2"> {{ __('Datum rezervace') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr class="text-gray-800 border-b-2 border-gray-200">
                                <td class='flex justify-between'>
                                    {{ $reservation->book->title }}
                                </td>
                                <td
                                    class="text-gray-600">
                                    {{ $reservation->created_at->format('j. n. Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                    {{ __('Zrovna nemáte rezervovanou žádnou knihu') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card" >
                <h1>
                {{__('Výpůjčky')}}
                </h1>
                <table class="min-w-full tbl">
                    <thead>
                        <tr>
                            <th class="w-1/2"> {{ __('Kniha') }} </th>
                            <th class="w-1/2"> {{ __('Vypršení') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $borrow)
                            <tr class="text-gray-800 border-b-2 border-gray-200">
                                <td class='flex justify-between'>
                                    {{ $borrow->book->title }}
                                </td>
                                <td
                                    class="{{ $borrow->isAfterDue() ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                    {{ $borrow->borrowed_until->format('j. n. Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                    {{ __('Zrovna nemáte půjčenou žádnou knihu') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </h1>
        </div>
    </div>
</x-app-layout>
