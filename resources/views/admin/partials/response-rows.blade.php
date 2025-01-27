@foreach($responses as $response)
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
            {{ $response->created_at->format('d/m/Y H:i') }}
        </td>
        @foreach($questions as $question)
            @if(isset($response->answers[$question->id]) && $response->answers[$question->id] !== null && $response->answers[$question->id] !== '')
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    {{ $question->options[$response->answers[$question->id]] ?? 'Réponse invalide' }}
                </td>
            @endif
        @endforeach
        <td class="px-6 py-4 text-sm text-gray-800 max-w-[200px]">
            @if($response->feedback)
                <div class="flex items-center gap-2">
                    <div class="truncate">{{ Str::limit($response->feedback, 30) }}</div>
                    @if(strlen($response->feedback) > 30)
                        <button onclick="alert('{{ $response->feedback }}')"
                                class="shrink-0 text-red-600 hover:text-red-700 transition-colors">
                            <span class="material-icons" style="font-size: 20px;">visibility</span>
                        </button>
                    @endif
                </div>
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>
    </tr>
@endforeach
