<x-app-layout>
    <x-slot name="header">
        {{ __('Úprava knihovního řádu') }}
    </x-slot>

    <x-slot name="scripts">
        @include('includes.mce_scripts')
    </x-slot>
    <form action="{{ route('edit_rules') }}" method="POST">
        <div class="root">

            @method('PUT')
            @csrf


            <div class="card md:w-2/3">
                <h1>
                    {{ __('Knihovní řád') }}
                </h1>

                <x-form.validation-errors class="mb-4" :errors="$errors" />

                <x-label for="editor" value="knihovní řád" />
                <textarea rows="25" class="input w-full h-full " id="editor" type="text" name="rules"
                    placeholder="Vítejte...">{{ old('rules', $rules) }}</textarea>
            </div>

            <div class="card">
                <h1>
                    {{ __('Akce') }}
                </h1>

                <input type="submit" class='btn btn-black mt-4' type="submit" value="{{ __('Uložit') }}">
            </div>
        </div>
    </form>
</x-app-layout>
