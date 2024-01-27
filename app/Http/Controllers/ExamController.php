<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $exams = Exam::all();
        // Only get exams where the name is 'JAMB' or 'NOUN'
        $exams = Exam::whereIn('exam_name', ['JAMB', 'NOUN'])->get();

        return view('select-exam-type', ['exams' => $exams]);
    }


  
}
