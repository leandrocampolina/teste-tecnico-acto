<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormManagementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Form::class, 'form');
    }

    public function index()
    {
        $userId = Auth::id();

        $forms = Form::withCount([
            'questions',
            'responses as answered_by_user_count' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
        ])->paginate(10);

        return view('manage.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('manage.forms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') && (string) $request->input('is_active') === '1';

        Form::create($data);

        return redirect()
            ->route('manage.forms.index')
            ->with('success', 'Formulário criado com sucesso.');
    }

    public function edit(Form $form)
    {
        return view('manage.forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') && (string) $request->input('is_active') === '1';

        $form->update($data);

        return redirect()
            ->route('manage.forms.index')
            ->with('success', 'Formulário editado com sucesso.');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return back()->with('success', 'Excluído.');
    }
}
