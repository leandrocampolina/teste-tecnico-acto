<x-layouts.app title="Editar Alternativa">
  <div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Editar Alternativa</h2>
      <a href="{{ route('manage.alternatives.index') }}" class="px-4 py-2 border rounded text-sm hover:underline">Voltar</a>
    </div>

    <form method="POST" action="{{ route('manage.alternatives.update', $alternative) }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
      @csrf
      @method('PUT')

      <div class="grid gap-6">
        <div>
          <label class="block font-medium text-sm mb-1" for="question_id">Pergunta</label>
          <select name="question_id" id="question_id" required class="w-full border rounded px-3 py-2">
            @foreach($questions as $question)
              <option value="{{ $question->id }}" {{ $alternative->question_id == $question->id ? 'selected' : '' }}>
                {{ Str::limit($question->text, 50) }} ({{ $question->form->title ?? '—' }})
              </option>
            @endforeach
          </select>
          @error('question_id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block font-medium text-sm mb-1" for="text">Texto da Alternativa</label>
          <textarea name="text" id="text" required rows="2" class="w-full border rounded px-3 py-2">{{ old('text', $alternative->text) }}</textarea>
          @error('text') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
          <div class="flex items-center gap-2">
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="is_correct" value="1" {{ old('is_correct', $alternative->is_correct) ? 'checked' : '' }} class="form-checkbox" />
              <span>Correta</span>
            </label>
          </div>

          <div>
            <label class="block font-medium text-sm mb-1" for="order">Ordem</label>
            <input type="number" name="order" id="order" value="{{ old('order', $alternative->order) }}" class="w-full border rounded px-3 py-2" />
            @error('order') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-4">
        <a href="{{ route('manage.alternatives.index') }}" class="px-4 py-2 bg-red-600 text-white border rounded">Cancelar</a>
        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded">Atualizar</button>
      </div>
    </form>
  </div>
</x-layouts.app>
