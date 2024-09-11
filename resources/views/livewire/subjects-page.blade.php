<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ selectedSubjects: @entangle('selectedSubjects'), showCards: true, openPanel: 1 }" x-init="showCards = false;
setTimeout(() => showCards = true, 50)">

    <!-- Page Title and Description -->
    <div class="text-center py-10">
        <h1 class="text-4xl font-semibold text-gray-900 sm:text-5xl md:text-6xl">Choose Your Subjects</h1>
        <p class="mt-2 text-lg text-gray-500">Select up to four subjects required for your JAMB registration.</p>
    </div>

    <div class="flex flex-wrap -mx-4">
        <!-- Sidebar -->
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Courses</h2>
                <p class="text-sm text-gray-600 mb-4">Each course has a four(4) default subject combination. <b>Use of
                        English</b> is compulsory for all courses.</p>

                <div>
                    @foreach ($programmes as $index => $programme)
                        <div class="border-b border-gray-200">
                            <button @click="openPanel = openPanel === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                                class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                                :class="{ 'bg-green-100 text-green-700': openPanel === {{ $index + 1 }} }"
                                aria-expanded="openPanel === {{ $index + 1 }}"
                                aria-controls="programme-content-{{ $index + 1 }}">
                                {{ $programme->name }}
                            </button>
                            <div x-show="openPanel === {{ $index + 1 }}" id="programme-content-{{ $index + 1 }}"
                                class="px-4 pb-2">
                                @foreach ($programme->subjects->where('pivot.is_default', true) as $subject)
                                    <button @click="$wire.toggleSubject({{ $subject->id }})"
                                        class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        :class="{
                                            'bg-green-100 text-green-700': selectedSubjects.includes(
                                                {{ $subject->id }})
                                        }"
                                        aria-pressed="selectedSubjects.includes({{ $subject->id }})">
                                        {{ $subject->name }}
                                    </button>
                                @endforeach
                                @if ($programme->subjects->where('pivot.is_default', false)->isNotEmpty())
                                    <h3 class="mt-2 font-bold">Others</h3>
                                    @foreach ($programme->subjects->where('pivot.is_default', false) as $subject)
                                        <button @click="$wire.toggleSubject({{ $subject->id }})"
                                            class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                                            :class="{
                                                'bg-green-100 text-green-700': selectedSubjects.includes(
                                                    {{ $subject->id }})
                                            }"
                                            aria-pressed="selectedSubjects.includes({{ $subject->id }})">
                                            {{ $subject->name }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="w-full lg:w-3/4 px-4">
            <div class="flex items-center justify-between mb-5">
                <label for="search" class="sr-only">Search subjects</label>
                <input type="text" id="search" wire:model.debounce.300ms="search" placeholder="Search subjects..."
                    class="rounded-lg px-4 py-2 border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm md:text-base">
            </div>

            <!-- Subjects Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach ($subjects as $subject)
                    <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-lg shadow-lg overflow-hidden"
                        :class="{ 'border-2 border-green-500': selectedSubjects.includes({{ $subject->id }}) }">
                        <button @click="$wire.toggleSubject({{ $subject->id }})"
                            class="w-full aspect-square p-3 text-center flex flex-col items-center justify-center relative">
                            <div class="flex flex-col items-center">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $subject->name }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($subject->description, 50) }}</p>
                            </div>
                            <div x-show="selectedSubjects.includes({{ $subject->id }})"
                                class="absolute bottom-0 right-0 p-2">
                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>


            <div class="mt-6">
                {{ $subjects->links() }}
            </div>

            <!-- Actions -->
            <div class="mt-10 text-center">
                <button type="button" wire:click="submitSelection"
                    class="px-8 py-3 bg-green-600 text-white rounded-md shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300">
                    Submit Selection
                </button>
            </div>
        </div>
    </div>
</div>
