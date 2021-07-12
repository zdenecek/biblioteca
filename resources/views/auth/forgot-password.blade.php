<x-guest-layout>
    <x-form.auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Zapomněli jste heslo? Žádné strachy, pošleme vám link na jeho obnovení na email.') }}
        </div>

        <!-- Session Status -->
        <x-form.auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-form.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <input type="submit" class="btn btn-black" value="{{__('Obnovit heslo')}}">

            </div>
        </form>
    </x-form.auth.card>
</x-guest-layout>
