<x-app-layout>
    <x-slot name="header">
        {{ __('Katalog knih v knihovně') }}
    </x-slot>
    <div class="root">

        <div class="flex flex-col justify-center gap-4 items-center ">
            <!-- Search block -->
            <div class="card">

                <form method="GET" class="flex flex-col gap-4 md:items-center md:flex-row md:gap-8">
                    <!-- Book title -->
                    <x-form.search> </x-form.search>
                </form>
            </div>
            <div class="card ">
                <div class="overflow-x-auto">
                    <table class="tbl overflow-x-auto">
                        <thead>
                            <tr>
                                <th> {{ __('Id') }} </th>
                                <th> {{ __('Název') }} </th>
                                <th> {{ __('Autor') }} </th>
                                <th> {{ __('Kód') }} </th>
                                <th> {{ __('Sbírka') }} </th>
                                <th> {{ __('Datum přidání') }} </th>
                                <th class="text-center"> {{ __('Dostupnost') }} </th>
                                <th class="text-center"> {{ __('Akce') }}
                                <th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr x-data="book({{$book->toJson()}})"  x-show.transition.duration.400ms="! deleted" >
                                    <td> {{ $book->id }} </td>
                                    <td> {{ $book->title }} </td>
                                    <td> {{ $book->author }} </td>
                                    <td> {{ $book->code }} </td>
                                    <td> {{ $book->collection->name }}</td>
                                    <td> {{ $book->created_at->format('j. n. Y') }} </td>
                                    <td class="text-center text-gray-600 w-48 py-1 text-sm">
                                        {{ $book->getState()->stringForUser() }} </td>
                                    <td>
                                        <div class="flex justify-evenly items-center space-x-1">
                                            <a role="button" class="btn-a btn-a-gray" href="{{ route('admin.book.detail', ['id' => $book->id]) }}">
                                                {{ __('Detail') }}
                                            </a>
                                            <a  role="button" class="btn-a btn-a-blue" href="{{ route('admin.book.edit', ['book' => $book]) }}">
                                                {{ __('Upravit') }}
                                            </a>
                                            <button class="btn-a btn-a-red" x-on:click="alertify.confirm('Opravdu chcete knihu smazat?', () => destroy())">
                                                {{ __('Smazat') }}
                                            </button>

                                        </div>
                                    </td>
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
    </div>
</x-app-layout>
