<x-app-layout>
    <x-slot name="header">
        {{ __('Katalog knih v knihovně') }}
    </x-slot>

    <div class="root" id="biblioteca">
        <book-catalog>
            <template v-slot="vm">
                <!-- Search block -->
                <div class="card">
                    <form
                        class="flex flex-col gap-4 flex-wrap sm:items-center sm:flex-row sm:gap-8 md:items-start md:flex-col md:gap-4">

                        <!-- Search bar -->
                        <search-bar v-model:query="vm.searchQuery"> </search-bar>

                        <div class="flex flex-col gap-2 items-start">
                            <h2> Filtry </h2>

                            <catalog-filter v-model:active="vm.filterMaturita" title="Jen maturitní četba"
                                :initial="{{json_encode(request()->has('maturita'))}}"> </catalog-filter>

                            <catalog-filter v-model:active="vm.filterAvailable" title="Jen dostupné"
                                :initial="{{json_encode(request()->has('maturita'))}}" />
                            </catalog-filter>

                            <catalog-filter v-model:active="vm.filterChildren" title="Jen dětská knihovna"
                                :initial="{{json_encode(request()->has('children'))}}" />
                            </catalog-filter>

                        </div>


                    </form>
                </div>
                <div class="card min-w-1/2">
                    <table class="tbl min-w-full">
                        <thead>
                            <tr>
                                <td> {{ __('Kniha') }} </td>
                                <td> {{ __('Dostupnost') }} </td>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="book in vm.books" v-if="vm.booksTotal > 0" :key="book.id">
                                <td>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div>
                                                
                                                <span class="mr-2 space-x-1" v-if="book.stickers">
                                                   
                                                    <span v-for="sticker in book.stickers" :title="sticker.name"
                                                        :style="'position: relative; top: -3px; color:' + (sticker.text_color ?? '#FFFFFF') + ';background-color:' + (sticker.bg_color ?? '#6B8E23') + ';'"
                                                        class="inline-block py-0.5 px-1  cursor-default text-xs whitespace-nowrap text-center rounded-md ">
                                                    @{{ sticker.text}}</span>
                                                   
                                                </span>
                                                
                                                <a :href="book.routes['detail']">
                                                    <span
                                                        class=" text-xl max-w-md font-semibold py-0.5 text-gray-800 inline-block">
                                                        @{{ book.title }}
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="max-w-md">@{{ book.author }}</div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                        <div class="max-w-xs text-sm text-gray-600">
                                            @{{ book.state }}
                                        </div>

                                        <button v-if="book?.is_available" class='btn-a btn-a-blue'
                                            @click="vm.reserve(book)">
                                            {{ __('Rezervovat') }}
                                        </button>


                                    </div>
                                </td>
                            </tr>

                            <tr v-else-if="vm.booksTotal === 0">
                                <td colspan="4">
                                    <div class='text-center'> Nic takového tady není </div>
                                </td>
                            </tr>

                            <tr v-else>
                                <td colspan="4">
                                    <div class="mx-auto flex justify-center gap-2 p-1">
                                        <div class='loader w-6 h-6'> </div> <span class="text-gray-600 text-center">
                                            Knihy se načítají... </span>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>


                    <div class="flex justify-center">
                        <paginator :current-page="vm.currentPage" :total="vm.booksTotal" :per-page="vm.perPage"
                            :on-page-changed="vm.pageChanged" />
                    </div>


                </div>
            </template>
        </book-catalog>

    </div>
</x-app-layout>