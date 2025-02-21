@extends('layouts.admin')

@section('content')
<div x-data="questionManager()">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Questions</h1>
            <button @click="openAddModal()" class="inline-flex items-center px-4 py-2 bg-red-600 text-sm text-white rounded hover:bg-red-700 transition-colors duration-200">
                <span class="material-icons text-xl">add</span>
                <span class="ml-1">Créer une question</span>
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gradient-to-r from-gray-200 to-gray-300">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 font-semibold text-gray-600 uppercase tracking-wider">Ordre</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 font-semibold text-gray-600 uppercase tracking-wider">Question</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm leading-4 font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="questions-table" class="bg-white">
                        @foreach($questions as $question)
                        <tr data-id="{{ $question->id }}" class="hover:bg-gray-100 transition">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <div class="flex items-center space-x-2">
                                    <input 
                                        type="number" 
                                        :value="'{{ $question->order }}'"
                                        @change="updateQuestionOrder($event, {{ $question->id }})"
                                        min="1"
                                        class="w-16 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    >
                                    <div class="flex flex-col ml-2">
                                        @if (!$loop->first)
                                        <button @click="moveQuestion({{ $question->id }}, 'up')" class="text-gray-500 hover:text-gray-700">↑</button>
                                        @endif
                                        @if (!$loop->last)
                                        <button @click="moveQuestion({{ $question->id }}, 'down')" class="text-gray-500 hover:text-gray-700">↓</button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-300">
                                <div class="text-sm leading-5 text-gray-900 font-medium">{{ $question->content }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <div class="flex items-center space-x-6">
                                    <button @click="openEditModal({{ $question->id }}, `{{ addslashes($question->content) }}`, {{ json_encode($question->options) }})"
                                             class="flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 group">
                                        <span class="material-icons mr-2 text-blue-500 group-hover:scale-110 transition-transform duration-200">edit</span>
                                        <span class="font-medium">Modifier</span>
                                    </button>
                                    <button @click="openDeleteModal({{ $question->id }})" 
                                            class="flex items-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 group">
                                        <span class="material-icons mr-2 text-red-500 group-hover:scale-110 transition-transform duration-200">delete</span>
                                        <span class="font-medium">Supprimer</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div x-cloak x-show="isModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-lg rounded shadow-lg"
                 @click.away="closeModal()">
                <div class="p-5">
                    <!-- En-tête -->
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-lg font-medium text-gray-900" x-text="modalTitle"></h3>
                        <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-500">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <!-- Formulaire -->
                    <div class="space-y-4">
                        <!-- Question -->
                        <div>
                            <label for="questionContent" class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                            <textarea
                                id="questionContent"
                                x-model="questionContent"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                placeholder="Saisissez votre question..."></textarea>
                        </div>

                        <!-- Options -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Options de réponse</label>
                            <div class="space-y-2">
                                <template x-for="(option, index) in options" :key="index">
                                    <div class="flex items-center space-x-2">
                                        <input
                                            type="text"
                                            x-model="options[index]"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                            :placeholder="'Option ' + (index + 1)">
                                        <button
                                            @click="removeOption(index)"
                                            class="text-red-600 hover:text-red-800"
                                            :disabled="options.length <= 2">
                                            <span class="material-icons">remove_circle</span>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <button
                                @click="addOption"
                                type="button"
                                class="mt-2 flex items-center text-sm text-red-600 hover:text-red-800">
                                <span class="material-icons mr-1">add_circle</span>
                                Ajouter une option
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                        <button
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900">
                            Annuler
                        </button>
                        <button
                            type="button"
                            @click="saveQuestion()"
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div x-cloak x-show="isDeleteModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-md rounded shadow-lg" @click.away="closeDeleteModal()">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <span class="material-icons text-red-600 text-5xl">warning</span>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Confirmer la suppression</h3>
                    <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cette question ? Cette action est irréversible.</p>
                    <div class="flex justify-center space-x-4">
                        <button @click="closeDeleteModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-100">
                            Annuler
                        </button>
                        <button @click="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection

@push('scripts')
<script>
function questionManager() {
    return {
        isModalOpen: false,
        isDeleteModalOpen: false,
        modalTitle: 'Créer une question',
        questionContent: '',
        options: ['', ''],
        errorMessage: '',
        editingQuestionId: null,
        deleteQuestionId: null,
        activeTab: 'question',

        openAddModal() {
            this.editingQuestionId = null;
            this.modalTitle = 'Créer une question';
            this.questionContent = '';
            this.options = ['', ''];
            this.activeTab = 'question';
            this.isModalOpen = true;
        },

        openEditModal(id, content, options) {
            this.editingQuestionId = id;
            this.modalTitle = 'Modifier la question';
            this.questionContent = content;
            this.options = Array.isArray(options) ? [...options] : ['', ''];
            this.activeTab = 'question';
            this.isModalOpen = true;
        },

        openDeleteModal(id) {
            this.deleteQuestionId = id;
            this.isDeleteModalOpen = true;
        },

        closeDeleteModal() {
            this.isDeleteModalOpen = false;
            this.deleteQuestionId = null;
        },

        closeModal() {
            this.isModalOpen = false;
            this.questionContent = '';
            this.options = ['', ''];
            this.editingQuestionId = null;
            this.activeTab = 'question';
            this.errorMessage = '';
        },

        addOption() {
            this.options.push('');
        },

        removeOption(index) {
            if (this.options.length > 2) {
                this.options.splice(index, 1);
            }
        },

        async saveQuestion() {
            try {
                if (this.questionContent.trim() === '') {
                    throw new Error('La question ne peut pas être vide');
                }

                const filteredOptions = this.options.filter(opt => opt.trim() !== '');
                if (filteredOptions.length < 2) {
                    throw new Error('Il faut au moins deux options de réponse');
                }

                const url = this.editingQuestionId 
                    ? `/admin/questions/${this.editingQuestionId}`
                    : '/admin/questions';

                const response = await fetch(url, {
                    method: this.editingQuestionId ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        content: this.questionContent,
                        options: filteredOptions
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Une erreur est survenue');
                }

                this.closeModal();
                window.location.reload();
            } catch (error) {
                alert(error.message);
            }
        },

        async confirmDelete() {
            try {
                const response = await fetch(`/admin/questions/${this.deleteQuestionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Une erreur est survenue');
                }

                this.closeDeleteModal();
                window.location.reload();
            } catch (error) {
                alert(error.message);
                console.error('Erreur:', error);
            }
        }
    }
}
</script>
@endpush
