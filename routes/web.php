<?php

use App\Livewire\ExamPage;
use App\Livewire\TestPage;
use Illuminate\Http\Request;
use App\Livewire\SubjectsPage;
use App\Livewire\StudyFieldPage;
use App\Livewire\InstructionPage;
use App\Livewire\SubjectsLessons;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return redirect('user/login');
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/field-of-study', StudyFieldPage::class)->name('study-fields');

Route::get('/subjects', SubjectsPage::class)->name('subjects.page');

Route::get('/subjects/lessons/{id}', SubjectsLessons::class)->name('subjects.lessons');

Route::get('/subject/instructions-page/{id}', InstructionPage::class)->name('instructions.page');

Route::get('/subject/questions/{id}', TestPage::class)->name('start.exam');

Route::post('/update-theme', function (Request $request) {
    // Update the session with the new theme preference
    session(['dark_mode' => $request->input('dark') ? 'dark' : null]);
    return response()->json(['success' => true]);
});




