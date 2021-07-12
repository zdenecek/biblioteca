<x-app-layout>
    <x-slot name="header">
        {{ __('Upravit knihu') }}
    </x-slot>

    <div class="root">
        <div class="card md:w-96">
            <h1>
                {{ 'Úprava knihy' }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('book.edit', ['book' => $book]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <!-- Book id -->
                    <div>
                        <label for="id" class="label"> {{ __('Id') }} </label>
                        <input type="text" id="id" class="input w-full" name="id" value="{{ $book->id }}"
                            disabled />
                    </div>

                    <!-- Book title -->
                    <div>
                        <label for="title" class="label"> {{ __('Název') }} </label>
                        <input type="text" id="title" class="input w-full" name="title"
                            value="{{ old('title', $book->title) }}" required autofocus>
                    </div>

                    <!-- Book author -->
                    <div>
                        <label for="author" class="label">
                            {{ __('Autor') }}
                            <x-tooltip class="w-3 inline" data-tooltip="Do prvního pole zadejte křestní jméno, do zbylých příjmení, a to tak,
                            že v posledním poli bude příjmení, podle kterého se autor řadí.  <br>
                            Například: Antonie|de|Saint-Exupéry <br>
                            Vyplněno musí být pouze poslední pole. <br>
                            Jména se řadí nejdříve podle posledního pole, pak podle prvního a až nakonec podle prostředního." />
                        </label>
                        <div id="author" class="flex gap-1">
                            <!-- Book author first name -->
                            <div>
                                <input size="7" type="text" id="author_first_name" class="input" name="author_first_name"
                                    value="{{ old('author_first_name', $book->author_first_name) }}">
                            </div>
                            <!-- Book author first name -->
                            <div>
                                <input size="1" type="text" id="author_middle_name" class="input" name="author_middle_name"
                                    value="{{ old('author_middle_name', $book->author_middle_name) }}">
                            </div>
                            <!-- Book author first name -->
                            <div class="block w-full ">
                                <input size="5" type="text" id="author_last_name" class="input w-full " name="author_last_name"
                                    required value="{{ old('author_last_name', $book->author_last_name) }}">
                            </div>
                        </div>
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label class="label" for="isbn"> {{ __('ISBN') }} </label>
                        <input type="text" id="isbn" class="input w-full " name="isbn" value="{{ old('isbn', $book->isbn) }}">
                    </div>

                    <!-- Book code -->
                    <div>
                        <label for="code" class="label"> {{ __('Identifikační Kód') }} </label>
                        <input type="text" id="code" class="input w-full" name="code"
                            value="{{ old('code', $book->code) }}">
                    </div>

                    <!-- Book collection -->
                    <div>
                        <label for="collection" class="label"> {{ __('Sbírka') }} </label>
                        <select id="collection" class="input w-full" name="collection"
                            x-data='{ collections:{{ $collections }} , selected:{{ old('collection', $book->book_collection_id) }} }'>
                            <template x-for="col in collections">
                                <option :value="col.id" x-text="col.name" :selected="col.id == selected">
                            </template>
                        </select>
                    </div>

                    <!-- Maturita & section block -->
                    <div class="space-y-2"
                        x-data="{on: {{ $book->maturita ? 1 : 0 }},
                        sections:{{ $sections }}, selected:{{ old('section', $book->book_section_id ?? 1) }} }">

                        <!-- Is maturita -->
                        <div>
                            <label for="maturita" class="block" class="ml-2 text-sm text-gray-600">
                                <input id="maturita" type="checkbox" class="checkbox" x-model:checked="on" />
                                <span class="ml-2 text-sm text-gray-600"> {{ __('Maturitní četba') }}</span>
                            </label>
                            <input type="radio" class="hidden" name="maturita" value="0" x-bind:checked="! on">
                            <input type="radio" class="hidden" name="maturita" value="1" x-bind:checked="on">
                        </div>

                        <!-- Book section -->
                        <div x-show="on">
                            <label for="section" class="label"> {{ __('Sekce') }} </label>
                            <select id="section" class="input overflow-ellipsis text-xs w-full" name="section">
                                <template x-for="sec in sections">
                                    <option :value="sec.id" x-text="sec.name" :selected="sec.id == selected">
                                </template>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Add Book Button -->
                <input type="submit" class="btn btn-black w-full mt-8" value="Uložit údaje">
            </form>
        </div>
    </div>
</x-app-layout>
