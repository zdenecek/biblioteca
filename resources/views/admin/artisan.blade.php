<x-app-layout>
    <x-slot name="header">
        {{ __('Artisan') }}
    </x-slot>
    <div class="card">
        <h1> Artisan </h1>
        <form method="POST">
            @csrf
            <textarea id="textarea" name="output" rows="30" class="w-full text-xs"
            x-data="{}" x-init="scroll()"
            readonly >{!! session('output', '') !!}</textarea>
            <div class="flex gap-2">
                <input name="input" class="w-full h-8 border border-gray-600 " >
                <input class="border border-gray-600 px-2" type="submit" value="Odeslat">
            </div>
            <script>
                function scroll() {
                    let textarea = document.getElementById('textarea');
                    textarea.scrollTop = 99999;
                }
            </script>
        </form>
    </div>
</x-app-layout>
