<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ExamPro - Master CBT Exams with Confidence</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
            height: 200px;
        }

        .gsap-text {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            transform: translate(-50%, -50%);
            opacity: 0;
        }
    </style>
</head>

<body class="antialiased bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <header class="fixed inset-x-0 top-0 z-50 bg-white shadow">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="text-2xl font-bold text-green-600">ExamPro</a>
            </div>
            <div class="flex lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-8">
                <a href="#features" class="text-sm font-medium text-gray-700 hover:text-green-600">Features</a>
                <a href="#how-it-works" class="text-sm font-medium text-gray-700 hover:text-green-600">How It Works</a>
                <a href="#pricing" class="text-sm font-medium text-gray-700 hover:text-green-600">Pricing</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="{{ route('filament.user.auth.login') }}"
                    class="text-sm font-medium text-gray-700 hover:text-green-600">Log in</a>
                <a href="{{ route('filament.user.auth.register') }}"
                    class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Sign
                    up</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="mx-auto max-w-3xl pt-32 sm:pt-48 lg:pt-56">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                        Master CBT Exams with Confidence
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Prepare for JAMB and other computer-based tests with our comprehensive practice platform. Get
                        familiar with the CBT format and excel in your exams.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="#"
                            class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Get
                            started</a>
                        <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Learn more <span
                                aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
        </div>

        <section id="features" class="py-24 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Why Choose ExamPro?</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm feature-box">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Authentic CBT Experience</h3>
                        <p class="text-gray-600">Practice with an interface that mimics the actual JAMB CBT environment,
                            ensuring you're fully prepared for the real exam.</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm feature-box">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Comprehensive Question Bank</h3>
                        <p class="text-gray-600">Access thousands of questions from previous JAMB exams and new
                            questions based on the current syllabus.</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm feature-box">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Performance Analytics</h3>
                        <p class="text-gray-600">Track your progress with detailed reports and identify areas for
                            improvement to boost your scores.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-24">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">How It Works</h2>
                <div class="max-w-3xl mx-auto">
                    <ol class="relative border-l border-gray-200">
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white">
                                1
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Sign Up</h3>
                            <p class="mb-4 text-base font-normal text-gray-500">Create your account and choose your exam
                                preparation package.</p>
                        </li>
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white">
                                2
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Practice Tests</h3>
                            <p class="mb-4 text-base font-normal text-gray-500">Take unlimited practice tests in a
                                realistic CBT environment.</p>
                        </li>
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white">
                                3
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Review and Improve
                            </h3>
                            <p class="mb-4 text-base font-normal text-gray-500">Analyze your performance and focus on
                                areas that need improvement.</p>
                        </li>
                        <li class="ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -left-4 ring-4 ring-white">
                                4
                            </span>
                            <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">Ace Your Exam</h3>
                            <p class="mb-4 text-base font-normal text-gray-500">Enter your actual CBT exam with
                                confidence and achieve your best score.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </section>

        <section id="pricing" class="py-24 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Choose Your Plan</h2>
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Free Plan</h3>
                        <p class="text-3xl font-bold mb-6">₦0<span class="text-base font-normal">/month</span></p>
                        <ul class="mb-8 space-y-4">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                5 free attempts per month
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                20 questions per quiz
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Basic performance tracking
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Access to limited question bank
                            </li>
                        </ul>
                        <a href="#"
                            class="block text-center bg-green-600 text-white rounded-md py-2 px-4 hover:bg-green-700 transition duration-300">Get
                            Started</a>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm border-2 border-green-500 relative">
                        <span
                            class="bg-green-500 text-white py-1 px-4 rounded-full text-sm font-bold absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">Most
                            Popular</span>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Pro Plan</h3>
                        <p class="text-3xl font-bold mb-6">₦2500<span class="text-base font-normal">/month</span></p>
                        <ul class="mb-8 space-y-4">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                10 attempts per subjects
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                70 questions per quiz
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Full access to question bank
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Detailed performance analytics
                            </li>
                        </ul>
                        <a href="#"
                            class="block text-center bg-green-600 text-white rounded-md py-2 px-4 hover:bg-green-700 transition duration-300">Choose
                            Pro</a>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Unlimited Plan</h3>
                        <p class="text-3xl font-bold mb-6">₦5,000<span class="text-base font-normal">/month</span></p>
                        <ul class="mb-8 space-y-4">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Unlimited attempts
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Upto 150 questions per quiz
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Full access to all features
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Priority support
                            </li>
                        </ul>
                        <a href="#"
                            class="block text-center bg-green-600 text-white rounded-md py-2 px-4 hover:bg-green-700 transition duration-300">Choose
                            Unlimited</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="py-24">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">What Our Students Say</h2>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <p class="text-gray-600 mb-4">"ExamPro helped me ace my JAMB exam! The practice tests were
                            incredibly similar to the actual CBT exam."</p>
                        <p class="font-semibold text-gray-900">- Chidi O.</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <p class="text-gray-600 mb-4">"The performance analytics helped me focus on my weak areas. I
                            improved my score by 50 points!"</p>
                        <p class="font-semibold text-gray-900">- Amina B.</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <p class="text-gray-600 mb-4">"I felt so confident during my CBT exam because I had practiced
                            so much with ExamPro. Highly recommended!"</p>
                        <p class="font-semibold text-gray-900">- Emeka N.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="py-24 bg-green-600">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-extrabold text-white mb-8">Ready to Excel in Your CBT Exams?</h2>
                <p class="text-xl text-white mb-8">Join thousands of students who have boosted their scores with
                    ExamPro.</p>
                <a href="{{ route('filament.user.auth.register') }}"
                    class="inline-block bg-white text-green-600 rounded-md py-3 px-8 font-semibold hover:bg-gray-100 transition duration-300">Start
                    Your Free Trial</a>
            </div>
        </section>

        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">ExamPro</h3>
                        <p class="text-gray-400">Empowering students to excel in CBT exams.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white">Features</a></li>
                            <li><a href="#pricing" class="text-gray-400 hover:text-white">Pricing</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Legal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Connect</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                    <p class="text-gray-400">&copy; 2024 ExamPro. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // GSAP Animation
            document.addEventListener('DOMContentLoaded', function() {
                // Set initial state for all text sections to invisible
                gsap.set('.gsap-text', {
                    autoAlpha: 0
                });

                // Function to animate the entrance and exit for each text element
                function animateTextElements(textContainer) {
                    // Define selectors for the child elements
                    const heading = textContainer.querySelector('.gsap-heading');
                    const paragraph = textContainer.querySelector('.gsap-paragraph');

                    // Create a timeline for this container
                    const tl = gsap.timeline({
                        onStart: () => gsap.set(textContainer, {
                            autoAlpha: 1
                        }),
                        onComplete: () => gsap.set(textContainer, {
                            autoAlpha: 0
                        })
                    });

                    // Animate the heading and paragraph entering
                    tl.fromTo(heading, {
                            x: -400,
                            autoAlpha: 0
                        }, {
                            x: 0,
                            autoAlpha: 1,
                            duration: 2,
                            ease: 'power3.out'
                        })
                        .fromTo(paragraph, {
                            x: 400,
                            autoAlpha: 0
                        }, {
                            x: 0,
                            autoAlpha: 1,
                            duration: 2,
                            ease: 'power3.out'
                        }, "<")
                        // Add a slight delay before exiting
                        .to({}, {
                            duration: 4
                        }) // Time visible on screen before starting to exit
                        // Animate the heading and paragraph exiting in opposite directions
                        .to(heading, {
                            x: 400,
                            autoAlpha: 0,
                            duration: 1,
                            ease: 'power3.in'
                        })
                        .to(paragraph, {
                            x: -400,
                            autoAlpha: 0,
                            duration: 1,
                            ease: 'power3.in'
                        }, "<");

                    return tl;
                }

                // Calculate total animation time per text container
                const enterDuration = 2; // Time for text to slide in
                const visibleDuration = 4; // Time text remains visible
                const exitDuration = 1; // Time for text to slide out
                const totalDurationPerText = enterDuration + visibleDuration +
                    exitDuration; // Total time each text is animated

                // Create a master timeline that will control when each text container's animations play
                const masterTl = gsap.timeline({
                    repeat: -1
                });

                // Add each text container's animations to the master timeline
                document.querySelectorAll('.gsap-text').forEach((text, index) => {
                    masterTl.add(animateTextElements(text), index * totalDurationPerText);
                });

                // Calculate repeat delay to eliminate gap at the end before restarting
                masterTl.repeatDelay(0);

                // Start the master timeline
                masterTl.play();
            });
        </script>

</body>

</html>
