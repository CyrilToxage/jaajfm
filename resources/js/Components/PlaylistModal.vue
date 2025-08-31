<template>
    <div v-if="show" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Ajouter à une playlist</h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>

            <!-- Créer une nouvelle playlist -->
            <div class="mb-6 p-4 bg-purple-50 rounded-xl">
                <h4 class="font-semibold text-gray-900 mb-3">Créer une nouvelle playlist</h4>
                <div class="space-y-3">
                    <input
                        v-model="newPlaylist.name"
                        type="text"
                        placeholder="Nom de la playlist"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    />
                    <textarea
                        v-model="newPlaylist.description"
                        placeholder="Description (optionnel)"
                        rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    ></textarea>

                    <!-- Upload d'image de cover -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Image de cover (optionnel)</label>
                        <div class="flex items-center space-x-3">
                            <div v-if="coverPreview" class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                <img :src="coverPreview" alt="Preview" class="w-full h-full object-cover" />
                            </div>
                            <div v-else class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Aucune image</span>
                            </div>
                            <div class="flex-1">
                                <input
                                    ref="coverInput"
                                    type="file"
                                    accept="image/*"
                                    @change="handleCoverUpload"
                                    class="hidden"
                                />
                                <button
                                    type="button"
                                    @click="$refs.coverInput.click()"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                >
                                    Choisir une image
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input
                            v-model="newPlaylist.is_public"
                            type="checkbox"
                            id="public-playlist"
                            class="mr-2"
                        />
                        <label for="public-playlist" class="text-sm text-gray-700">Playlist publique</label>
                    </div>
                    <button
                        @click="createPlaylist"
                        :disabled="!newPlaylist.name.trim() || creating"
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300"
                    >
                        {{ creating ? 'Création...' : 'Créer la playlist' }}
                    </button>
                </div>
            </div>

            <!-- Séparateur -->
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">ou</span>
                </div>
            </div>

            <!-- Mes playlists existantes -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Ajouter à une playlist existante</h4>
                <div v-if="loading" class="text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div>
                </div>
                <div v-else-if="playlists.length === 0" class="text-center py-4 text-gray-500">
                    Aucune playlist créée
                </div>
                <div v-else class="space-y-2 max-h-48 overflow-y-auto">
                    <button
                        v-for="playlist in playlists"
                        :key="playlist.id"
                        @click="addToPlaylist(playlist)"
                        :disabled="addingToPlaylist === playlist.id"
                        class="w-full text-left p-3 rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-purple-300 transition-all duration-200 disabled:opacity-50"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ playlist.name }}</div>
                                <div class="text-sm text-gray-500">{{ (playlist.musics_count !== undefined && playlist.musics_count !== null) ? playlist.musics_count : '...' }} musiques</div>
                            </div>
                            <div v-if="addingToPlaylist === playlist.id" class="animate-spin rounded-full h-5 w-5 border-b-2 border-purple-600"></div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

// Définir les props et emits
const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    musicId: {
        type: [String, Number],
        required: false,
        default: null
    }
})

const emit = defineEmits(['close', 'playlist-created', 'music-added', 'add-to-playlist'])

// État réactif
const playlists = ref([])
const loading = ref(false)
const creating = ref(false)
const addingToPlaylist = ref(null)

const newPlaylist = ref({
    name: '',
    description: '',
    is_public: true
})

const coverPreview = ref(null)
const coverFile = ref(null)

// Méthodes
const handleCoverUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        coverFile.value = file
        const reader = new FileReader()
        reader.onload = (e) => {
            coverPreview.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const closeModal = () => {
    emit('close')
    // Réinitialiser le formulaire
    newPlaylist.value = {
        name: '',
        description: '',
        is_public: true
    }
    coverPreview.value = null
    coverFile.value = null
}

const loadPlaylists = async () => {
    loading.value = true
    try {
        const response = await fetch('/playlists/user/list')
        const data = await response.json()
        console.log('Playlists chargées:', data.playlists)
        playlists.value = data.playlists || []
    } catch (error) {
        console.error('Erreur lors du chargement des playlists:', error)
    } finally {
        loading.value = false
    }
}

const createPlaylist = async () => {
    if (!newPlaylist.value.name.trim()) return

    creating.value = true
    try {
        const formData = new FormData()
        formData.append('name', newPlaylist.value.name)
        formData.append('description', newPlaylist.value.description)
        formData.append('is_public', newPlaylist.value.is_public ? 'true' : 'false')

        if (coverFile.value) {
            formData.append('cover_image', coverFile.value)
        }

        // Debug: afficher les données envoyées
        console.log('Données envoyées:', {
            name: newPlaylist.value.name,
            description: newPlaylist.value.description,
            is_public: newPlaylist.value.is_public,
            hasCoverImage: !!coverFile.value
        })

        const response = await fetch('/playlists', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })

        // Vérifier le type de contenu de la réponse
        const contentType = response.headers.get('content-type')
        if (!contentType || !contentType.includes('application/json')) {
            // Si ce n'est pas du JSON, c'est probablement une page d'erreur HTML
            const text = await response.text()
            console.error('Réponse non-JSON reçue:', text.substring(0, 500))
            throw new Error('Le serveur a retourné une page d\'erreur au lieu de JSON')
        }

        const data = await response.json()

        if (data.success) {
            // Ajouter automatiquement la musique à la nouvelle playlist
            await addToPlaylist(data.playlist)
            // Recharger les playlists pour mettre à jour les compteurs
            await loadPlaylists()
            emit('playlist-created', data.playlist)
        } else {
            // Afficher les erreurs de validation si elles existent
            let errorMessage = data.message || 'Erreur inconnue'
            if (data.errors) {
                const validationErrors = Object.values(data.errors).flat().join(', ')
                errorMessage += '\nErreurs de validation: ' + validationErrors
            }
            alert('Erreur lors de la création de la playlist: ' + errorMessage)
        }
    } catch (error) {
        console.error('Erreur lors de la création:', error)
        alert('Erreur lors de la création de la playlist: ' + error.message)
    } finally {
        creating.value = false
    }
}

const addToPlaylist = async (playlist) => {
    if (!props.musicId) {
        console.warn('Aucun musicId fourni pour ajouter à la playlist')
        return
    }

    addingToPlaylist.value = playlist.id

    try {
        const response = await fetch(`/playlists/${playlist.slug || playlist.id}/add-music`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                music_id: props.musicId
            })
        })

        const data = await response.json()

        if (data.success) {
            // Recharger les playlists pour mettre à jour les compteurs
            await loadPlaylists()
            emit('music-added', { playlist, message: data.message })
            closeModal()
        } else {
            alert(data.message || 'Erreur lors de l\'ajout à la playlist')
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout à la playlist:', error)
        alert('Erreur lors de l\'ajout à la playlist')
    } finally {
        addingToPlaylist.value = null
    }
}

// Charger les playlists quand le modal s'ouvre
onMounted(() => {
    if (props.show) {
        loadPlaylists()
    }
})

// Surveiller les changements de show
import { watch } from 'vue'
watch(() => props.show, (newValue) => {
    if (newValue) {
        loadPlaylists()
    }
})
</script>
