<!-- Statistiques -->
<div class="mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Statistiques</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- Taux de complétion -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="text-blue-600">
                    <span class="material-icons text-3xl">assignment_turned_in</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-600 font-medium">Taux de complétion</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $globalStats['completionRate'] }}%</p>
                </div>
            </div>
        </div>

        <!-- Total des réponses -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="text-green-600">
                    <span class="material-icons text-3xl">question_answer</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-green-600 font-medium">Total des réponses</p>
                    <p class="text-2xl font-bold text-green-700">{{ $globalStats['totalResponses'] }}</p>
                </div>
            </div>
        </div>

        <!-- Nombre de tables -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="text-purple-600">
                    <span class="material-icons text-3xl">table_restaurant</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-purple-600 font-medium">Nombre de tables</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $globalStats['totalTables'] }}</p>
                </div>
            </div>
        </div>

        <!-- Moyenne de réponses par table -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="text-yellow-600">
                    <span class="material-icons text-3xl">analytics</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-yellow-600 font-medium">Moy. réponses/table</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $globalStats['averageResponsesPerTable'] }}</p>
                </div>
            </div>
        </div>

        <!-- Nombre de participants -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="text-red-600">
                    <span class="material-icons text-3xl">groups</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-red-600 font-medium">Participants</p>
                    <p class="text-2xl font-bold text-red-700">{{ $globalStats['totalParticipants'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
