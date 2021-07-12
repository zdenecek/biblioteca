<x-app-layout>
    <x-slot name="header">
        {{ __('Přidat sbírku') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ __('Údaje o sbírce') }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('book_collection.add') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <!-- Collection name -->
                    <div>
                        <label for="name" class="label"> {{ __('Název') }} </label>
                        <input type="text" id="name" class="input" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <!-- Add collection button -->
                <input type="submit" class="mt-8 block w-full btn btn-black" value="Přidat sbírku">
            </form>
        </div>
    </div>
</x-app-layout>
