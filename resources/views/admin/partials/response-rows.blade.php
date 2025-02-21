@forelse($responses as $response)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">
            <span class="text-sm text-gray-900">Table {{ $response->table_id }}</span>
        </td>
        <td class="px-6 py-4">
            <span class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($response->created_at)->format('d/m/Y H:i') }}
            </span>
        </td>
        @foreach($questions as $question)
            <td class="px-6 py-4">
                @php
                    $responseKey = $response->table_id . '_' . $response->created_at;
                    $answers = isset($responseDetails[$responseKey]) ? $responseDetails[$responseKey] : collect();
                    $answer = $answers->firstWhere('question_id', $question->id);
                @endphp
                <span class="text-sm text-red-600">
                    {{ $answer ? $answer->selected_option : '-' }}
                </span>
            </td>
        @endforeach
        <td class="px-6 py-4">
            <span class="text-sm text-gray-500">
                @php
                    $responseKey = $response->table_id . '_' . $response->created_at;
                @endphp
                @if(isset($feedbacks[$responseKey]))
                    {{ $feedbacks[$responseKey]->first()->feedback }}
                @else
                    -
                @endif
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="{{ count($questions) + 3 }}" class="px-6 py-4 text-center text-gray-500">
            Aucune réponse enregistrée
        </td>
    </tr>
@endforelse
