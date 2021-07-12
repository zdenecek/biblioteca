<x-app-layout>
    <x-slot name="header">
        {{ __('Seznam rezervací') }}
    </x-slot>


    <div class="root">
        <div class="flex flex-col gap-4">
            <div class="card">
                <!-- search -->
                <form method="GET" class="flex flex-col gap-4">
                    <!-- Search bar -->
                    <x-form.search> </x-form.search>
                </form>
            </div>
            <div class="card">
                <h1> {{ __('Akce') }} </h1>
                <form action="{{ route('reservation.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn-a btn-a-red" value="{{ __('Smazat všechny rezervace') }}">

                </form>
            </div>
        </div>
        <div class="card md:w-1/2">
            <table class="min-w-full tbl">
                <thead>
                    <tr>
                        <th> {{ __('Kniha') }} </th>
                        <th> {{ __('Uživatel') }} </th>
                        <th class="text-center"> {{ __('Rezervováno') }} </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr x-data="reservation({{ $reservation }})" x-show.transition.out.800ms=" ! deleted">
                            <td class='underline flex justify-between'>
                                <a href="{{ route('admin.book.detail', ['id' => $reservation->book->id]) }}">
                                    {{ $reservation->book->title }}
                                </a>
                            </td>
                            <td> {{ $reservation->user->name }} </td>
                            <td class="text-sm text-center text-gray-600">
                                {{ $reservation->created_at->format('j. n. Y') }}
                            </td>
                            <td>
                                <button x-on:click="destroy" class="btn-a btn-a-red"> {{ __('Smazat') }} </button>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                @if (request()->has('q'))
                                    {{ __('Žádná rezervace neodpovídá zadání') }}
                                @else
                                    {{ __('Žádná kniha zrovna není rezervovaná') }}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
