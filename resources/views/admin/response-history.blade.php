@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Historique des réponses - Table {{ $tableId }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            Retour au tableau de bord
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Toutes les réponses</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        @foreach($questions as $question)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ $question->content }}</th>
                        @endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $groupedResponses = $responses->groupBy('created_at');
                    @endphp
                    
                    @forelse($groupedResponses as $datetime => $responseGroup)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($datetime)->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            @foreach($questions as $question)
                                <td class="px-6 py-4">
                                    @php
                                        $answer = $responseGroup->firstWhere('question_id', $question->id);
                                    @endphp
                                    <span class="text-sm text-red-600">
                                        {{ $answer ? $answer->selected_option : '-' }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">
                                    {{ $responseGroup->first()->feedback ?? 'Aucun commentaire' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($questions) + 2 }}" class="px-6 py-4 text-center text-gray-500">
                                Aucune réponse dans l'historique
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($responses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $responses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
