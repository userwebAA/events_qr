<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Five - Administration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}"
                 alt="Events Five Logo"
                 class="e5-logo mx-auto mb-6">
            <h1 class="text-4xl font-bold text-red-600 mb-2">Administration</h1>
            <p class="text-gray-600">Gérez et analysez les réponses au questionnaire</p>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4 mb-8 max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-4">
                <!-- Bouton d'export -->
                <div class="relative">
                    <button onclick="document.getElementById('format-dropdown').classList.toggle('hidden')"
                            class="e5-button py-2 px-4 rounded-lg inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export CSV
                    </button>
                    <div id="format-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10 border border-gray-100">
                        <div class="p-2 space-y-1">
                            <a href="{{ route('admin.export', ['format' => 'windows']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 rounded-lg">
                                Format Windows
                            </a>
                            <a href="{{ route('admin.export', ['format' => 'mac']) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 rounded-lg">
                                Format Mac
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bouton de tri -->
                <a href="?sort={{ request('sort') === 'asc' ? 'desc' : 'asc' }}" 
                   class="e5-button py-2 px-4 rounded-lg inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9M3 12h5m0 0v6m0-6h5" />
                    </svg>
                    {{ request('sort') === 'asc' ? 'Plus ancien' : 'Plus récent' }}
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Tableau des réponses -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden max-w-7xl mx-auto">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-red-600">Date</th>
                            @foreach($questions as $question)
                                @if(collect($responses)->pluck('answers')->flatten()->has($question->id))
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-red-600">{{ $question->question }}</th>
                                @endif
                            @endforeach
                            <th class="px-6 py-4 text-left text-sm font-semibold text-red-600">Commentaire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white" id="responses-table">
                        @include('admin.partials.response-rows')
                    </tbody>
                </table>
            </div>

            <!-- Boutons Voir plus et Afficher moins -->
            <div class="text-center py-4 space-x-4" id="load-more-container" @if($responses->count() < 5) style="display: none;" @endif>
                <button id="load-more" class="e5-button py-2 px-4 rounded-md inline-block">
                    Voir plus de réponses
                </button>
                <button id="show-less" class="e5-button py-2 px-4 rounded-md inline-block bg-gray-500" style="display: none;">
                    Afficher moins
                </button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.getElementById('responses-table');
                const loadMoreBtn = document.getElementById('load-more');
                const showLessBtn = document.getElementById('show-less');
                let currentPage = 1;
                let initialRows = Array.from(table.getElementsByTagName('tr'));

                loadMoreBtn.addEventListener('click', async function() {
                    try {
                        currentPage++;
                        const response = await fetch(`{{ route('admin.index') }}?page=${currentPage}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error('Erreur réseau');

                        const data = await response.json();
                        if (data.html) {
                            table.insertAdjacentHTML('beforeend', data.html);
                            showLessBtn.style.display = 'inline-block';
                        }

                        if (!data.hasMore) {
                            loadMoreBtn.style.display = 'none';
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors du chargement des réponses supplémentaires.');
                    }
                });

                showLessBtn.addEventListener('click', function() {
                    table.innerHTML = '';
                    initialRows.forEach(row => {
                        table.appendChild(row.cloneNode(true));
                    });
                    currentPage = 1;
                    loadMoreBtn.style.display = 'inline-block';
                    showLessBtn.style.display = 'none';
                });
            });
        </script>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $responses->links() }}
        </div>

        <!-- Statistiques -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($questions as $question)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="font-semibold mb-6 text-red-600 text-lg">{{ $question->question }}</h3>
                    <div class="space-y-4">
                        @foreach($question->options as $index => $option)
                            @php
                                $optionStats = $stats[$question->id]['options'][$index];
                                $count = $optionStats['count'];
                                $percentage = $optionStats['percentage'];
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">{{ $option }}</span>
                                    <span class="text-gray-600 font-medium">{{ $count }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="e5-progress-bar h-2 rounded-full transition-all duration-500"
                                         style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Carte des commentaires récents -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="font-semibold mb-6 text-red-600 text-lg">2 Derniers commentaires</h3>
                <div class="space-y-4">
                    @forelse($responses->filter(fn($r) => !empty($r->feedback))->take(2) as $response)
                        @if($response->feedback)
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-600 mb-2">
                                            {{ $response->created_at->format('d/m/Y H:i') }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="truncate text-gray-800">
                                                {{ Str::limit($response->feedback, 30) }}
                                            </div>
                                            @if(strlen($response->feedback) > 30)
                                                <button onclick="alert('{{ $response->feedback }}')"
                                                        class="shrink-0 text-red-600 hover:text-red-700 transition-colors">
                                                    <span class="material-icons" style="font-size: 20px;">visibility</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-gray-500 text-center py-4">
                            Aucun commentaire pour le moment
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    // Fermer le dropdown quand on clique ailleurs
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('format-dropdown');
        const button = event.target.closest('button');

        if (!button && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
