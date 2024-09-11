<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ selectedSubjects: @entangle('selectedSubjects'), showCards: true, openPanel: 1 }" x-init="showCards = false;
setTimeout(() => showCards = true, 50)">
    <!-- Page Title and Description -->
    <div class="text-center py-10">
        <h1 class="text-4xl font-semibold text-gray-900 sm:text-5xl md:text-6xl">Choose Your Subjects</h1>
        <p class="mt-2 text-lg text-gray-500">Select four subjects required for the course you applied for or
            that you registered in your JAMB registration.</p>
    </div>

    <div class="flex flex-wrap -mx-4">

        <!-- Sidebar -->
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Courses</h2>
                <!-- Accordion for programmes -->
                <p class="text-sm text-gray-600 mb-4">Each course has a four(4) default subject combination required to
                    apply for the course,<b>Use of English</b> is compulsory for all courses.</p>

                <div>
                    @foreach ($programmes as $index => $programme)
                        <div class="border-b border-gray-200">
                            <button @click="openPanel = openPanel === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                                class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="{ 'bg-indigo-100 text-indigo-700': openPanel === {{ $index + 1 }} }">
                                {{ $programme->name }}
                            </button>
                            <div x-show="openPanel === {{ $index + 1 }}" class="px-4 pb-2">
                                @php
                                    $defaultSubjects = $programme->subjects->filter(function ($subject) {
                                        return $subject->pivot->is_default;
                                    });
                                    $otherSubjects = $programme->subjects->filter(function ($subject) {
                                        return !$subject->pivot->is_default;
                                    });
                                @endphp

                                @foreach ($defaultSubjects as $subject)
                                    <button
                                        @click="selectedSubjects.includes({{ $subject->id }}) ? selectedSubjects = selectedSubjects.filter(id => id !== {{ $subject->id }}) : selectedSubjects.length < 4 ? selectedSubjects.push({{ $subject->id }}) : false; $wire.set('selectedSubjects', selectedSubjects)"
                                        class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        :class="{
                                            'bg-indigo-100 text-indigo-700': selectedSubjects.includes(
                                                {{ $subject->id }})
                                        }">
                                        {{ $subject->name }}
                                    </button>
                                @endforeach
                                @if ($otherSubjects->isNotEmpty())
                                    <li class="mt-2 font-bold">Others</li>
                                    @foreach ($otherSubjects as $subject)
                                        <button
                                            @click="selectedSubjects.includes({{ $subject->id }}) ? selectedSubjects = selectedSubjects.filter(id => id !== {{ $subject->id }}) : selectedSubjects.length < 4 ? selectedSubjects.push({{ $subject->id }}) : false; $wire.set('selectedSubjects', selectedSubjects)"
                                            class="w-full text-left py-2 px-3 rounded-lg mb-2 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            :class="{
                                                'bg-indigo-100 text-indigo-700': selectedSubjects.includes(
                                                    {{ $subject->id }})
                                            }">
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
            <div class="flex items-center justify-between">
                <input type="text" wire:model.live="search" placeholder="Search courses..."
                    class="rounded-lg px-4 mb-5 py-2 border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm md:text-base border">
            </div>

            <!-- Subjects Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Loop through subjects -->
                @foreach ($subjects as $subject)
                    <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden mb-4 sm:mb-0 sm:mr-4"
                        :class="{ 'ring-4 ring-indigo-300 ring-opacity-50': selectedSubjects.includes({{ $subject->id }}) }"
                        @click="selectedSubjects.includes({{ $subject->id }}) ? selectedSubjects = selectedSubjects.filter(id => id !== {{ $subject->id }}) : selectedSubjects.length < 4 ? selectedSubjects.push({{ $subject->id }}) : false; $wire.set('selectedSubjects', selectedSubjects)">
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
                                <h3 class="mt-3 text-lg font-semibold text-gray-800">
                                    {{ $subject->name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $subject->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $subjects->links() }}
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
</div>
