<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <title>{{ $title ?? 'Jour Apps' }}</title>
    @livewireStyles
</head>

<body class="h-full">

    {{ $slot }}

    @livewireScripts

</body>

</html>