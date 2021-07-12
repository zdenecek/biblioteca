@php
$email = Settings::get(Settings::contact_librarian);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{  config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->

    @include("includes.alertify_scripts")
    @include("includes.tippy_scripts")

    @include("includes.analytics_scripts")
    @include("includes.server_side_notifications")
    @include("includes.vue_scripts")
    <script src="{{ asset('js/library.js') }}" defer></script>


    @isset($scripts)
        {{ $scripts }}
    @endisset
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="font-semibold text-xl text-gray-800 leading-tight mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="py-12 mx-auto w-full">
            {{ $slot }}
        </main>

        <footer class="bg-white shadow-xl md:flex justify-center md:gap-32 mt-auto pb-6">
            <div class="flex flex-col mt-6 justify-center">
                <div class="text-sm text-gray-600 text-center md:w-32 ">
                    &copy; Školní knihovna Horního gymplu v&nbsp;Havířově
                </div>
            </div>
            @if($email)
            <div class="flex flex-col items-center md:items-start mt-6">
                <h3 class="text-gray-700 font-semibold"> Kontakt </h3>
                <div class="text-sm text-gray-600">
                    Knihovník:

                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </div>

            </div>
            @endif
        </footer>
    </div>
</body>

</html>
