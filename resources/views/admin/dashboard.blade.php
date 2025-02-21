@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
        <div class="flex space-x-4">
            <a href="{{ route('admin.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 text-sm text-white rounded hover:bg-red-700 transition-colors duration-200">
                <span class="material-icons text-xl mr-1">download</span>
                Exporter les données
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Historique des réponses</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Table</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        @foreach($questions as $question)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ $question->content }}</th>
                        @endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="responses-table">
                    @forelse($initialResponses as $response)
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
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 text-center">
            <button id="load-more" class="inline-flex items-center px-4 py-2 bg-red-600 text-sm text-white rounded hover:bg-red-700 transition-colors duration-200" {{ !$hasMore ? 'style=display:none' : '' }}>
                Voir plus
            </button>
            <button id="show-less" class="inline-flex items-center px-4 py-2 bg-red-600 text-sm text-white rounded hover:bg-red-700 transition-colors duration-200" style="display: none">
                Voir moins
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const loadMoreBtn = document.getElementById('load-more');
    const showLessBtn = document.getElementById('show-less');
    const responsesTable = document.getElementById('responses-table');
    let originalContent = responsesTable.innerHTML;
    let loadedRows = [];

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            currentPage++;
            loadMoreBtn.disabled = true;
            loadMoreBtn.innerHTML = 'Chargement...';

            fetch(`{{ route('admin.dashboard') }}?page=${currentPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    responsesTable.insertAdjacentHTML('beforeend', data.html);
                    loadedRows.push(data.html);
                    showLessBtn.style.display = 'inline-block';
                }
                if (!data.hasMore) {
                    loadMoreBtn.style.display = 'none';
                } else {
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.innerHTML = 'Voir plus';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                loadMoreBtn.disabled = false;
                loadMoreBtn.innerHTML = 'Voir plus';
            });
        });
    }

    if (showLessBtn) {
        showLessBtn.addEventListener('click', function() {
            responsesTable.innerHTML = originalContent;
            loadedRows = [];
            currentPage = 1;
            showLessBtn.style.display = 'none';
            loadMoreBtn.style.display = 'inline-block';
            loadMoreBtn.disabled = false;
        });
    }
});
</script>
@endpush
@endsection
