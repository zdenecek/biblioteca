<x-app-layout>
    <x-slot name="header">
        {{ __('Půjčit/vrátit') }}
    </x-slot>

    <div class="root" id="biblioteca">

        <borrow-return-form>
            <template v-slot="vm">
                <div class="flex flex-col gap-4 items-center ">
                    <div class="card md:w-100 border-2 border-indigo-500" v-show="vm.state === 'input-book'">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class='my-auto'> {{ __('Zadání knihy') }} </h1>
                            <button class="btn-a btn-a-gray" v-show="! vm.selectedUser" @click="vm.setState('input-user')">
                                {{ __('Zadat uživatele') }}
                            </button>
                        </div>
                        <form class="space-y-4">
                            <!-- Book data -->
                            <div>
                                <label class="label" for="bookInput"> {{ __('Kód knihy') }} </label>
                                <input id="bookInput" ref="bookInput" type="text" class="input w-full" required>
                            </div>
                            <!-- Continue Button -->
                            <button type="submit" class="w-full btn btn-black" @click.prevent="vm.inputBook(true)">
                                {{ __('Pokračovat') }}
                            </button>

                            <!-- Continue without submit Button -->
                            <button type="submit" class="w-full btn btn-gray" @click.prevent="vm.inputBook(false)">
                                {{ __('Pokračovat ale neposílat') }}
                            </button>
                        </form>
                    </div>

                    <div class="card md:w-100 border-2 border-green-500" v-show="vm.state === 'input-user'">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class='my-auto'> {{ __('Zadání Uživatele') }} </h1>
                            <button class="btn-a btn-a-gray" v-show="! vm.selectedBook" @click="vm.setState('input-book')">
                                {{ __('Zadat knihu') }}
                            </button>
                        </div>

                        <form class="space-y-4">
                            <!-- User data -->
                            <div>
                                <label class="label" for="userInput">{{ __('Kód/email uživatele') }} </label>
                                <input id="userInput" ref="userInput" type="text" class="input w-full" required>
                            </div>

                            <!-- Continue Button -->
                            <button type="submit" class="w-full btn btn-black" @click.prevent="vm.inputUser(true)">
                                {{ __('Pokračovat') }}
                            </button>

                            <!-- Continue without submit Button -->
                            <button type="submit" class="w-full btn btn-gray" @click.prevent="vm.inputUser(false)">
                                {{ __('Pokračovat ale neposílat') }}
                            </button>
                        </form>
                    </div>

                    <div class="card  md:w-80 border-2 border-red-500" v-show="vm.state === 'confirm'">
                        <h1> {{ __('Potvrzení') }} </h1>
                        <p> Všechny údaje nutné k odeslání požadavku jsou zadané. Pokračujte kliknutím.</p>

                        <form @submit.prevent="vm.updateState()">
                            <!-- Confirm Button -->
                            <button id="confirmInput" ref="confirmInput" type="submit" class="btn btn-black w-full mt-4">
                                {{ __('Pokračovat') }}
                            </button>
                        </form>
                    </div>

                    <div class="flex gap-4 flex-col md:flex-row items-start">
                        <div class="card border-2 border-indigo-500" v-show="vm.selectedBook">
                            <div class="flex gap-4 items-center pb-2">
                                <h1 class="mb-0">{{ __('Zadaná kniha') }}</h1>

                                <button @click="vm.clearBook()" class="btn-a btn-a-gray" >{{ __('Změnit') }}</button>
                                <a class="btn-a btn-a-blue" :href="vm.bookLink">
                                    {{ __('Detail') }}
                                </a>

                            </div>

                            <div class="flex flex-col gap-2 mt-2">
                                <x-property name="Název">
                                    <span v-text="vm.selectedBook?.title"></span>
                                </x-property>
                                <x-property name="Autor">
                                    <span v-text="vm.selectedBook?.author"></span>
                                </x-property>
                                <x-property name="Sbírka">
                                    <span v-text="vm.selectedBook?.collection?.name"></span>
                                </x-property>
                                <x-property name="Maturitní četba">
                                    <span v-text="vm.selectedBook?.maturita ? 'Ano' : 'Ne'"></span>
                                </x-property>
                                <x-property name="Sekce" v-show="vm.selectedBook?.maturita ">
                                    <span v-text="vm.selectedBook?.section?.name"></span>
                                </x-property>
                                <x-property name="V knihovně od">
                                    <span v-text="vm.showDate(vm.selectedBook?.created_at)"></span>
                                </x-property>
                                <x-property name="Vypůjčená">
                                    <span v-text="vm.selectedBook?.is_borrowed ? 'Ano' : 'Ne'"></span>
                                </x-property>

                                <div v-show="vm.selectedBook?.is_reserved" class="space-y-2 mt-2">
                                    <div class='flex gap-4 items-center'>
                                        <h2 class='mb-0'> Rezervace </h2>
                                        <button class="btn-a btn-a-red"
                                            @click='vm.clearReservation()'>{{ __('Smazat rezervaci') }}</button>
                                    </div>
                                    <x-property name="Rezervoval">
                                        <span v-text="vm.selectedBook?.current_reservation?.user.name "></span>
                                    </x-property>
                                    <x-property name="Rezervováno do">
                                        <span v-text="vm.showDate(vm.selectedBook?.current_reservation?.reserved_until)"></span>
                                    </x-property>
                                </div>
                            </div>

                        </div>
                        <div class="card border-2 border-green-500" v-show="vm.selectedUser">
                            <div class="flex gap-4 items-center pb-2">
                                <h1 class="mb-0">{{ __('Zadaný uživatel') }}</h1>
                                <button class="btn-a btn-a-gray" @click='vm.clearUser()'>{{ __('Změnit') }}</button>
                                <a class="btn-a btn-a-blue" :href="vm.userLink">
                                    {{ __('Detail') }}
                                </a>
                            </div>
                            <div class="flex flex-col gap-2 mt-2">
                                <x-property name="Jméno">
                                    <span v-text="vm.selectedUser?.name"></span>
                                </x-property>
                                <x-property name="Třída">
                                    <span v-text="vm.selectedUser?.school_class ?? 'nevyplněno'"></span>
                                </x-property>
                                <x-property name="Email">
                                    <span v-text="vm.selectedUser?.email"></span>
                                </x-property>
                                <x-property name="Kód">
                                    <span v-text="vm.selectedUser?.code"></span>
                                </x-property>
                                <x-property name="Role">
                                    <span v-text="vm.selectedUser?.role.name"></span>
                                </x-property>
                                <x-property name="Aktivní výpůjčky">
                                    <span v-text="vm.selectedUser?.activeBorrows"></span>
                                </x-property>
                            </div>

                        </div>
                    </div>
                </div>
            </template>
        </borrow-return-form>
    </div>
</x-app-layout>
