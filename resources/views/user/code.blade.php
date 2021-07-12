<x-app-layout>
    <x-slot name="header">
        {{ __('Uživatelský kód') }}
    </x-slot>
    <x-slot name="scripts">
        <script src="{{ asset('js/qr.js') }}" ></script>
    </x-slot>

    <div class="root">
        <div class="card">
            <h1>
                {{ __('Můj kód') }}
            </h1>

            <div class="mt-4 flex justify-center">
                <div id="qrcode"></div>
            </div>


            <script type="text/javascript">
            new QRCode(document.getElementById("qrcode"), "{{$code}}");
            </script>

        </div>

        <div class="card md:max-w-md">
            <h1>
                {{ __('Použití kódu') }}
            </h1>

            <div class="text-gray-700"> Tento kód budete potřebovat, když si budete chtít v knihovně vypůjčit knihu. </div>
            <div class="text-gray-700"> Pokud v knihovně nebudete mít přístup ke kódu, vystačíte si i s emailem. </div>


        </div>
    </div>
</x-app-layout>
