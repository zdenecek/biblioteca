<x-app-layout>
    <x-slot name="header">
        {{ __('Přidat nálepku') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ __('Přidat nálepku') }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('sticker.add') }}" method="POST">
                @csrf
                <div class="space-y-2">

                    <!-- What is the sticker for -->
                    <div class="space-y-2" x-data='{ stickerables:{!! json_encode($stickerables) !!},
                                    selected_type:`{{ old('stickerable_type', array_key_first($stickerables)) }}`,
                                    selected_id: {{ old('stickerable_id', 1) }} }'
                                    x-init="this.types = Object.keys(stickerables)">
                        <div>
                            <label for="stickerable_type" class="label"> {{ __('Typ nálepky') }} </label>
                            <select id="stickerable_type" class="input w-60" name="stickerable_type" x-ref="type-select"
                                x-on:change="selected_type = $event.target.value">
                                <template x-for="[type, value] in Object.entries(stickerables)">
                                    <option :value="type" x-text="value.name"
                                        :selected="type === selected_type">
                                </template>
                            </select>
                        </div>
                        <div x-show="stickerables[selected_type]['type'] === 'morph'">
                            <label for="stickerable_id" class="label"> {{ __('Objekt') }} </label>
                            <select id="stickerable_id" class="input w-60" name="stickerable_id">
                                <template x-for="st in stickerables[selected_type]['data']">
                                    <option :value="st.id" x-text="st.name" :selected="st.id === selected_id">
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- label -->
                    <div>
                        <label for="text" class="label"> {{ __('Text nálepky') }} </label>
                        <input type="text" id="text" class="input w-full" name="text" value="{{ old('label') }}"
                            placeholder="nezobrazovat (bez nálepky)">
                    </div>

                    <!-- background color -->
                    <div>
                        <label for="bg_color" class="label"> {{ __('Barva nálepky') }} </label>
                        <input type="color" id="bg_color" name="bg_color" class="input h-9"
                            value="{{ old('bg_color', '#00AA00') }}">
                    </div>

                    <!-- text color -->
                    <div>
                        <label for="text_color" class="label"> {{ __('Barva textu nálepky') }} </label>
                        <input type="color" id="text_color" name="text_color" class="input h-9"
                            value="{{ old('label_text_color', '#FFFFFF') }}">
                    </div>
                </div>

                <!-- Add stocler button -->
                <input type="submit" class="mt-8 block w-full btn btn-black" value="Přidat nálepku">
            </form>
        </div>
    </div>
</x-app-layout>
