<x-layouts.app title="Criar Pergunta">
  <div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Criar Pergunta</h2>
      <a href="{{ route('manage.questions.index') }}" class="px-4 py-2 border rounded text-sm hover:underline">Voltar</a>
    </div>

    <form method="POST" action="{{ route('manage.questions.store') }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
      @csrf

      <div class="grid gap-6">
        <div>
          <label class="block font-medium text-sm mb-1" for="form_id">Formulário</label>
          <select name="form_id" id="form_id" required class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            @foreach($forms as $form)
              <option value="{{ $form->id }}" {{ old('form_id') == $form->id ? 'selected' : '' }}>{{ $form->title }}</option>
            @endforeach
          </select>
          @error('form_id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block font-medium text-sm mb-1" for="text">Texto da Pergunta</label>
          <textarea name="text" id="text" required rows="3" class="w-full border rounded px-3 py-2">{{ old('text') }}</textarea>
          @error('text') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
          <div>
            <label class="block font-medium text-sm mb-1" for="type">Tipo</label>
            <select name="type" id="type" required class="w-full border rounded px-3 py-2">
              <option value="multiple_choice" {{ old('type') === 'multiple_choice' ? 'selected' : '' }}>Múltipla Escolha</option>
              <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Texto</option>
            </select>
            @error('type') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
          </div>

          <div>
            <label class="block font-medium text-sm mb-1" for="order">Ordem</label>
            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" class="w-full border rounded px-3 py-2" />
            @error('order') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="flex items-center gap-4">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }} />
            <span>Obrigatória</span>
          </label>
        </div>
      </div>

      <div class="flex justify-end gap-4">
        <a href="{{ route('manage.questions.index') }}" class="px-4 py-2 bg-red-600 text-white border rounded">Cancelar</a>
        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded">Salvar</button>
      </div>
    </form>
  </div>
</x-layouts.app>
