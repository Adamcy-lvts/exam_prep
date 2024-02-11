<?php


use App\Livewire\Exams;
use App\Livewire\Faculty;
use App\Livewire\ExamPage;
use App\Livewire\TestPage;
use App\Livewire\Faculties;
use App\Livewire\QuizResult;
use Illuminate\Http\Request;
use App\Livewire\PricingPlans;
use App\Livewire\SubjectsPage;
use App\Livewire\StudyFieldPage;
use App\Livewire\InstructionPage;
use App\Livewire\SubjectsLessons;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\PaymentController;

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

// Route::get('/', [ExamController::class, 'index'])->name('welcome');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// In routes/web.php


// Routes requiring authentication, email verification, and step completion
Route::middleware(['auth', 'verified', 'steps.completed'])->group(function () {
    Route::get('/faculties', Faculties::class)->name('faculties');
    Route::get('/subject-lessons/{subject_id}', SubjectsLessons::class)->name('subjects.lessons');
    Route::get('/subject/instructions-page', InstructionPage::class)->name('instructions.page');
    Route::get('/jamb/quiz/{compositeSessionId}', TestPage::class)->name('start.quiz');
    Route::get('/jamb/result/{compositeSessionId}', QuizResult::class)->name('quiz.result');
    Route::get('/pricing', PricingPlans::class)->name('pricing-page');
    
});

// Routes requiring authentication and email verification but not step completion
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/field-of-study/{id}', StudyFieldPage::class)->name('study-fields');
    Route::get('/subjects/{examid}/{fieldid}', SubjectsPage::class)->name('subjects.page');
    Route::get('/select-exam-type', Exams::class)->name('choose-exam');
 
    Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);
});


Route::webhooks('webhook/paystack', 'paystack');

Route::get('/test', function () {
    dd(env('WEBHOOK_CLIENT_SECRET'));
});


Route::post('/update-theme', function (Request $request) {
    // Update the session with the new theme preference
    session(['dark_mode' => $request->input('dark') ? 'dark' : null]);
    return response()->json(['success' => true]);
});
