<x-layouts.app title="Alternativas">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Alternativas</h2>
    @can('create', App\Models\Alternative::class)
      <a href="{{ route('manage.alternatives.create') }}" class="btn bg-indigo-600 text-white px-4 py-2 rounded">Criar nova</a>
    @endcan
  </div>

  @if($alternatives->isEmpty())
    <p>Nenhuma alternativa criada ainda.</p>
  @else
    <div class="space-y-4">
      @foreach($alternatives as $alternative)
        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
          <div class="flex flex-col">
            <div class="font-semibold">{{ Str::limit($alternative->text, 80) }}</div>
            <div class="p-2 text-sm text-gray-500 flex flex-col gap-2">
              <span>Pergunta: {{ $alternative->question->text ? Str::limit($alternative->question->text, 40) : '—' }}</span>
              <span>Correta: 
                @if($alternative->is_correct)
                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Sim</span>
                @else
                  <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">Não</span>
                @endif
              </span>
              <span>Ordem: {{ $alternative->order }}</span>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div x-data="{ open:false }" class="relative">
              <button @click="open = !open" class="p-2 rounded hover:bg-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                  <circle cx="12" cy="5" r="2"/>
                  <circle cx="12" cy="12" r="2"/>
                  <circle cx="12" cy="19" r="2"/>
                </svg>
              </button>

              <div x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-10">
                @can('update', $alternative)
                  <a href="{{ route('manage.alternatives.edit', $alternative) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Editar</a>
                @endcan
                @can('delete', $alternative)
                  <form method="POST" action="{{ route('manage.alternatives.destroy', $alternative) }}" onsubmit="return confirm('Tem certeza?')" class="m-0">
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
      {{ $alternatives->withQueryString()->links() }}
    </div>
  @endif
</x-layouts.app>
