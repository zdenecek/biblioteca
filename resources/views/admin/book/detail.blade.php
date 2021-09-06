<x-app-layout>

    <x-slot name="header">
        {{ __('Detail knihy') }}
    </x-slot>

    <div class="root">
        <div class="card">

            <div class="flex justify-between">
                <h1>{{ $book->title }}</h1>
                @unless($book->trashed())
                    <a class="btn-a btn-a-blue" href="{{ route('admin.book.edit', ['book' => $book]) }}">
                        {{ __('Upravit') }}
                    </a>
                @endunless

            </div>
            <div class="space-y-2 mt-4">
                <x-property name="Název" :value="$book->title" />
                <x-property name="Autor" :value="$book->author" />
                <x-property name="Dostupnost" :value="$book->getState()->stringForUser()" />
                <x-property name="Isbn" :value="$book->isbn" />
                <x-property name="Kód" :value="$book->code" />
                <x-property name="Sbírka" :value="$book->collection->name" />
                <x-property name="Maturitní četba" :value="$book->maturita? 'Ano' : 'Ne '" />
                <x-property name="Sekce" :value="$book->section ? $book->section->name : null" />
                <x-property name="Datum přidání do knihovny" :value="$book->created_at->format('j. n. Y')" />
                <x-property name="Datum poslední úpravy" :value="$book->updated_at? $book->updated_at->format('j. n. Y') : null" />

            </div>
        </div>
            <div class="card md:w-1/3 space-y-4">
                <h1>
                    {{ __('Historie výpůjček') }}
                </h1>

                <x-property name="Počet výpůjček" :value="$borrows->count()" />

                <table class="tbl min-w-full">
                    <thead>
                        <tr>
                            <th> {{ __('Uživatel') }} </th>
                            <th> {{ __('Vypůjčeno od') }} </th>
                            <th> {{ __('Vráceno') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($borrows as $borrow)
                            <tr>
                                <td> <a href={{ route('admin.user.detail', ['user' => $borrow->user]) }}>
                                        {{ $borrow->user->name }} </a> </td>
                                <td> {{ $borrow->created_at->format('j. n. Y') }} </td>
                                <td>
                                    @if ($borrow->returned)
                                        {{ $borrow->returned_at->format('j. n. Y') }}
                                    @else
                                        <x-cross-mark />
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-600">
                                    {{ __('Kniha zatím nebyla vypůjčena') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</x-app-layout>
