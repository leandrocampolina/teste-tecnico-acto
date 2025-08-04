<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Form;
use Illuminate\Http\Request;

class QuestionManagementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    public function index()
    {
        $questions = Question::with('form')->paginate(15);

        return view('manage.questions.index', compact('questions'));
    }

    public function create()
    {
        $forms = Form::orderBy('title')->get();

        return view('manage.questions.create', compact('forms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'form_id' => 'required|exists:forms,id',
            'text' => 'required|string',
            'type' => 'required|in:multiple_choice,text',
            'is_required' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        $data['is_required'] = $request->boolean('is_required');
        $data['order'] = $request->input('order', 0);

        Question::create($data);

        return redirect()
            ->route('manage.questions.index')
            ->with('success', 'Pergunta criada com sucesso.');
    }

    public function edit(Question $question)
    {
        $forms = Form::orderBy('title')->get();

        return view('manage.questions.edit', compact('question', 'forms'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'form_id' => 'required|exists:forms,id',
            'text' => 'required|string',
            'type' => 'required|in:multiple_choice,text',
            'is_required' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        $data['is_required'] = $request->has('is_required') ? (bool) $request->input('is_required') : false;
        $data['order'] = $request->input('order', 0);

        $question->update($data);

        return redirect()
            ->route('manage.questions.index')
            ->with('success', 'Pergunta editada com sucesso.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->route('manage.questions.index')
            ->with('success', 'Pergunta excluída com sucesso.');
    }
}
