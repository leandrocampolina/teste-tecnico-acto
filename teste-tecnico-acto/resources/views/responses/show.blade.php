<x-layouts.app :title="'Resposta detalhada'">
    <div class="flex justify-between items-center">
        <div class="flex flex-col mb-6">
            <h2 class="text-2xl font-bold">{{ $response->snapshot['form']['title'] }}</h2>
            <h1>Respondido em: {{ $response->created_at->format('d/m/Y H:i') }}</h1>
        </div>
        
        <a href="{{ route('responses.index') }}" class="px-4 py-2 border rounded text-sm hover:underline">Voltar</a>
    </div>

    <div class="border rounded">
        @foreach($response->snapshot['questions'] as $q)
            <div class="m-4 border p-4">
                <div><strong>{{ $q['text'] }}</strong></div>
                @if($q['type'] === 'multiple_choice')
                    @foreach($q['alternatives'] as $alt)
                        @php $selected = $q['answer'] === $alt['uuid']; @endphp
                        <div>
                            <label>
                                <input type="radio" disabled {{ $selected ? 'checked' : '' }}>
                                {{ $alt['text'] }}
                                @if($alt['is_correct'])
                                    <span style="color:green">(Correta)</span>
                                @endif
                            </label>
                        </div>
                    @endforeach
                @else
                    <div>Resposta: {{ $q['answer'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
</x-layouts.app>
