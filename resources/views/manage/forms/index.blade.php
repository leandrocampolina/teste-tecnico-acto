<x-layouts.app title="Formulários">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Formulários</h2>
    @can('create', App\Models\Form::class)
      <a href="{{ route('manage.forms.create') }}" class="btn bg-indigo-600 text-white px-4 py-2 rounded">Criar novo</a>
    @endcan
  </div>

  @if($forms->isEmpty())
    <p>Nenhum formulário criado ainda.</p>
  @else
    <div class="space-y-4">
      @foreach($forms as $form)
        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
          <div>
            <div class="font-semibold">{{ $form->title }}</div>
            <div class="text-sm text-gray-500">{{ $form->description }}</div>
          </div>

          <div class="flex items-center gap-4">
            <div class="flex gap-2">
              <div class="text-sm">
                @if($form->is_active)
                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Ativo</span>
                @else
                  <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">Inativo</span>
                @endif
              </div>
              <div class="text-sm">
                @if($form->answered_by_user_count > 0)
                  <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Respondido</span>
                @endif
              </div>
            </div>

            <!-- Dropdown de ações -->
            <div x-data="{ open:false }" class="relative">
              <button @click="open = !open" class="p-2 rounded hover:bg-gray-100">
                <!-- três pontinhos -->
                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                  <circle cx="12" cy="5" r="2"/>
                  <circle cx="12" cy="12" r="2"/>
                  <circle cx="12" cy="19" r="2"/>
                </svg>
              </button>

              <div x-show="open" @click.outside="open=false" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-10">
                @if($form->is_active)
                  <a href="{{ route('forms.show', $form) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                    Responder
                  </a>
                @endif
                @if($form->answered_by_user_count > 0)
                  <a href="{{ route('responses.index', ['form' => $form->id]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                      Visualizar respostas
                  </a>
                @endif
                @can('update', $form)
                  <a href="{{ route('manage.forms.edit', $form) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Editar</a>
                @endcan
                @can('delete', $form)
                  <form method="POST" action="{{ route('manage.forms.destroy', $form) }}" onsubmit="return confirm('Tem certeza?')">
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
      {{ $forms->links() }}
    </div>

    @if(session('success'))
      <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  @endif
</x-layouts.app>
