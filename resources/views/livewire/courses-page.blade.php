<div x-data="{ showCards: true }" x-init="showCards = false;
setTimeout(() => showCards = true, 50)" class="p-6 container mx-auto max-w-6xl">
    <div class="text-center py-10">
        <h1 class="text-4xl font-semibold text-gray-900 sm:text-5xl md:text-6xl">Choose Your Courses</h1>
        <p class="mt-2 text-lg text-gray-500">Select the courses you want to register and prepare for the exam.</p>
        <p>You can select a course by clicking on it and deselect it by clicking on it again.</p>
    </div>

    <div class="flex items-center justify-between mb-5">
        <input type="text" wire:model.live="search" placeholder="Search courses..."
            class="rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm md:text-base border">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
        @foreach ($courses as $course)
            <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden p-6 cursor-pointer"
                wire:click="toggleCourse({{ $course->id }})"
                :class="{ 'border-2 border-green-500': @js(in_array($course->id, $this->selectedCourses)) }">
                <h3 class="text-2xl font-bold text-center">{{ $course->course_code }}</h3>
                <h3 class="text-sm font-semibold text-center mt-2">{{ $course->title }}</h3>
                <p class="mt-2 text-sm">{{ Str::limit($course->description, 100) }}</p>
                <p class="mt-2 text-xs text-center text-gray-500">Faculty: {{ $course->faculty->faculty_name }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>

    <div class="mt-10 text-center">
        <button wire:click="registerCourses"
            class="px-8 py-3 bg-green-600 text-white rounded-md shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300">
            Submit Selection
        </button>
    </div>
</div>
