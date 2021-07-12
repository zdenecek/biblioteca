<x-app-layout>
    <x-slot name="header">
        {{ __('Emaily') }}
    </x-slot>


    <div class="root">

        <div class="card">

            <!-- search -->
            <form method="GET">
                <!-- Search bar -->
                <x-form.search> </x-form.search>
            </form>
        </div>

        <div class="card md:w-1/2" >
            <table class="min-w-full tbl">
                <thead>
                        <tr>
                            <td> {{__("Datum")}} </td>
                            <td> {{__("Uživatel")}} </td>
                        </tr>
                </thead>
                <tbody>
                    @forelse($emails as $email)
                        <tr>
                            <td>
                                {{$email->at}}
                            </td>
                            <td > {{$email->to}} </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-6 text-sm text-center text-gray-600" colspan="4">
                                @if(request()->has('q'))
                                {{__("Žádný email neodpovídá zadání")}}
                                @else
                                {{__("Žádný email k zobrazení")}}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">
                {{ $emails->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
