<div>
    <!-- Subject Page for Natural Sciences -->
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="container mx-auto ">
            <!-- Page Title -->
            <!-- Page Title -->
            <div
                class="flex flex-col justify-center items-center rounded  p-10 text-sm leading-6 text-gray-600 dark:text-gray-300 ring-1 ring-gray-900/10 dark:ring-gray-300/10 dark:hover:ring-gray-200/10 hover:ring-gray-900/20 text-center mb-10 mb-10">
                <h1 class="text-4xl text-gray-800 dark:text-gray-300 font-bold mb-3">Sciences Subjects</h1>
                <h3 class="text-3xl text-gray-800 dark:text-gray-300 font-semibold mb-4">Master Your Sciences Subjects
                </h3>
                <div class="max-w-4xl text-center">
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                        Our curriculum aligns seamlessly with the JAMB syllabus, presenting subjects in summarized
                        forms that are straightforward and focused. We emphasize clear explanations over rote
                        memorization.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Engage with topics that have been distilled to their essence, allowing you to grasp complex
                        concepts intuitively. Our goal is for you to understand and apply knowledge, not just to
                        cram it. Let’s conquer the JAMB together, one clear concept at a time.
                    </p>
                </div>
            </div>



            <!-- Subjects Grid -->

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Mathematics Card -->
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border border-purple-200 border-opacity-50 rounded-xl"></div>
                    </div>

                    @foreach ($subjects as $subject)
                        <a href="{{ route('subjects.lessons', $subject->id) }}">
                            <div class="relative p-5">
                                <div class="flex justify-center">
                                    <!-- Science Icon placeholder -->
                                    <span class="inline-block p-3 rounded-full bg-indigo-100 text-indigo-500">
                                        <!-- Replace with actual science icon -->
                                        <svg class="w-8 h-8" ...></svg>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800 dark:text-gray-300">
                                        {{ $subject->title }}</h3>
                                    <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Algebra,
                                        Calculus, Statistics, and
                                        more
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach


                </div>

                <!-- Physics Card -->
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border border-pink-200 border-opacity-50 rounded-xl"></div>
                    </div>
                    <div class="relative p-5">
                        <div class="flex justify-center">
                            <!-- Art Icon placeholder -->
                            <span class="inline-block p-3 rounded-full bg-pink-100 text-pink-500">
                                <!-- Replace with actual art icon -->
                                <svg class="w-8 h-8" ...></svg>
                            </span>
                        </div>
                        <div class="text-center">
                            <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800 dark:text-gray-300">Physics
                            </h3>
                            <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Mechanics,
                                Thermodynamics,
                                Electromagnetism, and more
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Chemistry Card -->
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border border-yellow-200 border-opacity-50 rounded-xl"></div>
                    </div>
                    <div class="relative p-5">
                        <div class="flex justify-center">
                            <!-- History Icon placeholder -->
                            <span class="inline-block p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <!-- Replace with actual history icon -->
                                <svg class="w-8 h-8" ...></svg>
                            </span>
                        </div>
                        <div class="text-center">
                            <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800 dark:text-gray-300">Chemistry
                            </h3>
                            <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Organic, Inorganic,
                                Physical, and
                                Biochemistry
                                Systems</p>
                        </div>
                    </div>
                </div>

                <!-- Commercial Card -->
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border border-green-200 border-opacity-50 rounded-xl"></div>
                    </div>
                    <div class="relative p-5">
                        <div class="flex justify-center">
                            <!-- Commercial Icon placeholder -->
                            <span class="inline-block p-3 rounded-full bg-green-100 text-green-500">
                                <!-- Replace with actual commercial icon -->
                                <svg class="w-8 h-8" ...></svg>
                            </span>
                        </div>
                        <div class="text-center">
                            <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800 dark:text-gray-300">Biology
                            </h3>
                            <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Economic Theory,
                                Business Studies, and
                                Entrepreneurship</p>
                        </div>
                    </div>
                </div>
                <x-bg-gradient-2></x-bg-gradient-2>
                <!-- Technical Science Card -->
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border border-blue-200 border-opacity-50 rounded-xl"></div>
                    </div>
                    <div class="relative p-5">
                        <div class="flex justify-center">
                            <!-- Technical Science Icon placeholder -->
                            <span class="inline-block p-3 rounded-full bg-blue-100 text-blue-500">
                                <!-- Replace with actual technical science icon -->
                                <svg class="w-8 h-8" ...></svg>
                            </span>
                        </div>
                        <div class="text-center">
                            <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800 dark:text-gray-300">Further
                                Mathematics
                            </h3>
                            <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Engineering, Computer
                                Science, and
                                Information
                                Technology</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
