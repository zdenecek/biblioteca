<x-app-layout>
    <x-slot name="header">
        {{ __('Upravit nálepku') }}
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ 'Úprava nálepky' }}
            </h1>

            <x-form.validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('sticker.edit', ['sticker' => $sticker]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <!-- sticker id -->
                    <div>
                        <label for="id" class="label"> {{ __('Id') }} </label>
                        <input type="text" id="id" class="input w-full" name="id" value="{{ $sticker->id }}" disabled />
                    </div>

                    <!-- What is the sticker for -->
                    <div class="space-y-2" x-data='{ stickerables:{!! json_encode($stickerables) !!},
                                    selected_type:`{{ old('stickerable_type', $sticker->stickerable_type  ?? $sticker->type) }}`,
                                    selected_id: {{ old('stickerable_id', $sticker->stickerable_id ?? 0) }} }'
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

                    <!-- Sticker text -->
                    <div>
                        <label for="text" class="label"> {{ __('Text nálepky') }} </label>
                        <input type="text" id="text" class="input w-full" name="text" value="{{ old('text', $sticker->text) }}" placeholder="nezobrazovat (bez nálepky)">
                    </div>

                    <!-- Sticker background color -->
                    <div>
                        <label for="bg_color" class="label"> {{ __('Barva nálepky') }} </label>
                        <input type="color" id="bg_color" name="bg_color" class="input md h-9" value="{{old('bg_color', $sticker->bg_color)}}">
                    </div>

                    <!-- Sticker text color -->
                    <div>
                        <label for="text_color" class="label"> {{ __('Barva textu nálepky') }} </label>
                        <input type="color" id="text_color" name="text_color" class="input md h-9" value="{{old('label_text_color', $sticker->text_color)}}">
                    </div>
                </div>

                <!-- Add Sticker Button -->
                <input type="submit" class="btn btn-black w-full mt-8" value="Uložit údaje">
            </form>
        </div>
    </div>
</x-app-layout>
