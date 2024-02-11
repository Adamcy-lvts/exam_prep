<div>

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
