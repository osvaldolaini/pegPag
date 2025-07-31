<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Minha Empresa') }}</title>

    <x-layouts.shopping.favicons />

    <meta name="description" content="{{ $meta_description ?? 'Descrição padrão' }}" />
    <meta name="keywords" content="{{ $meta_keywords ?? '' }}" />
    <meta property="og:title" content="{{ $title ?? config('app.name') }}" />
    <meta property="og:description" content="{{ $meta_description ?? '' }}" />
    <meta property="og:image" content="{{ $meta_image ?? asset('images/seo-default.jpg') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
    {{-- Menu principal (fixo/sticky) --}}
    <div class="sticky top-0 z-50">
        <x-layouts.shopping.header />
    </div>

    <main class="flex-grow container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    @livewireScripts
    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(() => console.log('Service Worker registrado'))
                .catch((error) => console.log('Erro ao registrar Service Worker', error));
        }
    </script>
    @yield('scripts')

    @yield('push')
</body>

</html>
