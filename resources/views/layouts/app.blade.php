<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />

    <meta name="application-name" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @livewireScripts

</head>

<body
    class="antialiased bg-gray-100 transition duration-500 ease-in-out">
    <x-bg-gradient></x-bg-gradient>
    {{ $slot }}
    <x-bg-gradient-2 x-show="!isDark"></x-bg-gradient-2>

    @livewire('notifications')



    @filamentScripts
   
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.9.1/dist/gsap.min.js"></script>

</body>

</html>
