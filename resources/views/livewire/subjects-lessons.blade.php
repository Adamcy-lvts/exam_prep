<div>
    <!-- Navbar -->

    <div class="min-h-screen px-4 py-10 ">
        <div class="container mx-auto">

            <!-- Lesson Header -->
            <div class="text-center p-8 bg-white dark:bg-zinc-800 rounded-xl shadow-xl mb-10">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-3">{{ $subject->name }} Interactive
                    Lessons for {{$exam->exam_name}}</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Click on a topic to expand and explore its lessons. Each module is carefully designed for effective
                    learning and retention to prepare you for the {{$exam->exam_name}} exams.
                </p>
            </div>

            @foreach ($subject->topics as $topic)
                <!-- Topics Accordion -->
                <div class="space-y-4 mb-4">
                    <!-- Single Topic Accordion -->
                    <div x-data="{ open: false }" class="w-full">
                        <!-- Accordion Button -->
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center bg-white dark:bg-zinc-800 rounded-lg px-6 py-4 text-gray-800 dark:text-white font-semibold cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                            <span>Topic 1: {{ $topic->name }}</span>
                            <svg :class="{ 'transform rotate-180': open }"
                                class="w-6 h-6 transition-transform duration-300 ease-in-out" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- Accordion Content -->
                        <div x-show="open" x-collapse
                            class="mt-2 bg-white dark:bg-zinc-800 rounded-lg shadow-xl p-6 transition duration-300 ease-in-out">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Learning Objectives Card -->
                                <div
                                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Learning
                                        Objectives
                                    </h3>
                                    @foreach ($topic->learning_objectives as $objective)
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $objective }}
                                        </p>
                                    @endforeach

                                </div>

                                <!-- Key Concepts Card -->
                                <div
                                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Key Concepts
                                    </h3>
                                    <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-300">
                                        @foreach ($topic->key_concepts as $concept)
                                            <li>{{ $concept }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Real-World Application Card -->
                                <div
                                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Real-World
                                        Application</h3>
                                    @foreach ($topic->real_world_application as $application)
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $application }}
                                        </p>
                                    @endforeach

                                </div>
                            </div>

                            <!-- Main Content and Sidebar -->
                            <div class="flex flex-wrap -mx-4 mt-6">
                                <!-- Sidebar with Subtopics -->
                                <div class="w-full md:w-1/3 px-4">
                                    <div class="sticky top-0">
                                        <div
                                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-4 border border-gray-300 dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                                                Subtopics
                                            </h3>
                                            <nav class="space-y-1 mb-4">
                                                @foreach ($topic->subtopics as $subtopic)
                                                    <!-- Subtopic Navigation Links -->
                                                    <a href="#subtopic1"
                                                        class="block text-indigo-500 hover:text-indigo-600 transition-colors duration-200">{{ $subtopic->title }}</a>
                                                @endforeach
                                            </nav>
                                            <!-- Exam Readiness Button -->
                                            <a href="{{ route('instructions.page') }}"
                                                class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring focus:border-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800 transition-colors duration-200">
                                                Test Your Readiness
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content Area -->
                                @foreach ($topic->subtopics as $subtopic)
                                    <div class="w-full md:w-2/3 px-4">
                                        <div
                                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 border border-gray-300 dark:border-gray-600">
                                            <!-- Detailed Explanation of Key Concept -->
                                            <h3>{{ $subtopic->title }}</h3>
                                            <div>{!! $subtopic->content !!}</div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <!-- Repeat for each topic -->
                </div>
            @endforeach
        </div>
    </div>

</div>
