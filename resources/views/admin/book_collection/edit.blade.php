<x-app-layout>
    <x-slot name="header">
        {{ __('Upravit sbírku') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ 'Úprava sbírky' }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('book_collection.edit', ['collection' => $collection]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <!-- Collection id -->
                    <div>
                        <label for="id" class="label"> {{ __('Id') }} </label>
                        <input type="text" id="id" class="input" name="id" value="{{ $collection->id }}" disabled />
                    </div>

                    <!-- Collection name -->
                    <div>
                        <label for="name" class="label"> {{ __('Název') }} </label>
                        <input type="text" id="name" class="input" name="name" value="{{ old('name', $collection->name) }}">
                    </div>
                </div>

                <!-- Add Book Button -->
                <input type="submit" class="btn btn-black w-full mt-8" value="Uložit údaje">
            </form>
        </div>
    </div>
</x-app-layout>
