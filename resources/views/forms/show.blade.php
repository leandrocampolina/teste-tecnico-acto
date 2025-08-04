<x-layouts.app :title="$form->title">
    <div class="flex flex-col items-center mb-6">
        <h2 class="text-2xl font-bold">{{ $form->title }}</h2>
        <h1>{{ $form->description }}</h1>
    </div>

    <form method="POST" action="{{ route('forms.submit', $form) }}">
        @csrf

        <div class="border rounded">
            @foreach($form->questions as $question)
                <div class="m-4 border p-4">
                    <label style="font-weight:600;">
                        {{ $question->text }}
                        @if($question->is_required) <span style="color:red">*</span> @endif
                    </label>

                    <div class="m-2">
                        @if($question->type === 'multiple_choice')
                            @foreach($question->alternatives as $alt)
                                <div>
                                    <label>
                                        <input type="radio"
                                            name="answers[{{ $question->uuid }}]"
                                            value="{{ $alt->uuid }}"
                                            {{ old("answers.{$question->uuid}") == $alt->uuid ? 'checked' : '' }}>
                                        {{ $alt->text }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($question->type === 'text')
                            <div>
                                <input type="text"
                                    name="answers[{{ $question->uuid }}]"
                                    value="{{ old("answers.{$question->uuid}") }}"
                                    style="width:100%; padding:6px; border:1px solid #ccc;">
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mr-4 mb-4 flex justify-end gap-4">
                <a href="{{ route('manage.forms.index') }}" class="px-4 py-2 bg-red-600 text-white border rounded">Voltar</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded">Enviar resposta</button>
            </div>
        </div>
    </form>
</x-layouts.app>
