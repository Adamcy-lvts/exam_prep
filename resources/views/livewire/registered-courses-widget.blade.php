<x-filament-widgets::widget>
    <x-filament::section>
        <div class=" space-y-4">
            <div class="text-center">
                <!-- Study Materials Button -->
                <a
                    href="{{ route('filament.user.resources.courses.instruction-page', ['record' => $course->id, 'quizzableType' => $course->getMorphClass()]) }}">
                    <h2 class="uppercase text-lg font-bold mb-2 truncate overflow-hidden whitespace-nowrap"
                        title="{{ $course->course_code }}">
                        {{ $course->course_code }}
                    </h2>
                </a>
                <p class="text-sm truncate overflow-hidden whitespace-nowrap" title="{{ $course->title }}">
                    {{ $course->title }}
                </p>
            </div>
            <div class="flex justify-center gap-4">
                <!-- Take Exam Button -->
                <a href="{{ route('filament.user.resources.courses.instruction-page', ['record' => $course->id, 'quizzableType' => $course->getMorphClass()]) }}"
                    class="font-medium text-green-600 text-sm hover:text-green-500 dark:hover:text-green-400">
                    Take {{ $course->course_code }} → Exam
                </a>


            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
