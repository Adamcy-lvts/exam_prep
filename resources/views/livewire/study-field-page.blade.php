<div>

    <!-- Background gradient shapes -->

    <div
        class="min-h-screen px-3 sm:px-5 bg-opacity-50 backdrop-filter backdrop-blur-lg mx-auto container flex flex-col items-center justify-center">
        <div
            class="mt-5 px-3 sm:px-5 lg:px-20 bg-opacity-50 backdrop-filter backdrop-blur-lg flex items-center justify-center">
            <div
                class="dark:bg-zinc-800 bg-white bg-opacity-10 rounded-2xl border-3 border-gradient-r-purple-pink-dark p-3 md:p-6 text-center mb-8 shadow-lg max-w-2xl">
                <h2 class="text-lg sm:text-2xl font-bold text-gray-800 dark:text-gray-300 mb-6 uppercase">Forge Your Path
                    to Successful JAMB
                    Examination</h2>
                <p class="text-sm sm:text-md text-gray-700 dark:text-gray-300 mb-8">
                    Embark on a strategic journey of learning and achievement. Tailor your study to your aspirations and
                    prepare
                    diligently for your national exams. The path to university and your future career begins here.
                </p>
                <h3 class="text-sm sm:text-md text-gray-700 dark:text-gray-300 mb-12">Select your discipline, deepen your
                    understanding, and
                    secure your academic success.</h3>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Science Card -->
            @php
                $borderColors = ['border-pink-600', 'border-blue-500', 'border-green-500', 'border-yellow-600', 'border-red-500'];
                $colorIndex = 0;
            @endphp
            @foreach ($studyFields as $studyField)
                @php
                    // Cycle through colors
                    $borderColor = $borderColors[$colorIndex % count($borderColors)];
                    $colorIndex++;
                @endphp
                <div
                    class="relative bg-transparent rounded-xl overflow-hidden transform hover:-translate-y-1 transition duration-500 ease-out">
                    <div
                        class="absolute inset-0 bg-gray-100 dark:bg-zinc-800  bg-opacity-60 backdrop-filter backdrop-blur-md border border-transparent rounded-xl">
                        <div class="border {{ $borderColor }} border-opacity-50 rounded-xl"></div>
                    </div>
                    <a href="{{ route('subjects.page', ['examid' => $examId, 'fieldid' => $studyField]) }}">
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
                                    {{ $studyField->field_name }}</h3>
                                <p class="mt-1 text-sm sm:text-md text-gray-600 dark:text-gray-300">
                                    {{ $studyField->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach



        </div>
    </div>


</div>
