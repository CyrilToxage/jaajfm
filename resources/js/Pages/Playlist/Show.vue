<template>

    <Head :title="`${playlist.name} - JaaJ FM`" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Header de la playlist -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-start gap-6">
                            <!-- Image de cover -->
                            <div
                                class="w-40 h-40 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center overflow-hidden">
                                <img v-if="playlist.cover_image_url" :src="playlist.cover_image_url"
                                    :alt="playlist.name" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <MusicalNoteIcon class="w-16 h-16 text-white opacity-90" />
                                </div>
                            </div>

                            <!-- Informations -->
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-4">
                                    <h1 class="text-4xl font-bold text-white">{{ playlist.name }}</h1>
                                    <div v-if="isOwnPlaylist" class="flex items-center gap-2">
                                        <button @click="toggleVisibility" :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300',
                                            playlist.is_public
                                                ? 'bg-green-600 hover:bg-green-700 text-white'
                                                : 'bg-gray-600 hover:bg-gray-700 text-white'
                                        ]">
                                            {{ playlist.is_public ? 'Publique' : 'Privée' }}
                                        </button>
                                    </div>
                                </div>
                                <p class="text-white/80 mb-4">{{ playlist.description || 'Aucune description' }}</p>

                                <div class="flex items-center gap-6 text-white/70">
                                    <div class="flex items-center gap-2">
                                        <UserIcon class="w-5 h-5" />
                                        <span>{{ playlist.user?.name || 'Utilisateur' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <MusicalNoteIcon class="w-5 h-5" />
                                        <span>{{ playlist.musics_count || 0 }} musiques</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <CalendarIcon class="w-5 h-5" />
                                        <span>{{ formatDate(playlist.created_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Liste des musiques avec drag and drop -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                                <MusicalNoteIcon class="w-6 h-6 text-purple-400" />
                                Musiques de la playlist ({{ playlist.musics ? playlist.musics.length : 0 }})
                            </h2>
                            <div class="flex items-center gap-2">
                                <!-- Contrôles de lecture -->
                                <button v-if="playlist.musics && playlist.musics.length > 0"
                                    @click="playMusic(playlist.musics[0])"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <PlayIcon class="w-5 h-5" />
                                    Lire la playlist
                                </button>
                                <button v-if="isPlaying" @click="playPreviousMusic" :disabled="currentPlayingIndex <= 0"
                                    :class="[
                                        'px-3 py-2 rounded-lg transition-colors flex items-center gap-2',
                                        currentPlayingIndex > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-600 text-gray-400 cursor-not-allowed'
                                    ]">
                                    <ChevronLeftIcon class="w-5 h-5" />
                                    Précédent
                                </button>
                                <button v-if="isPlaying" @click="playNextMusic"
                                    :disabled="currentPlayingIndex >= playlist.musics.length - 1" :class="[
                                        'px-3 py-2 rounded-lg transition-colors flex items-center gap-2',
                                        currentPlayingIndex < playlist.musics.length - 1 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-600 text-gray-400 cursor-not-allowed'
                                    ]">
                                    Suivant
                                    <ChevronRightIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <div v-if="playlist.musics && playlist.musics.length > 0" class="space-y-3" ref="musicList">
                            <div v-for="(music, index) in playlist.musics" :key="music.id" :data-id="music.id"
                                draggable="true" @dragstart="dragStart($event, index)" @dragover.prevent
                                @drop="drop($event, index)" @dragenter.prevent :class="[
                                    'rounded-xl p-4 flex items-center gap-4 hover:bg-white/20 transition-all duration-300 cursor-move group',
                                    currentPlayingIndex === index && isPlaying
                                        ? 'bg-green-500/20 border border-green-400/30'
                                        : 'bg-white/10'
                                ]">

                                <!-- Handle de drag -->
                                <div class="text-white/40 hover:text-white/60 transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M7 2a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 2zm0 6a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 8zm0 6a2 2 0 1 1 .001 4.001A2 2 0 0 1 7 14zm6-8a2 2 0 1 1-.001-4.001A2 2 0 0 1 13 6zm0 2a2 2 0 1 1 .001 4.001A2 2 0 0 1 13 8zm0 6a2 2 0 1 1 .001 4.001A2 2 0 0 1 13 14z" />
                                    </svg>
                                </div>

                                <!-- Numéro -->
                                <div class="text-white/60 font-bold text-lg w-8 text-center">
                                    {{ index + 1 }}
                                </div>

                                <!-- Image de cover -->
                                <div
                                    class="w-16 h-16 rounded-lg overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
                                    <img v-if="music.cover_image_url" :src="music.cover_image_url" :alt="music.title"
                                        class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <MusicalNoteIcon class="w-8 h-8 text-white opacity-90" />
                                    </div>
                                </div>

                                <!-- Informations -->
                                <div class="flex-1">
                                    <h3 class="text-white font-semibold">{{ music.title }}</h3>
                                    <p class="text-white/70 text-sm">{{ music.user?.name || 'Artiste inconnu' }}</p>
                                    <div class="flex items-center gap-4 mt-1 text-xs text-white/50">
                                        <span>{{ formatDuration(music.duration) }}</span>
                                        <span>{{ formatNumber(music.views) }} vues</span>
                                        <span>{{ formatNumber(music.likes_count) }} likes</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2">
                                    <button @click="playMusic(music)" :class="[
                                        'p-2 rounded-lg transition-colors',
                                        currentPlayingIndex === index && isPlaying
                                            ? 'bg-green-600 hover:bg-green-700 text-white'
                                            : 'bg-purple-600 hover:bg-purple-700 text-white'
                                    ]">
                                        <PlayIcon v-if="!(currentPlayingIndex === index && isPlaying)"
                                            class="w-5 h-5" />
                                        <PauseIcon v-else class="w-5 h-5" />
                                    </button>
                                    <button @click="goToMusic(music)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors">
                                        <ArrowTopRightOnSquareIcon class="w-5 h-5" />
                                    </button>
                                    <button v-if="isOwnPlaylist" @click="removeMusic(music)"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-colors">
                                        <TrashIcon class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <MusicalNoteIcon class="w-16 h-16 text-white/60 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Playlist vide</h3>
                            <p class="text-white/80 mb-6">
                                Cette playlist ne contient aucune musique pour le moment.
                            </p>
                            <button v-if="isOwnPlaylist" @click="addMusic"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-colors">
                                <PlusIcon class="w-5 h-5 inline mr-2" />
                                Ajouter une musique
                            </button>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-20"> <!-- pt-20 pour le header fixe, pb-20 pour la navigation mobile -->
                <div class="px-4 py-6 space-y-6">
                    <!-- Header de la playlist -->
                    <section class="glass rounded-2xl p-6">
                        <div class="text-center space-y-4">
                            <!-- Image de cover -->
                            <div class="flex justify-center">
                                <div
                                    class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center overflow-hidden">
                                    <img v-if="playlist.cover_image_url" :src="playlist.cover_image_url"
                                        :alt="playlist.name" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <MusicalNoteIcon class="w-12 h-12 text-white opacity-90" />
                                    </div>
                                </div>
                            </div>

                            <!-- Informations -->
                            <div>
                                <div class="flex items-center justify-center gap-2 mb-3">
                                    <h1 class="text-2xl font-bold text-white">{{ playlist.name }}</h1>
                                    <div v-if="isOwnPlaylist">
                                        <button @click="toggleVisibility" :class="[
                                            'px-3 py-1 rounded-lg text-xs font-medium transition-all duration-300',
                                            playlist.is_public
                                                ? 'bg-green-600 hover:bg-green-700 text-white'
                                                : 'bg-gray-600 hover:bg-gray-700 text-white'
                                        ]">
                                            {{ playlist.is_public ? 'Publique' : 'Privée' }}
                                        </button>
                                    </div>
                                </div>
                                <p class="text-white/80 text-sm mb-4">{{ playlist.description || 'Aucune description' }}
                                </p>

                                <div class="flex items-center justify-center gap-4 text-white/70 text-sm">
                                    <div class="flex items-center gap-1">
                                        <UserIcon class="w-4 h-4" />
                                        <span>{{ playlist.user?.name || 'Utilisateur' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <MusicalNoteIcon class="w-4 h-4" />
                                        <span>{{ playlist.musics_count || 0 }} musiques</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <CalendarIcon class="w-4 h-4" />
                                        <span>{{ formatDate(playlist.created_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Contrôles de lecture -->
                    <section v-if="playlist.musics && playlist.musics.length > 0" class="glass rounded-2xl p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <MusicalNoteIcon class="w-5 h-5 text-purple-400" />
                                Musiques ({{ playlist.musics.length }})
                            </h2>
                            <div class="flex items-center gap-2">
                                <button @click="playMusic(playlist.musics[0])"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg transition-colors text-sm">
                                    <PlayIcon class="w-4 h-4 inline mr-1" />
                                    Lire
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Liste des musiques -->
                    <section class="glass rounded-2xl p-4">
                        <div v-if="playlist.musics && playlist.musics.length > 0" class="space-y-3">
                            <div v-for="(music, index) in playlist.musics" :key="music.id" :class="[
                                'rounded-xl p-3 flex items-center gap-3 hover:bg-white/20 transition-all duration-300',
                                currentPlayingIndex === index && isPlaying
                                    ? 'bg-green-500/20 border border-green-400/30'
                                    : 'bg-white/10'
                            ]">
                                <!-- Numéro -->
                                <div class="text-white/60 font-bold text-base w-6 text-center">
                                    {{ index + 1 }}
                                </div>

                                <!-- Image de cover -->
                                <div
                                    class="w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500 flex-shrink-0">
                                    <img v-if="music.cover_image_url" :src="music.cover_image_url" :alt="music.title"
                                        class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <MusicalNoteIcon class="w-6 h-6 text-white opacity-90" />
                                    </div>
                                </div>

                                <!-- Informations -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-white font-semibold text-sm truncate">{{ music.title }}</h3>
                                    <p class="text-white/70 text-xs truncate">{{ music.user?.name || 'Artiste inconnu'
                                        }}</p>
                                    <div class="flex items-center gap-2 mt-1 text-xs text-white/50">
                                        <span>{{ formatDuration(music.duration) }}</span>
                                        <span>{{ formatNumber(music.views) }} vues</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1">
                                    <button @click="playMusic(music)" :class="[
                                        'p-1.5 rounded-lg transition-colors',
                                        currentPlayingIndex === index && isPlaying
                                            ? 'bg-green-600 hover:bg-green-700 text-white'
                                            : 'bg-purple-600 hover:bg-purple-700 text-white'
                                    ]">
                                        <PlayIcon v-if="!(currentPlayingIndex === index && isPlaying)"
                                            class="w-4 h-4" />
                                        <PauseIcon v-else class="w-4 h-4" />
                                    </button>
                                    <button @click="goToMusic(music)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-lg transition-colors">
                                        <ArrowTopRightOnSquareIcon class="w-4 h-4" />
                                    </button>
                                    <button v-if="isOwnPlaylist" @click="removeMusic(music)"
                                        class="bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-lg transition-colors">
                                        <TrashIcon class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <MusicalNoteIcon class="w-12 h-12 text-white/60 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Playlist vide</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Cette playlist ne contient aucune musique pour le moment.
                            </p>
                            <button v-if="isOwnPlaylist" @click="addMusic"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <PlusIcon class="w-4 h-4 inline mr-1" />
                                Ajouter une musique
                            </button>
                        </div>
                    </section>

                    <!-- Contrôles de navigation (si en cours de lecture) -->
                    <section v-if="isPlaying && playlist.musics && playlist.musics.length > 1"
                        class="glass rounded-2xl p-4">
                        <div class="flex items-center justify-between">
                            <button @click="playPreviousMusic" :disabled="currentPlayingIndex <= 0" :class="[
                                'px-3 py-2 rounded-lg transition-colors flex items-center gap-2 text-sm',
                                currentPlayingIndex > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-600 text-gray-400 cursor-not-allowed'
                            ]">
                                <ChevronLeftIcon class="w-4 h-4" />
                                Précédent
                            </button>
                            <span class="text-white text-sm">
                                {{ currentPlayingIndex + 1 }} / {{ playlist.musics.length }}
                            </span>
                            <button @click="playNextMusic" :disabled="currentPlayingIndex >= playlist.musics.length - 1"
                                :class="[
                                    'px-3 py-2 rounded-lg transition-colors flex items-center gap-2 text-sm',
                                    currentPlayingIndex < playlist.musics.length - 1 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-600 text-gray-400 cursor-not-allowed'
                                ]">
                                Suivant
                                <ChevronRightIcon class="w-4 h-4" />
                            </button>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>

        <!-- Notification -->
        <div v-if="notification.show"
            class="fixed top-5 right-5 bg-gradient-to-r from-purple-600 to-cyan-500 text-white px-5 py-4 rounded-xl z-50 font-bold shadow-lg transform transition-transform duration-300"
            :class="notification.show ? 'translate-x-0' : 'translate-x-full'">
            {{ notification.message }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { router, usePage, Head } from '@inertiajs/vue3'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import {
    UserIcon,
    MusicalNoteIcon,
    CalendarIcon,
    PlayIcon,
    PauseIcon,
    TrashIcon,
    ArrowTopRightOnSquareIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    PlusIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    playlist: {
        type: Object,
        required: true
    }
})

const page = usePage()
const musicList = ref(null)

// État réactif
const notification = ref({
    show: false,
    message: ''
})

// Variables pour le drag and drop
let draggedIndex = null
let draggedElement = null

// Computed properties
const isOwnPlaylist = computed(() => {
    return page.props.auth?.user && page.props.auth.user.id === props.playlist.user_id
})

// Méthodes
const handleLiveRadioToggle = (isPlaying) => {
    showNotification(isPlaying ? 'Connexion au Live Radio...' : 'Radio arrêtée', 'radio')
}

const showNotification = (message, type = 'info') => {
    let icon = ''
    switch (type) {
        case 'success':
            icon = '✓ '
            break
        case 'error':
            icon = '✗ '
            break
        case 'warning':
            icon = '⚠ '
            break
        case 'music':
            icon = '♪ '
            break
        case 'radio':
            icon = '📻 '
            break
        default:
            icon = 'ℹ '
    }

    notification.value = {
        show: true,
        message: icon + message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

const formatDate = (dateString) => {
    if (!dateString) return 'Date inconnue'
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatDuration = (seconds) => {
    if (!seconds) return '0:00'
    const minutes = Math.floor(seconds / 60)
    const remainingSeconds = seconds % 60
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`
}

const formatNumber = (num) => {
    if (!num || isNaN(num)) return '0'
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
}

// État pour le lecteur audio
const currentPlayingIndex = ref(-1)
const isPlaying = ref(false)
const audioPlayer = ref(null)

const playMusic = (music) => {
    // Si on clique sur la même musique, toggle play/pause
    const musicIndex = props.playlist.musics.findIndex(m => m.id === music.id)

    if (currentPlayingIndex.value === musicIndex && isPlaying.value) {
        // Pause
        if (audioPlayer.value) {
            audioPlayer.value.pause()
            isPlaying.value = false
        }
    } else {
        // Play
        currentPlayingIndex.value = musicIndex
        isPlaying.value = true

        // Créer ou mettre à jour l'audio player
        if (audioPlayer.value) {
            audioPlayer.value.pause()
        }

        audioPlayer.value = new Audio(`/audio/${getAudioFilename(music.file_path)}`)
        audioPlayer.value.play()

        // Écouter les événements audio
        audioPlayer.value.addEventListener('ended', () => {
            // Jouer la musique suivante automatiquement
            playNextMusic()
        })

        audioPlayer.value.addEventListener('error', () => {
            showNotification('Erreur lors du chargement du fichier audio', 'error')
            isPlaying.value = false
        })
    }
}

const playNextMusic = () => {
    if (currentPlayingIndex.value < props.playlist.musics.length - 1) {
        const nextMusic = props.playlist.musics[currentPlayingIndex.value + 1]
        playMusic(nextMusic)
    } else {
        // Fin de la playlist
        isPlaying.value = false
        currentPlayingIndex.value = -1
        showNotification('Fin de la playlist', 'music')
    }
}

const playPreviousMusic = () => {
    if (currentPlayingIndex.value > 0) {
        const previousMusic = props.playlist.musics[currentPlayingIndex.value - 1]
        playMusic(previousMusic)
    }
}

const getAudioFilename = (filePath) => {
    if (!filePath) return ''
    return filePath.split('/').pop()
}

const goToMusic = (music) => {
    router.visit(`/music/${music.slug || music.id}`)
}

const removeMusic = async (music) => {
    if (!confirm(`Êtes-vous sûr de vouloir retirer "${music.title}" de cette playlist ?`)) {
        return
    }

    try {
        const response = await fetch(`/playlists/${props.playlist.slug || props.playlist.id}/remove-music`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ music_id: music.id })
        })

        if (response.ok) {
            showNotification('Musique retirée de la playlist', 'success')
            // Mettre à jour l'état local
            const musicIndex = props.playlist.musics.findIndex(m => m.id === music.id)
            if (musicIndex > -1) {
                props.playlist.musics.splice(musicIndex, 1)
            }
        } else {
            showNotification('Erreur lors de la suppression', 'error')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors de la suppression', 'error')
    }
}

const toggleVisibility = async () => {
    try {
        const response = await fetch(`/playlists/${props.playlist.slug || props.playlist.id}/toggle-visibility`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })

        if (response.ok) {
            const data = await response.json()
            showNotification(data.message, 'success')
            // Mettre à jour l'état local
            props.playlist.is_public = !props.playlist.is_public
        } else {
            showNotification('Erreur lors du changement de visibilité', 'error')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors du changement de visibilité', 'error')
    }
}

// Drag and Drop
const dragStart = (event, index) => {
    draggedIndex = index
    draggedElement = event.target.closest('[draggable="true"]')
    event.dataTransfer.effectAllowed = 'move'
    event.target.style.opacity = '0.5'
}

const drop = async (event, dropIndex) => {
    event.preventDefault()

    if (draggedIndex === null || draggedIndex === dropIndex) {
        return
    }

    // Mettre à jour l'ordre visuellement
    const musics = [...props.playlist.musics]
    const draggedMusic = musics[draggedIndex]
    musics.splice(draggedIndex, 1)
    musics.splice(dropIndex, 0, draggedMusic)

    // Mettre à jour l'état local immédiatement
    props.playlist.musics = musics

    // Envoyer la nouvelle ordre au serveur
    try {
        const response = await fetch(`/playlists/${props.playlist.slug || props.playlist.id}/reorder`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                music_ids: musics.map(music => music.id)
            })
        })

        if (response.ok) {
            showNotification('Ordre des musiques mis à jour', 'success')
        } else {
            showNotification('Erreur lors de la réorganisation', 'error')
            // Recharger la page en cas d'erreur pour revenir à l'état original
            window.location.reload()
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors de la réorganisation', 'error')
        // Recharger la page en cas d'erreur pour revenir à l'état original
        window.location.reload()
    }

    // Réinitialiser
    draggedIndex = null
    draggedElement = null
    event.target.style.opacity = '1'
}

onMounted(() => {
    // Ajouter des styles pour le drag and drop
    const style = document.createElement('style')
    style.textContent = `
        [draggable="true"]:hover {
            transform: scale(1.02);
        }
        [draggable="true"]:active {
            transform: scale(0.98);
        }
    `
    document.head.appendChild(style)
})

// Nettoyer l'audio player quand on quitte la page
onUnmounted(() => {
    if (audioPlayer.value) {
        audioPlayer.value.pause()
        audioPlayer.value = null
    }
})
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-reverse {

    0%,
    100% {
        transform: translateY(0px) rotate(45deg);
    }

    50% {
        transform: translateY(-20px) rotate(45deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}
</style>
