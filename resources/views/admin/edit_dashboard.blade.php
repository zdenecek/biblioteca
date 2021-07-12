<x-app-layout>
    <x-slot name="header">
        {{ __('Úprava nástěnky') }}
    </x-slot>

    <x-slot name="scripts">
        @include('includes.mce_scripts')
    </x-slot>

    <form action="{{ route('edit_dashboard') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="root">
            <div class="card">
                <h1> {{ __('Otevírací hodiny') }} </h1>

                <x-form.validation-errors class="mb-4" :errors="$errors" />
                <div class='space-y-2'
                    x-data="{days: {mon:'Pondělí', tue:'Úterý', wed:'Středa', thu:'Čtvrtek', fri:'Pátek'}, data:{} }">
                    @foreach (['mon', 'tue', 'wed', 'thu', 'fri'] as $day)
                        <div>
                            <x-label :for="$day" x-text="days.{{ $day }}" />
                            <x-input placeholder="Zavřeno" :id="$day" type="text" :name="$day"
                                :value="old($day, $data->$day)" />
                        </div>
                    @endforeach
                    {{-- TODO --}}
                </div>
            </div>

            <div class="card md:w-1/2">
                <label class="label" for="editor">
                    {{__("Nástěnka")}}
                </label>
                <textarea rows="25" class="input w-full h-full " id="editor" type="text" name="about"
                    placeholder="Vítejte...">{{ old('about', $data->about) }}</textarea>
            </div>

            <div class="card">
                <h1> {{ __('Akce') }} </h1>
                <input type="submit" class='btn btn-black mt-4' type="submit" value="{{ __('Uložit') }}">
            </div>
        </div>
    </form>

</x-app-layout>
