<div>
    <!-- Subject Page for Natural Sciences -->
    {{-- <div class="min-h-screen flex flex-col items-center justify-center">
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
                @foreach ($subjects as $subject)
                    <div
                        class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                        <div
                            class="absolute inset-0 bg-gray-100 dark:bg-zinc-800 bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                            <div class="border border-purple-200 border-opacity-50 rounded-xl"></div>
                        </div>


                        <a href="{{ route('subjects.lessons', ['subject_id'=>$subject->id, 'exam_id' => $examId, 'field_id' => $fieldId]) }}">
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
                                        {{ $subject->name }}</h3>
                                    <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">Algebra,
                                        Calculus, Statistics, and
                                        more
                                    </p>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach

            </div>
        </div>
    </div> --}}

    {{-- <div>
        <!-- Livewire Component for Subjects Selection -->
        <div x-data="{ selectedSubjects: @entangle('selectedSubjects') }" class="min-h-screen flex flex-col items-center justify-center">
            <div class="container mx-auto ">
                <!-- ... Page Title and Description ... -->

                <!-- Subjects Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Loop through subjects -->
                    @foreach ($subjects as $subject)
                        <div :class="{ 'ring-2 ring-indigo-300': selectedSubjects.includes({{ $subject->id }}) }"
                            class="relative bg-white rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out cursor-pointer shadow-md"
                            @click="selectedSubjects.includes({{ $subject->id }}) ? selectedSubjects = selectedSubjects.filter(id => id !== {{ $subject->id }}) : selectedSubjects.push({{ $subject->id }}); $wire.set('selectedSubjects', selectedSubjects)">
                            <div class="p-5">
                                <div class="flex justify-center">
                                    <!-- Subject Icon -->
                                    <span class="inline-block p-3 rounded-full bg-indigo-100 text-indigo-500">
                                        <!-- Replace with actual icon -->
                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <!-- SVG Path here -->
                                        </svg>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800">{{ $subject->name }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">Algebra, Calculus, Statistics, and more</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="mt-6">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-black rounded-md"
                        wire:click="submitSelection">
                        Submit Selection
                    </button>
                </div>
            </div>
        </div>
       
    </div> --}}

    <div x-data="{ selectedSubjects: @entangle('selectedSubjects'), showCards: true }" x-init="showCards = false;
    setTimeout(() => showCards = true, 50)" class="min-h-screen flex flex-col items-center justify-center">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Title and Description -->
            <div class="text-center py-10">
                <h1 class="text-4xl font-lightbold text-gray-900 sm:text-5xl md:text-6xl">Choose Your Subjects</h1>
                <p class="mt-2 text-base text-gray-500 sm:text-lg md:text-normal">Select four subjects required for the
                    course you applied for or that you registered in your JAMB registration.</p>
            </div>

            <!-- Subjects Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Loop through subjects -->
                @foreach ($subjects as $subject)
                    <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden"
                        :class="{ 'ring-4 ring-indigo-300 ring-opacity-50': selectedSubjects.includes({{ $subject->id }}) }"
                        {{-- class="relative bg-white rounded-xl overflow-hidden transform hover:scale-105 transition duration-300 ease-out cursor-pointer shadow-md" --}}
                        @click="selectedSubjects.includes({{ $subject->id }}) ? selectedSubjects = selectedSubjects.filter(id => id !== {{ $subject->id }}) : selectedSubjects.push({{ $subject->id }}); $wire.set('selectedSubjects', selectedSubjects)">
                        <div class="p-5">
                            <div class="flex justify-center">
                                <!-- Subject Icon -->
                                <span class="inline-block p-3 rounded-full bg-indigo-100 text-indigo-500">
                                    <!-- Replace with actual icon -->
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <!-- SVG Path here -->
                                    </svg>
                                </span>
                            </div>
                            <div class="text-center">
                                <h3 class="mt-3 text-md sm:text-lg font-semibold text-gray-800">{{ $subject->name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $subject->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Actions -->
            <div class="mt-10 text-center">
                <button type="button"
                    class="px-8 py-3 bg-indigo-600 text-white rounded-md shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300"
                    wire:click="submitSelection">
                    Submit Selection
                </button>
            </div>
        </div>
    </div>


    {{-- @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                // Define any Alpine data or methods you want to initialize here.
            });
        </script>
    @endpush --}}

</div>
