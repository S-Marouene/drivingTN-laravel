<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function home()
    {
        $exams = Exam::where('is_published', true)->withCount('questions')->latest()->get();
        return view('home', compact('exams'));
    }

    public function show(Exam $exam)
    {
        abort_unless($exam->is_published && $exam->questions()->count() === 30, 404);
        return view('exams.show', ['exam' => $exam->load('questions')]);
    }

    public function submit(Request $request, Exam $exam)
    {
        $questions = $exam->questions()->get();
        abort_unless($exam->is_published && $questions->count() === 30, 404);
        $validated = $request->validate(['answers' => ['required', 'array', 'size:30']]);
        $answers = $validated['answers'];
        $score = 0;
        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && (int) $answers[$question->id] === $question->correct_option) $score++;
        }
        $attempt = ExamAttempt::create([
            'exam_id' => $exam->id,
            'score' => $score,
            'total_questions' => 30,
            'passed' => $score >= 24,
            'answers' => $answers,
        ]);
        return redirect()->route('attempt.result', $attempt);
    }

    public function result(ExamAttempt $attempt)
    {
        return view('exams.result', compact('attempt'));
    }
}
