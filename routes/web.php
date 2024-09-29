<?php


use App\Livewire\Exams;
use App\Livewire\Faculty;
use App\Livewire\ExamPage;
use App\Livewire\TestPage;
use App\Livewire\Faculties;
use App\Livewire\QuizResult;
use Illuminate\Http\Request;
use App\Livewire\CoursesPage;
use App\Livewire\PricingPlans;
use App\Livewire\SubjectsPage;
use App\Livewire\StudyFieldPage;
use App\Livewire\InstructionPage;
use App\Livewire\SubjectsLessons;
use App\Livewire\SchoolRegistration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProofOfPaymentController;
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

Route::get('/dashboard')->middleware(['auth'])->name('dashboard');


Route::get('/user-profile', function () {
    // Your profile logic here
})->middleware(['auth'])->name('user.profile');


// Routes requiring authentication, email verification, and step completion
Route::middleware(['auth', 'steps.completed'])->group(function () {

    Route::get('/subject-lessons/{subject_id}', SubjectsLessons::class)->name('subjects.lessons');
    Route::get('/subject/instructions-page', InstructionPage::class)->name('instructions.page');
    Route::get('/jamb/quiz/{compositeSessionId}', TestPage::class)->name('start.quiz');
    Route::get('/jamb/result/{compositeSessionId}', QuizResult::class)->name('quiz.result');
    Route::get('/pricing', PricingPlans::class)->name('pricing-page');
});

// Routes requiring authentication and email verification but not step completion
Route::middleware(['auth', 'prevent-agent'])->group(function () {
    Route::get('/courses/{examId}/', CoursesPage::class)->name('courses.page');
    Route::get('/subjects/{examid}', SubjectsPage::class)->name('subjects.page');
    Route::get('/select-exam-type', Exams::class)->name('choose-exam');
    Route::get('/faculties', Faculties::class)->name('faculties');
    Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);
});

Route::get('/download-proof/{payment}', [ProofOfPaymentController::class, 'downloadProof'])->name('download.proof');

Route::get('/school/register/{token?}', SchoolRegistration::class)->name('school.register');

Route::webhooks('webhook/paystack', 'paystack');

Route::post('/update-theme', function (Request $request) {
    // Update the session with the new theme preference
    session(['dark_mode' => $request->input('dark') ? 'dark' : null]);
    return response()->json(['success' => true]);
});
