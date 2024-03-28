<div>
    <div x-data="{ showCards: true }" x-init="showCards = false;
    setTimeout(() => showCards = true, 50)"
        class="flex justify-center items-center min-h-screen p-6 bg-gray-100">
        <div class="w-full max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-lg sm:text-3xl font-semibold mb-4">Select Your Faculty</h2>
                <p class="text-lg text-gray-600"></p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach ($faculties as $faculty)
                    <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden">
                        <a href="{{ route('courses.page', $faculty->id) }}" wire:navigate
                            class="block p-12 h-full text-center hover:bg-gray-50">
                            <h3 class="text-md md:text-2xl uppercase font-semibold text-gray-800 mb-2">
                                {{ $faculty->faculty_name }}</h3>

                            <p class="text-gray-600 mb-6">{{ $faculty->description }}</p>

                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</div>
