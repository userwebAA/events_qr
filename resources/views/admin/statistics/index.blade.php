@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Statistiques</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($questions as $question)
            @if(isset($stats[$question->id]))
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $question->content }}</h3>
                        <div class="bg-red-50 px-3 py-1 rounded-full">
                            <span class="text-red-600 font-medium">{{ $stats[$question->id]['total'] }} réponses</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @foreach($stats[$question->id]['options'] as $option => $data)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ $option }}</span>
                                    <span class="font-medium">{{ $data['percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $data['count'] }} réponses</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($loop->last && $loop->iteration % 2 != 0)
                <!-- Derniers commentaires -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Derniers commentaires</h2>
                    <div class="space-y-4">
                        @forelse($latestComments as $comment)
                            <div class="border-b border-gray-100 last:border-0 pb-4 last:pb-0">
                                <p class="text-gray-600">{{ $comment->feedback }}</p>
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span class="material-icons text-gray-400 text-sm mr-1">table_restaurant</span>
                                    <span>Table {{ $comment->table_id }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="material-icons text-4xl text-gray-400 mb-2">comment_off</span>
                                <p class="text-gray-500">Aucun commentaire</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection