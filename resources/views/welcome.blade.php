<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <style>
        /* Add smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased">
    {{-- <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white"> --}}
    {{-- @if (Route::has('filament.user.auth.login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/user') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('filament.user.auth.login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('filament.user.auth.register'))
                        <a href="{{ route('filament.user.auth.register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif --}}

    <div class="bg-white" x-data="{ mobileMenuOpen: false }">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <!-- Company Logo -->
                    <a href="#" class="-m-1.5 p-1.5">
                        <img class="h-8 w-auto" src="path-to-your-logo.svg" alt="Exam Prep Logo">
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Open main menu</span>
                        <!-- Hamburger Icon -->
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <!-- Desktop menu -->
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
                    <a href="#about" class="text-sm font-semibold leading-6 text-gray-900">About</a>
                    <!-- Add more navigation links as needed -->
                </div>
                <!-- Login link -->
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="{{ route('filament.user.auth.login') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Log in</a>
                    <a href="{{ route('filament.user.auth.register') }}"
                        class="ml-4 text-sm font-semibold leading-6 text-indigo-600">Register</a>
                </div>
                <!-- Mobile menu, show/hide based on menu open state -->
                <div x-show="mobileMenuOpen" class="lg:hidden" style="display: none;">
                    <div class="fixed inset-0 z-50 bg-gray-600 bg-opacity-50"></div>
                    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm">
                        <!-- Mobile menu content -->
                        <div class="flex items-center justify-between">
                            <a href="#" class="-m-1.5 p-1.5">
                                <img class="h-8 w-auto" src="path-to-your-logo.svg" alt="Exam Prep Logo">
                            </a>
                            <button @click="mobileMenuOpen = false" type="button"
                                class="-m-2.5 rounded-md p-2.5 text-gray-700">
                                <span class="sr-only">Close menu</span>
                                <!-- Close Icon -->
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-6">
                            <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
                            <a href="#about" class="text-sm font-semibold leading-6 text-gray-900">About</a>
                            <!-- Add more mobile navigation links as needed -->
                            <a href="/login"
                                class="block mt-4 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">Log
                                in</a>
                            <a href="/register"
                                class="block mt-4 text-sm font-semibold leading-6 text-indigo-600 hover:bg-gray-50">Register</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>



        <div class="relative isolate px-6 pt-14 lg:px-8">
            <!-- Background gradient shapes -->
            <x-bg-gradient></x-bg-gradient>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    <!-- Consider adding a relevant announcement or remove this if not needed -->
                    <div
                        class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                        Discover our tailored exam preparation tools. <a href="#"
                            class="font-semibold text-indigo-600">Explore <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Master Your Exams with Confidence
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Your journey to academic excellence begins here. Prepare for JAMB, NOUN, and other major exams
                        with our comprehensive practice tests and study materials.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/register"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Get Started
                        </a>
                        <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">
                            Learn More <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Background gradient shapes for bottom -->
            <x-bg-gradient-2></x-bg-gradient-2>
        </div>


        <!-- Features Section -->
        <section id="features" class="py-12 bg-gray-100">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Platform Features</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2">Curated Study Materials</h3>
                        <p class="text-gray-600">Access a wealth of resources including notes, interactive guides, and
                            video tutorials tailored to each exam's syllabus.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2">Practice Tests</h3>
                        <p class="text-gray-600">Challenge yourself with practice exams that mimic the structure and
                            timing of real tests to gauge your readiness.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2">Performance Tracking</h3>
                        <p class="text-gray-600">Monitor your progress with detailed analytics and personalized
                            feedback on your strengths and areas for improvement.</p>
                    </div>
                    <!-- Add more features as needed -->
                </div>
            </div>
        </section>

        <!-- Heading -->
        <div class="text-center mt-10 mb-10">

            <h2 class="text-3xl  font-extrabold text-center text-gray-800">Select the Exam You Want to Prepare For</h2>
        </div>

        <!-- Responsive Grid Container -->
        <div class="container mx-auto px-4">

            @livewire('exams')

        </div>





        <!-- About Section -->
        <section id="about" class="py-12">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">About Us</h2>
                <p class="text-gray-600 text-center max-w-2xl mx-auto">
                    At Exam Prep, we're dedicated to empowering students to achieve their academic goals. With expert
                    educators, our mission is to provide comprehensive, accessible, and effective exam preparation
                    resources.
                </p>
            </div>
        </section>

        {{-- </div> --}}
</body>

</html>
