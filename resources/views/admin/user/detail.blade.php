<x-app-layout>

    <x-slot name="header">
        {{ __('Detail uživatele') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <div class="mb-2 flex justify-between items-center">
                <h1 class="mb-0">{{__('Detail uživatele')}}</h1>
                <a role="button" class="btn-a btn-a-blue" href="{{ route('admin.user.edit', ['user' => $user]) }}">
                    {{ __('Upravit') }}
                </a>
            </div>

        <x-admin.user-details :user="$user" header="Detail uživatele"> </x-admin.user-details>
        </div>
    </div>
</x-app-layout>
