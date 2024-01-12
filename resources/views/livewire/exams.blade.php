<div>
    <!-- Card for JAMB -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($exams as $exam)
            <div
                class="bg-white bg-opacity-80 backdrop-filter backdrop-blur-lg rounded-lg shadow hover:shadow-lg transition-shadow duration-300 p-6 text-center">
                <a href="#">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $exam->exam_name }}</h3>
                    <img src="path-to-jamb-logo.svg" alt="JAMB Logo" class="h-12 mx-auto mb-4">
                    <p class="text-gray-600 mb-6">{{ $exam->description }}</p>
                    <div
                        class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                        <a href="{{ route('study-fields', $exam->id) }}" class="font-semibold text-indigo-600">Start
                            Preparation <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
