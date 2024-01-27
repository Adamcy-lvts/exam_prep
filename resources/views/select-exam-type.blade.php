{{-- @extends('layouts.app')

@section('content')
<div class="min-h-screen grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 py-6">
    @foreach ($exams as $exam)
        <div x-data="{ hover: false }"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            class="bg-gradient-to-tr from-indigo-100 to-blue-100 rounded-xl shadow-xl transform transition-all duration-500 hover:-translate-y-2 hover:ring-4 ring-indigo-300 p-6 text-center">
            <a href="#">
                <h3 class="text-2xl font-sans font-semibold text-gray-800 mb-4">{{ $exam->exam_name }}</h3>
                <img src="path-to-jamb-logo.svg" alt="JAMB Logo" class="h-20 mx-auto mb-4">
                <p class="font-sans text-gray-800 mb-6">{{ $exam->description }}</p>
                <div class="inline-block bg-indigo-600 text-white font-bold px-6 py-2 rounded-full hover:bg-indigo-700 transition-colors">
                    <a href="{{ route('study-fields', $exam->id) }}" class="font-semibold">Start Preparation <span aria-hidden="true">&rarr;</span></a>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div x-data="{ showCards: true }" x-init="showCards = false;
setTimeout(() => showCards = true, 50)" class="flex justify-center items-center min-h-screen p-6 bg-gray-100">
    <div class="w-full max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-semibold mb-4">Select Your Exam Type</h2>
            <p class="text-lg text-gray-600">Choose an exam to tailor the content including study materials, quizzes, and
                practice exams specifically for your selection.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($exams as $exam)
                <div x-show="showCards" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="transform transition duration-300 ease-in-out hover:scale-105 bg-white rounded-xl shadow-lg overflow-hidden">
                    <a href="{{ $exam->exam_name === 'JAMB' ? route('study-fields', $exam->id) : route('faculties') }}" wire:navigate
                        class="block p-12 h-full text-center hover:bg-gray-50">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $exam->exam_name }}</h3>
                        <img src="path-to-jamb-logo.svg" alt="{{ $exam->exam_name }} Logo" class="h-20 mx-auto mb-4">
                        <p class="text-gray-600 mb-6">{{ $exam->description }}</p>
                        <span class="font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Start
                            Preparation &rarr;</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

