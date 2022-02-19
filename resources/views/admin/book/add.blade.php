<x-app-layout>
    <x-slot name="header">
        {{ __('Přidat knihu') }}
    </x-slot>

    <div class="root">
        <div class="card md:w-96">
            <h1>
                {{ __('Údaje o knize') }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('book.add') }}" method="POST">
                @csrf

                <div class="space-y-2">
                    <!-- Book title -->
                    <div>
                        <label class="label" for="title"> {{ __('Název') }} </label>
                        <input type="text" id="title" class="input w-full " name="title" value="{{ old('title') }}"
                            required autofocus>
                    </div>

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
                                <input size="5" type="text" id="author_first_name" class="input" name="author_first_name"
                                    value="{{ old('author_first_name') }}">
                            </div>
                            <!-- Book author first name -->
                            <div>
                                <input size="2" type="text" id="author_middle_name" class="input" name="author_middle_name"
                                    value="{{ old('author_middle_name') }}">
                            </div>
                            <!-- Book author first name -->
                            <div class="block w-full ">
                                <input size="5" type="text" id="author_last_name" class="input w-full " name="author_last_name"
                                    required value="{{ old('author_last_name') }}">
                            </div>
                        </div>
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label class="label" for="isbn"> {{ __('ISBN') }} </label>
                        <input type="text" id="isbn" class="input w-full " name="isbn" value="{{ old('isbn') }}">
                    </div>


                    <!-- Book code -->
                    <div>
                        <label for="code" class="label"> {{ __('Identifikační Kód') }} </label>
                        <input type="text" id="code" class="input w-full" name="code" value="{{ old('code') }}" required>
                    </div>

                    <!-- Book collection -->
                    <div>
                        <label for="collection" class="label"> {{ __('Sbírka') }} </label>
                        <select id="collection" class="input w-full" name="collection"
                            x-data='{ collections:{{ $collections }} , selected:{{ old('collection', 1) }} }'>
                            <template x-for="col in collections">
                                <option :value="col.id" x-text="col.name" :selected="col.id == selected">
                            </template>
                        </select>
                    </div>

                    <!-- Maturita & section block -->
                    <div class="space-y-2" x-data="{on: {{ old('maturita', false) ? 'true' : 'false' }},
                        sections:{{ $sections }}, selected:{{ old('section', 1) }} }">

                        <!-- Is maturita -->
                        <div>
                        <label for="maturita" class="block" class="ml-2 text-sm text-gray-600">
                            <input id="maturita" type="checkbox" class="checkbox" x-model:checked="on"/>
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
                <input type="submit" class="mt-8 w-full btn btn-black" value="Přidat knihu">
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
