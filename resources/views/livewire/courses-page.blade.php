<div>

    <div x-data="{ showCards: true, openPanel: 1 }" x-init="showCards = false;
    setTimeout(() => showCards = true, 50)" class="p-6 container mx-auto max-w-6xl">
        <div class="text-center py-10">
            <h1 class="text-4xl font-semibold text-gray-900 sm:text-5xl md:text-6xl">Choose Your Courses</h1>
            <p class="mt-2 text-lg text-gray-500">Select the courses you want to register and prepare for the exam.</p>
            <p>You can select a course by clicking on it and deselect it by clicking on it again.</p>
        </div>

        <div class="flex items-center justify-between">


            <input type="text" wire:model.live="search" placeholder="Search courses..."
                class="rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm md:text-base border">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            @foreach ($courses as $course)
                <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden p-6 mb-4 sm:mb-0 sm:mr-4 cursor-pointer"
                    wire:click="toggleCourse({{ $course->id }})"
                    style="{{ in_array($course->id, $this->selectedCourses) ? 'border: 2px solid green;' : '' }}">
                    <h3 class="text-2xl font-bold text-center">{{ $course->course_code }}</h3>
                    <h3 class="text-sm font-semibold text-center mt-2">{{ $course->title }}</h3>
                    <p class="mt-2">{{ $course->description }}</p>
                    <p class="mt-2 text-xs text-center text-gray-500">Faculty: {{ $course->faculty->faculty_name }}</p>
                </div>
            @endforeach
        </div>
        {{ $courses->links() }}
        <button wire:click="registerCourses"
            class="mt-4 px-4 py-2 bg-green-500 text-white rounded transform transition duration-500 ease-in-out hover:scale-105">Submit
            courses</button>
    </div>
</div>
