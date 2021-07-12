<x-app-layout>
    <x-slot name="header">
        {{ __('Historie importů') }}
    </x-slot>
    <div class="root" >
        <div class="card">
            <h1> Seznam importů </h1>
            <table class="tbl min-w-full">
                <thead>
                    <tr>
                        <th> {{ __('Id') }} </th>
                        <th> {{ __('Název') }} </th>
                        <th> {{ __('Datum') }} </th>
                        <th> {{ __('Importováno knih') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($imports as $import)
                        <tr>
                            <td>  {{ $import->id }}</td>
                            <td> {{ $import->name }} </td>
                            <td>
                                {{ $import->created_at->format('g:i:s, j. n. Y') }}
                            </td>
                            <td>
                                {{ $import->books_count }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-600">
                                {{ __('Zatím neproběhl žádný import') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
