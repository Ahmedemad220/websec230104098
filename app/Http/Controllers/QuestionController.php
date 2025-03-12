<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller {
    public function index() {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    public function create() {
        return view('questions.create');
    }

    public function store(Request $request) {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
        ]);
        Question::create($request->all());
        return redirect()->route('questions.index');
    }

    public function edit($id){
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    
    }

    

    public function update(Request $request, Question $question) {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
        ]);
        $question->update($request->all());
        return redirect()->route('questions.index');
    }

    public function destroy(Question $question) {
        $question->delete();
        return redirect()->route('questions.index');
    }

    public function startExam() {
        $questions = Question::all(); 
        return view('exam.start', compact('questions'));
    }
    

    public function submitExam(Request $request)
{
    $score = 0;
    $questions = Question::all(); // Fetch all questions

    foreach ($questions as $question) {
        if (isset($request->answers[$question->id]) && $request->answers[$question->id] == $question->correct_answer) {
            $score++;
        }
    }

    return view('exam.result', ['score' => $score, 'total' => $questions->count()]);
}

    
}