<x-layouts.app :title="'Minhas respostas'">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Minhas respostas</h2>
        <a href="{{ route('manage.forms.index') }}" class="px-4 py-2 border rounded text-sm hover:underline">Voltar</a>
    </div>

    @foreach($responses as $response)
        <div class="border rounded shadow p-4 mb-6">
            <div><strong>Formulário:</strong> {{ $response->snapshot['form']['title'] }}</div>
            <div><strong>Respondido em:</strong> {{ $response->created_at->format('d/m/Y H:i') }}</div>
            <div class="flex justify-end">
                <a href="{{ route('responses.show', $response) }}" class="px-4 py-2 bg-indigo-600 text-white border rounded">Ver detalhes</a>
            </div>
        </div>
    @endforeach

    {{ $responses->links() }}
</x-layouts.app>
