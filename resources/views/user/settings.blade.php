<x-app-layout>
    <x-slot name="header">
        {{ __('Nastavení účtu') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ __('Vaše údaje') }}
            </h1>
            <div class="mt-2 space-y-2">
                <x-property name="Email" :value="$user->email"></x-property>
                <x-property name="Jméno" :value="$user->name"></x-property>
            </div>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="card">
                <h1>
                    {{ __('Změnit email') }}
                </h1>
                @if ($errors->has('email'))
                    <x-form.validation-errors class="mb-4" :errors="$errors" />
                @endif
                <form action="{{ route('user.change_email') }}" method="POST" class="flex flex-col">
                    @csrf
                    @method('PUT')
                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="label"> {{ __('Email') }} </label>
                        <input type="email" id="email" class="input" name="email" value="{{ $user->email }}"
                            required />
                    </div>

                    <!-- Save Button -->
                    <input type="submit" class="btn-gray btn md:w-full mt-4" value="Uložit">
                </form>
            </div>

            <div class="card">
                <h1>
                    {{ __('Změnit heslo') }}
                </h1>
                @if ($errors->has('password'))
                    <x-form.validation-errors class="mb-4" :errors="$errors" />
                @endif
                <form action="{{ route('user.change_password') }}" method="POST" class="flex flex-col">
                    @csrf
                    @method('PUT')
                    <!-- New Password -->
                    <div class="space-y-2">
                        <div class="flex flex-col">
                            <label for="password" class="label"> {{ __('Heslo') }} </label>
                            <input type="password" id="password" class="input" name="password"
                                autocomplete="new-password" required />
                        </div>

                        <div class="flex flex-col">
                            <label for="password_confirmation" class="label"> {{ __('Potvrdit heslo') }} </label>
                            <input type="password" id="password_confirmation" class="input" name="password_confirmation"
                                required />
                        </div>
                    </div>
                    <!-- Save Button -->
                    <input type="submit" class="btn-gray btn md:w-full mt-4" value="Změnit heslo">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
