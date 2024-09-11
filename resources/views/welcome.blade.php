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
        html {
            scroll-behavior: smooth;
        }

        .feature-box {
            position: relative;
            overflow: hidden;
        }

        .feature-box:before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            bottom: -2px;
            right: -2px;
            background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
            background-size: 300% 300%;
            z-index: 1;
            opacity: .5;
            border-radius: 4px;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0 50%;
            }
        }

        .gsap-text-container {
            position: relative;
            /* This makes it a positioning context for absolutely positioned children */
            height:
                /* The height of your largest .gsap-text element */
            ;
        }

        .gsap-text {
            position: absolute;
            top: 50%;
            /* Center vertically */
            left: 50%;
            /* Center horizontally */
            width: 100%;
            transform: translate(-50%, -50%);
            /* Adjusts for the width and height to truly center */
            opacity: 0;
        }
    </style>
</head>

<body class="antialiased" x-data="{ mobileMenuOpen: false }">
     <header class="fixed inset-x-0 top-0 z-50 bg-white shadow" x-bind:class="{ 'bg-gray-900 text-white': mobileMenuOpen }">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
             <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <img class="h-8 w-auto" src="path-to-your-logo.svg" alt="Exam Prep Logo">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="rounded-md p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#features"
                    class="text-sm font-semibold leading-6 text-gray-900 hover:text-green-600">Features</a>
                <a href="#about" class="text-sm font-semibold leading-6 text-gray-900 hover:text-green-600">About</a>
                <a href="#premium"
                    class="text-sm font-semibold leading-6 text-gray-900 hover:text-green-600">Premium</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                @auth
                    <form method="POST" action="{{ route('filament.user.auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:ring-green-500">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('filament.user.auth.login') }}"
                        class="text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:ring-green-500">Log
                        in</a>
                    <a href="{{ route('filament.user.auth.register') }}"
                        class="ml-4 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:ring-green-500">Register</a>
                @endguest
            </div>
            <div x-show="mobileMenuOpen" x-transition
                class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right lg:hidden">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5">
                        <div class="flex items-center justify-between">
                            <img class="h-8 w-auto" src="path-to-your-logo.svg" alt="Exam Prep Logo">
                            <button @click="mobileMenuOpen = false" type="button"
                                class="rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:ring-green-500">
                                <span class="sr-only">Close menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <nav class="grid gap-y-8">
                            <a href="#features"
                                class="text-base font-medium text-gray-900 hover:text-green-600">Features</a>
                            <a href="#about" class="text-base font-medium text-gray-900 hover:text-green-600">About</a>
                            <a href="#premium"
                                class="text-base font-medium text-gray-900 hover:text-green-600">Premium</a>
                        </nav>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="bg-white">
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <!-- Background gradient shapes -->
            <x-bg-gradient></x-bg-gradient>
            <div class="mx-auto max-w-2xl mb-10 flex justify-center">
                <div
                    class="rounded-full px-3 py-1 mt-28 mb-14 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20 transition-all duration-500 ease-in-out">
                    Discover our tailored exam preparation tools. <a href="#"
                        class="font-semibold text-green-600">Explore →</a>
                </div>
            </div>
            <div class="mx-auto max-w-2xl pt-16 sm:pt-34 mb-24 lg:pt-28 gsap-text-container">
                <div class="mx-auto max-w-2xl pt-16 sm:pt-34 mb-24 lg:pt-28 gsap-text-container">

                    <div class="gsap-text text-center">
                        <h1
                            class="text-2xl sm:text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl text-shadow-lg gsap-heading">
                            Master Your Exams with Confidence
                        </h1>
                        <p class="mt-6 text-md sm:text-lg leading-8 text-gray-600 gsap-paragraph">
                            Your journey to academic excellence begins here. Prepare for JAMB, NOUN, and other major
                            exams
                            with our comprehensive practice tests and study materials.
                        </p>

                    </div>
                    <!-- Second Set -->
                    <div class="gsap-text text-center">
                        <h1
                            class="text-2xl sm:text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl text-shadow-lg gsap-heading">
                            Realistic Mock Exams Await
                        </h1>
                        <p class="mt-6 text-md sm:text-lg leading-8 text-gray-600 gsap-paragraph">
                            Sharpen your test-taking skills with free limited attempts on our mock exams. Gain the edge
                            you
                            need for your actual test.
                        </p>

                    </div>

                    <!-- New Third Set -->
                    <div class="gsap-text text-center">
                        <h1
                            class="text-2xl sm:text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl text-shadow-lg gsap-heading">
                            Tailored Study Plans
                        </h1>
                        <p class="mt-6 text-md sm:text-lg leading-8 text-gray-600 gsap-paragraph">
                            Custom study experiences designed for your specific exam prep needs. Engage with
                            personalized
                            content that adapts to your learning progress.
                        </p>

                    </div>


                </div>
            </div>
            <!-- Call to Action Buttons -->
            <div class="flex items-center mb-24 justify-center gap-x-6">
                <a href="/register"
                    class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition-all duration-500 ease-in-out gsap-button">Get
                    Started</a>
                <a href="#features"
                    class="text-sm font-semibold leading-6 text-gray-900 transition-all duration-500 ease-in-out gsap-button">Learn
                    More →</a>
            </div>
            <!-- Background gradient shapes for bottom -->
            <x-bg-gradient-2></x-bg-gradient-2>
        </div>

        <!-- Features Section -->
        <section id="features" class="py-12 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Platform Features</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Feature 1 -->
                        <div class="bg-white rounded-lg p-6 feature-box">
                            <h3 class="text-xl font-semibold mb-2">Curated Study Materials</h3>
                            <p class="text-gray-600">Access a wealth of resources including notes, interactive guides,
                                and
                                video tutorials tailored to each exam's syllabus.</p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="bg-white rounded-lg p-6 feature-box">
                            <h3 class="text-xl font-semibold mb-2">Practice Tests</h3>
                            <p class="text-gray-600">Challenge yourself with practice exams that mimic the structure
                                and
                                timing of real tests to gauge your readiness.</p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="bg-white rounded-lg p-6 feature-box">
                            <h3 class="text-xl font-semibold mb-2">Performance Tracking</h3>
                            <p class="text-gray-600">Monitor your progress with detailed analytics and personalized
                                feedback on your strengths and areas for improvement.</p>
                        </div>
                        <!-- Add more features as needed -->
                    </div>
                </div>
        </section>

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
    </div>
</body>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mobileMenu', () => ({
            open: false,

            toggle() {
                this.open = !this.open;
            },

            close() {
                this.open = false;
            }
        }));
    });
</script>

</html>
