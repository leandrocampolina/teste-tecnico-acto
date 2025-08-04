<x-layouts.app title="Criar Formulário">
  <div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Criar Formulário</h2>
      <a href="{{ route('manage.forms.index') }}" class="px-4 py-2 border rounded text-sm hover:underline">Voltar</a>
    </div>

    <form method="POST" action="{{ route('manage.forms.store') }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
      @csrf

      <div class="grid gap-6">
        <div>
          <label for="title" class="block font-medium text-sm mb-1">Título</label>
          <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border rounded px-3 py-2" />
          @error('title') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label for="description" class="block font-medium text-sm mb-1">Descrição</label>
          <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
          @error('description') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center gap-4">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="form-checkbox" />
            <span>Ativo</span>
          </label>
        </div>
      </div>

      <div class="flex justify-end gap-4">
        <a href="{{ route('manage.forms.index') }}" class="px-4 py-2 bg-red-600 text-white border rounded">Cancelar</a>
        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded">Salvar</button>
      </div>
    </form>
  </div>
</x-layouts.app>
