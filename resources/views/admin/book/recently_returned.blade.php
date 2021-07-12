<x-app-layout>
    <x-slot name="header">
        {{ __('Nedávno vrácené knihy') }}
    </x-slot>
    <div class="root">

        <div class="card">
            <div class="overflow-x-auto">
                <table class="tbl ">
                    <thead>
                        <tr>
                            <th> {{ __('Id') }} </th>
                            <th> {{ __('Název') }} </th>
                            <th> {{ __('Autor') }} </th>
                            <th> {{ __('Sbírka') }} </th>
                            <th> {{ __('Vráceno') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td> {{ $book->id }} </td>
                                <td> <a class="underline" href="{{ route('admin.book.detail', ['id' => $book->id]) }}">
                                        {{ $book->title }} </a> </td>
                                <td> {{ $book->author }} </td>
                                <td> {{ $book->collection->name }}
                                    @if ($book->maturita && isset($book->section))
                                        <br>
                                        <div class="text-sm text-gray-600 max-w-xs"> {{ $book->section->name }} </div>

                                    @endif
                                </td>
                                <td> {{ $book->borrows->first()?->returned_at }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td class='text-center' colspan="10"> Žádné knihy k zobrazení </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
