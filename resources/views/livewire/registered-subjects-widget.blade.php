<x-filament-widgets::widget>
    <x-filament::section>
        <a href="{{ route('filament.user.resources.subjects.lessons', ['subjectId' => $subject->id]) }}">
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">{{ $subject->name }}</h2>

                <div class="space-y-4">

                    {{-- <!-- Take Quiz Option -->
                <a href="{{ route('filament.user.resources.courses.instruction-page', ['record' => $subject->id, 'quizzableType' => $subject->getMorphClass()]) }}" class="inline-block bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                    Take {{$subject->name}} Quiz
                </a> --}}

                    <!-- Take Exam Button -->
                    <a href="{{ route('filament.user.resources.subjects.instruction-page', ['record' => $subject->id, 'quizzableType' => $subject->getMorphClass()]) }}"
                        class="font-medium text-green-600 text-sm hover:text-green-500 dark:hover:text-green-400">
                        Take {{ $subject->name }} → Exam
                    </a>

                    {{-- <!-- Simulate JAMB Exam Option -->
                <a href="{{ route('instructions.page') }}" class="inline-block bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700 transition duration-300">
                    Simulate JAMB Exam
                </a> --}}
                </div>
            </div>
        </a>
    </x-filament::section>
</x-filament-widgets::widget>
