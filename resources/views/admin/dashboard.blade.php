<x-app-layout>
    <x-slot name="header">
        {{ __('Administrace') }}
    </x-slot>
    <div class="root">
        <div class="card flex flex-col gap-4 md:flex-row">
            <div class='flex flex-col gap-4'>
                <x-settings-group heading="Půjčování" class="max-w-sm">
                    <a href="{{ route('admin.book.borrow_or_return') }}" class="option"> {{ __('Půjčit/Vrátit') }} </a>
                    <a href="{{ route('admin.borrow.current') }}" class="option"> {{ __('Seznam výpůjček') }} </a>
                    <a href="{{ route('admin.book.recently_returned') }}" class="option"> {{ __('Dnes vrácené knihy') }} </a>
                </x-settings-group>
                <x-settings-group heading="Rezervace">
                    <a href="{{ route('admin.reservation.current') }}" class="option"> {{ __('Seznam rezervací') }}
                    </a>
                </x-settings-group>
            </div>
            <div class='flex flex-col gap-4 md:gap-8'>
                <x-settings-group heading="Správa knih">
                    <a href="{{ route('admin.book.add') }}" class="option"> {{ __('Přidat knihu') }} </a>
                    <a href="{{ route('admin.book.manager') }}" class="option"> {{ __('Spravovat knihy') }} </a>
                </x-settings-group>
                <x-settings-group heading="Správa uživatelů">
                    <a href="{{ route('admin.user.manager') }}" class="option"> {{ __('Spravovat uživatele') }}
                    </a>
                </x-settings-group>
                <x-settings-group heading="Nástěnka">
                    <a href="{{ route('admin.edit_dashboard') }}" class="option"> {{ __('Upravit nástěnku') }} </a>
                </x-settings-group>
            </div>
        </div>
        <div class="card flex flex-col gap-4 md:gap-10 ">
            <x-settings-group heading="Nástroje administrace">
                <a href="{{ route('admin.web_settings') }}" class="option"> {{ __('Nastavení webu') }} </a>
                <a href="{{ route('admin.artisan') }}" class="option"> {{ __('Přístup k CLI') }} </a>
            </x-settings-group>
            <x-settings-group heading="Databáze">
                <a href="{{ route('admin.db.export') }}" class="option"> {{ __('Export') }} </a>
                {{-- <a href="#" class="option "> {{ __('Zálohy databáze') }} </a> --}}
                <a href="{{ route('admin.db.import') }}" class="option"> {{ __('Import knih') }} </a>
                <a href="{{ route('admin.db.import_history') }}" class="option"> {{ __('Historie importů') }} </a>
            </x-settings-group>
            <x-settings-group heading="Knihovní řád">
                <a href="{{ route('admin.edit_rules') }}" class="option"> {{ __('Upravit knihovní řád') }}
                </a>
            </x-settings-group>
            <x-settings-group heading="Emaily">
                <a href="{{ route('admin.email.dashboard') }}" class="option"> {{ __('Odeslané emaily') }} </a>
            </x-settings-group>
        </div>
    </div>
</x-app-layout>
