<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="theme()"
    class="{{ session('dark_mode', 'dark') }}">

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
    class="antialiased {{ session('dark_mode', 'dark') ? 'dark:bg-custom-dark' : 'bg-gray-100' }} bg-gray-100 transition duration-500 ease-in-out">
    <x-bg-gradient></x-bg-gradient>
    {{ $slot }}
    <x-bg-gradient-2 x-show="!isDark"></x-bg-gradient-2>

    @livewire('notifications')

    <!-- Theme Toggle Button -->
    <div class="fixed top-5 right-5">
        <button @click="toggleTheme"
            class="bg-white dark:bg-gray-800 p-2 rounded-full focus:outline-none focus:ring focus:border-blue-300">
            <span x-show="!isDark"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                    <path
                        d="M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z" />
                </svg></span> <!-- Sun icon for light mode -->
            <span x-show="isDark"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                    <path
                        d="M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z" />
                </svg></span> <!-- Moon icon for dark mode -->
        </button>
    </div>


    @filamentScripts
    <script>
        function theme() {
            return {
                // Initialize isDark based on the 'dark_mode' session value. Default to 'dark' if not set.
                isDark: '{{ session('dark_mode', 'dark') }}' === 'dark',

                // Define the function to toggle the dark mode.
                toggleTheme() {
                    // Toggle the isDark state. If it was true, set to false, and vice versa.
                    this.isDark = !this.isDark;

                    // Toggle the 'dark' class on the <html> element based on the isDark state.
                    document.documentElement.classList.toggle('dark', this.isDark);

                    // Toggle the 'dark:bg-custom-dark' class on the <body> element based on the isDark state.
                    // This applies the custom dark background color when dark mode is on.
                    document.body.classList.toggle('dark:bg-custom-dark', this.isDark);

                    // Toggle the 'bg-gray-100' class on the <body> element based on the inverse of the isDark state.
                    // This applies a light background color when dark mode is off.
                    document.body.classList.toggle('bg-gray-100', !this.isDark);

                    // Make an AJAX POST request to the '/update-theme' route to update the session value for dark mode.
                    fetch('/update-theme', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel's security.
                        },
                        body: JSON.stringify({
                            dark: this.isDark // Send the updated isDark state to the server.
                        })
                    }).then(() => {
                        // Optional: Force a page reload to reflect the new dark mode state across the whole site.
                        // Currently commented out, meaning the page will not reload automatically.
                        // window.location.reload();
                    });
                },
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.9.1/dist/gsap.min.js"></script>

</body>

</html>
