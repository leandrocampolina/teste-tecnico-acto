<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Question;
use Illuminate\Http\Request;

class AlternativeManagementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Alternative::class, 'alternative');
    }

    public function index()
    {
        $alternatives = Alternative::with(['question.form'])
            ->whereHas('question')
            ->paginate(15);

        return view('manage.alternatives.index', compact('alternatives'));
    }

    public function create()
    {
        $questions = Question::with('form')->orderBy('text')->get();

        return view('manage.alternatives.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'text' => 'required|string',
            'is_correct' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        $data['is_correct']  = $request->boolean('is_correct');
        $data['order'] = $request->input('order', 0);

        Alternative::create($data);

        return redirect()
            ->route('manage.alternatives.index')
            ->with('success', 'Alternativa criada com sucesso.');
    }

    public function edit(Alternative $alternative)
    {
        $questions = Question::with('form')->orderBy('text')->get();

        return view('manage.alternatives.edit', compact('alternative', 'questions'));
    }

    public function update(Request $request, Alternative $alternative)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'text' => 'required|string',
            'is_correct' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);

        $data['is_correct']  = $request->boolean('is_correct');
        $data['order'] = $request->input('order', 0);

        $alternative->update($data);

        return redirect()
            ->route('manage.alternatives.index')
            ->with('success', 'Alternativa editada com sucesso.');
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete(); // exclusão lógica

        return redirect()
            ->route('manage.alternatives.index')
            ->with('success', 'Alternativa excluída com sucesso.');
    }
}
