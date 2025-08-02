<!DOCTYPE html>
<html lang="pt-BR" data-theme="cupcake">

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

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <link rel="apple-touch-icon" href="{{ asset('favicons/pwa-logos/icon-192x192.png') }}">
    <meta name="mobile-web-app-capable" content="yes">

    {{-- <meta name="viewport" content="viewport-fit=cover"> --}}

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

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(() => console.log('Service Worker registrado'))
                .catch((error) => console.log('Erro ao registrar Service Worker', error));
        }
    </script>

</body>

</html>
