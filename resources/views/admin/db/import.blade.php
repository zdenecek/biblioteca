<x-app-layout>
    <x-slot name="header">
        {{ __('Import knih z .csv') }}
    </x-slot>
    <div class="root" id="biblioteca">
        <import-form import-route="{{ route('db.import')}}"> </import-form>
    </div>

</x-app-layout>
