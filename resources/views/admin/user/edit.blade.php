<x-app-layout>
    <x-slot name="header">
        {{ __('Upravit uživatele') }}
    </x-slot>

    <div class="root">
        <div class="card md:w-80" x-data="user({{$user}})">
            <h1>
                {{ 'Úprava uživatele' }}
            </h1>

            <div class='mb-4' x-show="errors">
                <div class="font-medium text-red-600">
                    {{ __('Oi, chyba!') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    <template x-for="error in errors">
                        <li x-text="error"></li>
                    </template>
                </ul>
            </div>

            <form id="userForm" x-ref="userForm"
            x-on:submit.prevent="formData=Object.fromEntries((new FormData($refs.userForm)).entries());
            update(formData).then(() => {window.location.href = document.referrer;})">

                <div class="space-y-2 ">
                    <!-- User id -->
                    <div>
                        <label for="id" class="label">{{ __('Id') }}</label>
                        <input type="text" id="id" class="input w-full" name="id"  x-bind:value="id" disabled>
                    </div>
                    <!-- User email -->
                    <div>
                        <label for="email" class="label"> {{ __('Email') }} </label>
                        <input type="text" id="email" class="input w-full" name="email" x-bind:value="email" disabled>
                    </div>

                    <!-- User name -->
                    <div>
                        <label for="name" class="label"> {{__('Jméno')}} </label>
                        <input type="text" id="name" class="input w-full" name="name" x-model:value="name" autofocus>
                    </div>

                    <!-- User school class -->
                    <div>
                        <label for="school_class" class="label"> {{__('Třída')}} </label>
                        <input type="text" id="school_class" class="input w-full" name="school_class" x-model:value="school_class"  />
                    </div>
                    <!-- User code -->
                    <div>
                        <label for="code" class="label"> {{__('Identifikační Kód')}} </label>
                        <input type="text" id="code" class="input w-full" name="code" x-model:value="code" />
                    </div>


                    <!-- User role -->
                    <div>
                        <label for="role" class="label"> {{__('Role')}} </label>
                        <select id="role" class="input w-full" name="role" x-data='{ roles:{{$roles}} , selected:"{{ $user->role->string }}" }'>
                            <template x-for="role in roles">
                                <option :value="role.string" x-text="role.name" :selected="role.string == selected">
                            </template>
                        <select>
                    </div>
                </div>

                <!-- Submit Button -->
                <input type="submit" class="mt-8  w-full btn btn-black" value="Uložit údaje">
            </form>
        </div>
    </div>

</x-app-layout>
