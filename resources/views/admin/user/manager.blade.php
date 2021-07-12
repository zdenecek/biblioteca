<x-app-layout>
    <x-slot name="header">
        {{ __('Správce uživatelů') }}
    </x-slot>
    <div class="root">
        <div class="flex flex-col justify-center gap-4 items-center">
            <!-- Search block -->
            <div class="card">

                <form method="GET" class="flex flex-col gap-4 md:items-center md:flex-row md:gap-8">
                    <!-- Search bar -->
                <x-form.search> </x-form.search>
                </form>
            </div>

            <div class="card">
                <div class="overflow-x-auto">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <td> {{ __('Id') }} </td>
                                <td> {{ __('Jméno') }} </td>
                                <td> {{ __('Třída') }} </td>
                                <td> {{ __('Kód') }} </td>
                                <td> {{ __('Role') }} </td>
                                <td> {{ __('Datum registrace') }} </td>
                                <td class='text-center'> {{ __('Akce') }}
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr x-data="user({{ $user }})" x-show.transition.duration.400ms="! deleted">
                                    <td> {{ $user->id }} </td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->school_class }} </td>
                                    <td> {{ $user->code }} </td>
                                    <td> {{ $user->role->name }} </td>
                                    <td> {{ $user->created_at->format('d.m.Y') }} </td>
                                    <td>
                                        <div class="flex justify-evenly items-center space-x-1">
                                            <a role="button" class="btn-a btn-a-gray"
                                                href="{{ route('admin.user.detail', ['user' => $user]) }}">
                                                {{ __('Detail') }}
                                            </a>
                                            @unless($user->id === 1)
                                                <a role="button" class="btn-a btn-a-blue"
                                                    href="{{ route('admin.user.edit', ['user' => $user]) }}">
                                                    {{ __('Upravit') }}
                                                </a>
                                                <button class="btn-a btn-a-red"
                                                    x-on:click="alertify.confirm('Opravdu chcete uživatele deaktivovat?', () => destroy())">
                                                    {{ __('Smazat') }}
                                                </button>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class='text-center' colspan="10"> Nic k zobrazení </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
