<template>
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <Cog6ToothIcon class="w-6 h-6 text-purple-600" />
            Préférences utilisateur
        </h2>

        <div class="space-y-6">
            <!-- Volume -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Volume par défaut
                </label>
                <div class="flex items-center gap-4">
                    <input
                        type="range"
                        min="0"
                        max="1"
                        step="0.1"
                        v-model="preferences.volume"
                        @input="updatePreference('volume', $event.target.value)"
                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                    />
                    <span class="text-sm text-gray-600 w-12">{{ Math.round(preferences.volume * 100) }}%</span>
                </div>
            </div>

            <!-- Autoplay -->
            <div>
                <label class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        v-model="preferences.autoplay"
                        @change="updatePreference('autoplay', $event.target.checked)"
                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                    />
                    <span class="text-sm font-medium text-gray-700">Lecture automatique</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Lancer automatiquement la musique suivante</p>
            </div>

            <!-- Shuffle -->
            <div>
                <label class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        v-model="preferences.shuffle"
                        @change="updatePreference('shuffle', $event.target.checked)"
                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                    />
                    <span class="text-sm font-medium text-gray-700">Lecture aléatoire</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Mélanger automatiquement les playlists</p>
            </div>

            <!-- Mode de répétition -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Mode de répétition
                </label>
                <select
                    v-model="preferences.repeat"
                    @change="updatePreference('repeat', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
                    <option value="none">Aucune répétition</option>
                    <option value="one">Répéter une fois</option>
                    <option value="all">Répéter tout</option>
                </select>
            </div>

            <!-- Qualité audio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Qualité audio
                </label>
                <select
                    v-model="preferences.quality"
                    @change="updatePreference('quality', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
                    <option value="low">Basse (économise la bande passante)</option>
                    <option value="medium">Moyenne (équilibrée)</option>
                    <option value="high">Haute (meilleure qualité)</option>
                </select>
            </div>

            <!-- Notifications -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications</h3>
                <div class="space-y-3">
                    <div>
                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                v-model="preferences.notifications.newMusic"
                                @change="updateNotificationSetting('newMusic', $event.target.checked)"
                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                            />
                            <span class="text-sm font-medium text-gray-700">Nouvelles musiques</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                v-model="preferences.notifications.likes"
                                @change="updateNotificationSetting('likes', $event.target.checked)"
                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                            />
                            <span class="text-sm font-medium text-gray-700">Nouveaux likes</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                v-model="preferences.notifications.comments"
                                @change="updateNotificationSetting('comments', $event.target.checked)"
                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                            />
                            <span class="text-sm font-medium text-gray-700">Nouveaux commentaires</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                v-model="preferences.notifications.follows"
                                @change="updateNotificationSetting('follows', $event.target.checked)"
                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500"
                            />
                            <span class="text-sm font-medium text-gray-700">Nouveaux abonnements</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t pt-6 flex gap-3">
                <button
                    @click="resetPreferences"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Réinitialiser
                </button>
                <button
                    @click="exportData"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Exporter mes données
                </button>
                <button
                    @click="deleteData"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                >
                    Supprimer mes données
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Cog6ToothIcon } from '@heroicons/vue/24/outline'
import cookieService from '@/Services/CookieService'

const preferences = ref(cookieService.getDefaultPreferences())

const updatePreference = (key, value) => {
    cookieService.updatePreference(key, value)
    preferences.value[key] = value
}

const updateNotificationSetting = (type, enabled) => {
    cookieService.updateNotificationSetting(type, enabled)
    preferences.value.notifications[type] = enabled
}

const resetPreferences = () => {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser toutes vos préférences ?')) {
        cookieService.reset()
        preferences.value = cookieService.getDefaultPreferences()
    }
}

const exportData = async () => {
    try {
        const response = await fetch('/api/analytics/export', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })

        if (response.ok) {
            const data = await response.json()
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' })
            const url = URL.createObjectURL(blob)
            const a = document.createElement('a')
            a.href = url
            a.download = `jaajfm-data-${new Date().toISOString().split('T')[0]}.json`
            a.click()
            URL.revokeObjectURL(url)
        }
    } catch (error) {
        console.error('Erreur lors de l\'export:', error)
        alert('Erreur lors de l\'export des données')
    }
}

const deleteData = async () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer toutes vos données ? Cette action est irréversible.')) {
        try {
            const response = await fetch('/api/analytics/delete', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })

            if (response.ok) {
                alert('Vos données ont été supprimées avec succès')
                cookieService.reset()
                preferences.value = cookieService.getDefaultPreferences()
            }
        } catch (error) {
            console.error('Erreur lors de la suppression:', error)
            alert('Erreur lors de la suppression des données')
        }
    }
}

onMounted(() => {
    preferences.value = cookieService.getPreferences()
})
</script>

<style scoped>
.slider::-webkit-slider-thumb {
    appearance: none;
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #9333ea;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #9333ea;
    cursor: pointer;
    border: none;
}
</style>
