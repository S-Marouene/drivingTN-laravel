<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() { return view('admin.index', ['exams' => Exam::withCount('questions')->latest()->get()]); }
    public function createExam() { return view('admin.exams.create'); }
    public function storeExam(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'is_published' => 'nullable|boolean', 'question_duration_seconds' => 'required|integer|between:5,300']);
        $exam = Exam::create(['title' => $data['title'], 'description' => $data['description'] ?? null, 'is_published' => $request->boolean('is_published', true), 'question_duration_seconds' => $data['question_duration_seconds']]);
        return redirect()->route('admin.exams.edit', $exam)->with('success', 'Examen créé. Ajoutez maintenant ses 30 questions.');
    }
    public function editExam(Exam $exam) { return view('admin.exams.edit', compact('exam')); }
    public function updateExam(Request $request, Exam $exam)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'question_duration_seconds' => 'required|integer|between:5,300']);
        $exam->update([...$data, 'is_published' => $request->boolean('is_published')]);
        return back()->with('success', 'Examen mis à jour.');
    }
    public function destroyExam(Exam $exam) { $exam->delete(); return redirect()->route('admin.index')->with('success', 'Examen supprimé.'); }
    public function createQuestion(Exam $exam) { abort_if($exam->questions()->count() >= 30, 422, 'Cet examen contient déjà 30 questions.'); return view('admin.questions.create', compact('exam')); }
    public function storeQuestion(Request $request, Exam $exam)
    {
        $next = $exam->questions()->count() + 1;
        abort_if($next > 30, 422, 'Un examen doit contenir exactement 30 questions.');
        $data = $request->validate([
            'question_text' => 'required|string', 'option_0' => 'required|string', 'option_1' => 'required|string', 'option_2' => 'required|string',
            'correct_option' => 'required|integer|between:0,2', 'image' => 'nullable|image|max:4096', 'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
        ]);
        $image = $request->file('image')?->store('questions/images', 'public');
        $audio = $request->file('audio')?->store('questions/audio', 'public');
        $exam->questions()->create(['position' => $next, 'question_text' => $data['question_text'], 'image_path' => $image, 'audio_path' => $audio, 'options' => [$data['option_0'], $data['option_1'], $data['option_2']], 'correct_option' => $data['correct_option']]);
        return redirect()->route('admin.exams.edit', $exam)->with('success', "Question {$next}/30 ajoutée.");
    }
    public function editQuestion(Exam $exam, Question $question) { abort_unless($question->exam_id === $exam->id, 404); return view('admin.questions.edit', compact('exam', 'question')); }
    public function updateQuestion(Request $request, Exam $exam, Question $question)
    {
        abort_unless($question->exam_id === $exam->id, 404);
        $data = $request->validate(['question_text' => 'required|string', 'option_0' => 'required|string', 'option_1' => 'required|string', 'option_2' => 'required|string', 'correct_option' => 'required|integer|between:0,2', 'image' => 'nullable|image|max:4096', 'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240']);
        $payload = ['question_text' => $data['question_text'], 'options' => [$data['option_0'], $data['option_1'], $data['option_2']], 'correct_option' => $data['correct_option']];
        if ($request->hasFile('image')) $payload['image_path'] = $request->file('image')->store('questions/images', 'public');
        if ($request->hasFile('audio')) $payload['audio_path'] = $request->file('audio')->store('questions/audio', 'public');
        $question->update($payload);
        return redirect()->route('admin.exams.edit', $exam)->with('success', 'Question mise à jour.');
    }
    public function destroyQuestion(Exam $exam, Question $question)
    {
        abort_unless($question->exam_id === $exam->id, 404); $question->delete();
        $exam->questions()->orderBy('position')->get()->each(fn($q, $i) => $q->update(['position' => $i + 1]));
        return back()->with('success', 'Question supprimée.');
    }
}
