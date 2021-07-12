<x-app-layout>
    <x-slot name="header">
        {{ __('Seznam výpůjček') }}
    </x-slot>


    <div class="root">

        <div class="card">


            <!-- search -->
            <form method="GET" class="space-y-4">
                <!-- search bar -->
                <x-form.search> </x-form.search>

                <!-- Include returned -->
                <x-form.checkbox name="all" :label="__('Taky vrácené')" :checked="request()->has('all')"/>

            </form>
        </div>

        <div class="card md:w-1/2" >
            <table class="min-w-full tbl">
                <thead>
                        <tr>
                            <td> {{__("Kniha")}} </td>
                            <td> {{__("Uživatel")}} </td>
                            <td class="text-center"> {{__("Vypršení")}} </td>
                            @if(request()->has('all'))
                            <td class="text-center"> {{__("Vráceno")}} </td>
                            @endif
                        </tr>
                </thead>
                <tbody>
                    @forelse($borrows as $borrow)
                        <tr>
                            <td class='underline '>
                                <a href="{{route('admin.book.detail', ['id' => $borrow->book->id])}}">
                                    {{ $borrow->book->title}}
                                </a>
                            </td>
                            <td  class='underline' ><a href={{ route('admin.user.detail', ['user' => $borrow->user]) }}>
                                {{ $borrow->user->name }} </a> </td>
                            <td class="text-sm text-center {{$borrow->isAfterDue() ? "text-red-600 font-bold" : "text-gray-600"}}">
                                {{$borrow->borrowed_until->format('j. n. Y')}}
                            </td>

                            @if(request()->has('all'))
                            <td class='flex justify-center'>
                                @if ($borrow->returned)
                                {{$borrow->returned_at->format('j. n. Y')}}
                                @else
                                    <x-cross-mark> </x-cross-mark>
                                @endif
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                @if(request()->has('q'))
                                {{__("Žádná výpůjčka neodpovídá zadání")}}
                                @else
                                {{__("Zrovna není žádná kniha vypůjčená")}}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">
                {{ $borrows->links() }}

            </div>
        </div>

    </div>
</x-app-layout>
