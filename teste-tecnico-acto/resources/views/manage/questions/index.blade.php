<x-layouts.app title="Perguntas">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Perguntas</h2>
    @can('create', App\Models\Question::class)
      <a href="{{ route('manage.questions.create') }}" class="btn bg-indigo-600 text-white px-4 py-2 rounded">Criar nova</a>
    @endcan
  </div>

  @if($questions->isEmpty())
    <p>Nenhuma pergunta criada ainda.</p>
  @else
    <div class="space-y-4">
      @foreach($questions as $question)
        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
          <div class="flex flex-col">
            <div class="font-semibold">{{ Str::limit($question->text, 80) }}</div>
            <div class="p-2 text-sm text-gray-500 flex flex-col gap-2">
              <span>Formulário: {{ $question->form->title ?? '—' }}</span>
              <span>Tipo: {{ $question->type === 'multiple_choice' ? 'Múltipla Escolha' : 'Texto' }}</span>
              <span>Obrigatória: 
                @if($question->is_required)
                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Sim</span>
                @else
                  <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">Não</span>
                @endif
              </span>
              <span>Ordem: {{ $question->order }}</span>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <!-- Dropdown de ações -->
            <div x-data="{ open:false }" class="relative">
              <button @click="open = !open" class="p-2 rounded hover:bg-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                  <circle cx="12" cy="5" r="2"/>
                  <circle cx="12" cy="12" r="2"/>
                  <circle cx="12" cy="19" r="2"/>
                </svg>
              </button>

              <div x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-10">
                @can('update', $question)
                  <a href="{{ route('manage.questions.edit', $question) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Editar</a>
                @endcan
                @can('delete', $question)
                  <form method="POST" action="{{ route('manage.questions.destroy', $question) }}" onsubmit="return confirm('Tem certeza que quer excluir?')" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Excluir</button>
                  </form>
                @endcan
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $questions->withQueryString()->links() }}
    </div>
  @endif
</x-layouts.app>
