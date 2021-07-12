<x-app-layout>
    <x-slot name="header">
        {{ __('Nastavení webu') }}
    </x-slot>
    <div class="root">
        <div class="card">
            <h1> Obecná nastavení </h1>

            <form action="{{ route('admin.edit_web_settings') }}" method="POST">
                @csrf
                @method('put')

                <x-form.validation-errors class="mb-4" :errors="$errors" />
                <div class="flex flex-col gap-6">
                    <div class='space-y-2'>
                        <h4 class="font-semibold text-md text-gray-800">
                            Termíny
                            <x-tooltip class="w-3 inline" data-tooltip="Termíny vypršení výpůjček a rezervací se stanovují při vypůjčení/rezervaci,
                            změna těchto nastavení ovlivní pouze nově vytvořené výpůjčky a rezervace." />
                        </h4>
                        <!-- Borrow time -->
                        <div>
                            <label for="borrow_time" class=""> {{ __('Expirace výpůjčky:') }}

                            </label>
                            <input type="number" id="borrow_time" class="input w-16 ml-4" name="borrow_time"
                                value="{{ Settings::get('borrow_time') }}" required />
                            <span class="text-gray-600"> dní </span>
                            <x-tooltip class="w-3 inline"
                                data-tooltip="Doba, za jakou se od vypůjčení považuje výpůjčka za prošlou" />
                        </div>

                        <!-- Reservation time -->
                        <div>
                            <label for="reservation_time" class=""> {{ __('Expirace rezervace:') }}

                            </label>

                            <input type="number" id="reservation_time" class="input w-16 ml-4" name="reservation_time"
                                value="{{ Settings::get('reservation_time') }}" required />
                            <span class="text-gray-600"> dní </span>
                            <x-tooltip class="w-3 inline"
                                    data-tooltip="Doba, po kterou zůstane kniha rezervovaná. Nevztahuje se na ruční zrušení rezervací" />
                        </div>
                    </div>

                    <div class='space-y-2'>
                        <h4 class="font-semibold text-md text-gray-800"> Emaily</h4>
                        <!-- Send email when borrow expires -->
                        <div class="flex gap-2">
                            <label for="send_email_on_borrow_expiration" class="label">
                                {{ __('Poslat email při expiraci výpůjčky') }}</label>

                            <x-form.toggle name="send_email_on_borrow_expiration"
                                :on="old('send_email_on_borrow_expiration', Settings::get('send_email_on_borrow_expiration'))" />
                            <x-tooltip class="w-3 inline" data-tooltip=" Při zapnutí této možnosti budou zpětně odeslány i emaily dříve expirovaných výpůjček, které
                                nebyly dosud vráceny." />
                        </div>


                    </div>
                    <div>
                        <h4 class="font-semibold text-md text-gray-800"> Kontakt</h4>
                        <!-- Librarian contact -->
                        <div>
                            <label for="contact" class="label"> {{ __('Email na knihovníka') }} </label>
                            <input type="email" id="contact" class="input w-full" name="{{ Settings::contact_librarian }}"
                                value="{{ Settings::get(Settings::contact_librarian) }}" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <input type="submit" class="btn-gray btn w-full" value="Uložit nastavení">
                    </div>
                </div>
            </form>
        </div>
        <div class="flex flex-col gap-4">
            <div class="card">
                <h1> Sbírky </h1>
                <table class="min-w-full tbl">
                    <thead>
                        <tr>
                            <th> {{ __('Id') }} </th>
                            <th> {{ __('Název') }} </th>
                            <th> {{ __('Nálepka') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collections as $collection)
                            <tr>
                                <td> {{ $collection->id }} </td>
                                <td> {{ $collection->name }} </td>
                                <td> {{ $collection->label }} </td>
                                <td>
                                    <a role="button" class="btn-a btn-a-blue"
                                        href="{{ route('admin.book_collection.edit', ['collection' => $collection]) }}">
                                        {{ __('Upravit') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                    {{ __('Žádná sbírka zatím nebyla vytvořena') }}
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="py-2 " colspan="4">
                                <div class="flex justify-center">
                                    <a role="button" class="btn-a btn-a-blue"
                                        href="{{ route('admin.book_collection.add') }}">
                                        {{ __('Přidat novou sbírku') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h1> Dělení maturitní četby </h1>
                <table class="min-w-full tbl">
                    <thead>
                        <tr>
                            <th> {{ __('Id') }} </th>
                            <th> {{ __('Pořadí') }} </th>
                            <th> {{ __('Období') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                            <tr>
                                <td> {{ $section->id }} </td>
                                <td class="text-center"> {{ $section->order }}. </td>
                                <td> {{ $section->name }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                    {{ __('Žádná sekce') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="card">
                <h1> Nálepky </h1>
                <table class="min-w-full tbl">
                    <thead>
                        <tr>
                            <th> {{ __('Id') }} </th>
                            <th> {{ __('Pro') }} </th>
                            <th> {{ __('Nálepka') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stickers as $sticker)
                            <tr>
                                <td> {{ $sticker->id }} </td>
                                <td> {{ $sticker->__toString() }} </td>
                                <td>
                                    <x-stickers :stickers="[$sticker]"> </x-stickers>
                                </td>
                                <td class="flex gap-2">
                                    <a role="button" class="btn-a btn-a-blue"
                                        href="{{ route('admin.sticker.edit', ['sticker' => $sticker]) }}">
                                        {{ __('Upravit') }}
                                    </a>
                                    <form action="{{ route('admin.sticker.delete', ['sticker' => $sticker]) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" class="btn-a btn-a-red" value="{{ __('Smazat') }}">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                    {{ __('Žádná nálepka zatím nebyla vytvořena') }}
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="py-2 " colspan="4">
                                <div class="flex justify-center">
                                    <a role="button" class="btn-a btn-a-blue"
                                        href="{{ route('admin.sticker.add') }}">
                                        {{ __('Přidat novou nálepku') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
