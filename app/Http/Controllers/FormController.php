<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $forms = Form::where('is_active', true)
            ->withCount(['responses as answered_by_user_count' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->paginate(10);

        return view('forms.index', compact('forms'));
    }

    public function show(Form $form)
    {
        abort_unless($form->is_active, 404);
        $form->load(['questions.alternatives']);
        return view('forms.show', compact('form'));
    }

    public function submit(Form $form, Request $request)
    {
        abort_unless($form->is_active, 403);

        $form->load(['questions.alternatives']);

        $answers = $request->input('answers', []);

        $rules = [];
        foreach ($form->questions as $question) {
            $key = "answers.{$question->uuid}";

            if ($question->type === 'multiple_choice') {
                $validAlternatives = $question->alternatives->pluck('uuid')->toArray();

                $ruleSet = [];
                if ($question->is_required) {
                    $ruleSet[] = 'required';
                } else {
                    $ruleSet[] = 'nullable';
                }
                $ruleSet[] = Rule::in($validAlternatives);

                $rules[$key] = $ruleSet;
            } elseif ($question->type === 'text') {
                if ($question->is_required) {
                    $rules[$key] = ['required', 'string'];
                } else {
                    $rules[$key] = ['nullable', 'string'];
                }
            }
        }

        $validator = Validator::make($request->all(), $rules, [
            'answers.*.in' => 'Resposta inválida para a pergunta.',
        ]);

        $validator->after(function ($v) use ($form, $answers) {
            $missing = collect($form->questions)
                ->filter(fn($q) => $q->is_required)
                ->pluck('uuid')
                ->diff(array_keys($answers));

            if ($missing->isNotEmpty()) {
                $v->errors()->add('answers', 'Você não respondeu todas as perguntas obrigatórias.');
            }
        });

        $validator->validate();

        $questionsSnapshot = $form->questions->map(function ($q) use ($answers) {
            return [
                'uuid' => $q->uuid,
                'text' => $q->text,
                'type' => $q->type,
                'is_required' => $q->is_required,
                'alternatives' => $q->alternatives->map(fn($a) => [
                    'uuid' => $a->uuid,
                    'text' => $a->text,
                    'is_correct' => $a->is_correct,
                ])->toArray(),
                'answer' => $answers[$q->uuid] ?? null,
            ];
        })->toArray();

        $snapshot = [
            'form' => [
                'title' => $form->title,
                'description' => $form->description,
                'is_active' => $form->is_active,
            ],
            'questions' => $questionsSnapshot,
        ];

        DB::transaction(function () use ($form, $snapshot) {
            FormResponse::create([
                'form_id' => $form->id,
                'user_id' => Auth::id(),
                'snapshot' => $snapshot,
            ]);
        });

        return redirect()->route('responses.index')->with('success', 'Resposta salva com sucesso.');
    }
}
