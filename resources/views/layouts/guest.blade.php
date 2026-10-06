<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pengaduan Masyarakat') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
            <!-- Logo -->
            <div class="mb-8 text-center flex flex-col items-center">
                <img src="{{ asset('images/logo-md.png') }}" alt="Logo Pengaduan Masyarakat" class="w-16 h-16 object-contain mb-4" />
                <h1 class="text-xl font-bold text-gray-900">Pengaduan Masyarakat</h1>
                <p class="text-sm text-gray-500 mt-1">Kelurahan Meranti Pandak</p>
            </div>

            <div class="w-full max-w-md bg-white rounded-xl border border-gray-200 shadow-sm px-8 py-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
