<x-layouts.app title="Dashboard">
  <div class="text-center mt-8">
    <h1 class="text-3xl font-bold mb-4">Painel</h1>
    <p class="text-gray-600 mb-8">O que você quer fazer hoje?</p>
  </div>

  <div class="grid gap-8 grid-cols-1 md:grid-cols-3 mt-6">
    <a href="{{ route('manage.forms.index') }}" class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 relative">
      <div class="flex items-center justify-between mb-4">
        <div class="text-xl font-semibold">Formulários</div>
        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
          <!-- ícone placeholder -->
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M9 12h6m-6 4h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
          </svg>
        </div>
      </div>
      <p class="text-gray-600">Criar, editar e gerenciar formulários.</p>
    </a>

    <a href="{{ route('manage.questions.index') }}" class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 relative">
      <div class="flex items-center justify-between mb-4">
        <div class="text-xl font-semibold">Perguntas</div>
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M8 7h8M8 11h8M8 15h8"/>
          </svg>
        </div>
      </div>
      <p class="text-gray-600">Gerenciar perguntas dos formulários.</p>
    </a>

    <a href="{{ route('manage.alternatives.index') }}" class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 relative">
      <div class="flex items-center justify-between mb-4">
        <div class="text-xl font-semibold">Alternativas</div>
        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </div>
      </div>
      <p class="text-gray-600">Criar e editar opções de escolha.</p>
    </a>
  </div>
</x-layouts.app>
