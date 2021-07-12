<x-app-layout>
    <x-slot name="header">
        {{ __('Export dat z databáze') }}
    </x-slot>

    <div class="root">

        <div class="card">
            <h1>Nastavení csv</h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('db.export') }}" >

                <div class="space-y-4">


                    <x-form.toggle name="include_headers" label="Exportovat s názvy sloupců (headers)" :on="old('include_deleted')"  />
                    <x-form.toggle name="include_deleted" label="Exportovat smazané záznamy" :on="old('include_deleted')" />

                {{-- OMG DEEPWATCHING --}}
                <fieldset class="space-y-2" x-data="{ checkboxes: {
                        @foreach ($tables as $table_name=> $data) {{ $table_name }}: {{ old($table_name, 'false') }}, @endforeach
                    }, all: false }"
                    x-on:toggle="all = Object.values(checkboxes).every(a => a);">
                    <legend>
                        <h2> Tabulky </h2>
                    </legend>

                    <div class="flex gap-2 items-center">
                        <input type="checkbox" class="checkbox" id="all" x-ref="all" x-model:checked="all" x-on:input="Object.keys(checkboxes).forEach(k => checkboxes[k] = $event.target.checked);
                                $dispatch('all', $event.target.checked); ">
                        <label for="all" class="label"> {{ __('Vše') }} </label>
                    </div>

                    <ul class="ml-4 space-y-2">
                        @foreach ($tables as $table_name => $table_data)
                            <li class="flex gap-2 items-center">
                                <input type="checkbox" class="checkbox" name="tables[{{ $table_name }}]"
                                    x-ref="{{ $table_name }}" id="{{ $table_name }}"
                                    x-model:checked="checkboxes.{{ $table_name }}"
                                    x-on:input="$nextTick(() => $dispatch('toggle'));"
                                    x-on:all.window="$refs.{{ $table_name }}.checked = $event.detail;">
                                <label for="{{ $table_name }}" class="label"> {{ $table_data['string'] }} </label>
                            </li>
                        @endforeach
                    </ul>

                </fieldset>
            </div>
                <input type="submit" value="Exportovat" class="mt-8 btn btn-black w-full">
            </form>
        </div>
    </div>
</x-app-layout>
