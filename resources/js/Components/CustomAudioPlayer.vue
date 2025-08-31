<template>
    <div class="custom-audio-player glass">
        <!-- Cover et informations -->
        <div class="player-info">
            <div class="cover-container">
                <div v-if="track?.cover_image_url" class="cover-image"
                    :style="{ backgroundImage: `url(${track.cover_image_url})` }"></div>
                <div v-else class="cover-placeholder">
                    <MusicalNoteIcon class="w-12 h-12 text-white opacity-90" />
                </div>
            </div>

            <div class="track-details">
                <h3 class="track-title">{{ track?.title || 'Titre inconnu' }}</h3>
                <p class="track-artist">{{ track?.user?.name || 'Artiste inconnu' }}</p>
                <div class="track-stats">
                    <span class="stat">
                        <EyeIcon class="w-4 h-4" />
                        {{ formatNumber(track?.views || 0) }} vues
                    </span>
                    <span class="stat">
                        <HeartIcon class="w-4 h-4" />
                        {{ formatNumber(track?.likes_count || 0) }} likes
                    </span>
                </div>
            </div>
        </div>

        <!-- Contrôles audio -->
        <div class="audio-controls">
            <!-- Barre de progression -->
            <div class="progress-container">
                <div class="progress-bar" @click="seekTo">
                    <div class="progress-fill" :style="{ width: progress + '%' }"></div>
                    <div class="progress-handle" :style="{ left: progress + '%' }"></div>
                </div>
                <div class="time-display">
                    <span class="current-time">{{ formatTime(currentTime) }}</span>
                    <span class="total-time">{{ formatTime(duration) }}</span>
                </div>
            </div>

            <!-- Boutons de contrôle -->
            <div class="control-buttons">
                <button @click="previousTrack" class="control-btn" :disabled="!hasPrevious">
                    <BackwardIcon class="w-6 h-6" />
                </button>

                <button @click="togglePlay" class="play-btn">
                    <PlayIcon v-if="!isPlaying" class="w-8 h-8" />
                    <PauseIcon v-else class="w-8 h-8" />
                </button>

                <button @click="nextTrack" class="control-btn" :disabled="!hasNext">
                    <ForwardIcon class="w-6 h-6" />
                </button>
            </div>

            <!-- Contrôles supplémentaires -->
            <div class="additional-controls">
                <button @click="toggleMute" class="control-btn">
                    <SpeakerWaveIcon v-if="!isMuted" class="w-5 h-5" />
                    <SpeakerXMarkIcon v-else class="w-5 h-5" />
                </button>

                <div class="volume-container">
                    <input type="range" min="0" max="100" v-model="volume" @input="updateVolume"
                        class="volume-slider" />
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="player-actions">
            <button @click="toggleLike" class="action-btn" :class="{ 'liked': isLiked }">
                <HeartIcon v-if="!isLiked" class="w-6 h-6" />
                <HeartSolidIcon v-else class="w-6 h-6" />
            </button>

            <button @click="toggleFollow" class="action-btn" :class="{ 'following': isFollowing }">
                <UserPlusIcon v-if="!isFollowing" class="w-6 h-6" />
                <CheckIcon v-else class="w-6 h-6" />
            </button>

            <button @click="addToPlaylist" class="action-btn">
                <PlusIcon class="w-6 h-6" />
            </button>

            <button @click="shareTrack" class="action-btn">
                <ShareIcon class="w-6 h-6" />
            </button>
        </div>

        <!-- Élément audio caché -->
        <audio ref="audioElement" :src="audioUrl" @loadedmetadata="onLoadedMetadata" @timeupdate="onTimeUpdate"
            @ended="onEnded" @error="onError" preload="metadata"></audio>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import {
    PlayIcon, PauseIcon, BackwardIcon, ForwardIcon,
    SpeakerWaveIcon, SpeakerXMarkIcon, HeartIcon, UserPlusIcon,
    CheckIcon, PlusIcon, ShareIcon, EyeIcon, MusicalNoteIcon
} from '@heroicons/vue/24/outline'
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    track: {
        type: Object,
        required: true
    },
    audioUrl: {
        type: String,
        required: true
    },
    isLiked: {
        type: Boolean,
        default: false
    },
    isFollowing: {
        type: Boolean,
        default: false
    },
    hasPrevious: {
        type: Boolean,
        default: false
    },
    hasNext: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits([
    'play', 'pause', 'timeupdate', 'ended', 'like', 'unlike',
    'follow', 'unfollow', 'add-to-playlist', 'share', 'previous', 'next'
])

// Références
const audioElement = ref(null)

// État du lecteur
const isPlaying = ref(false)
const isMuted = ref(false)
const currentTime = ref(0)
const duration = ref(0)
const volume = ref(100)

// Computed
const progress = computed(() => {
    if (duration.value === 0) return 0
    return (currentTime.value / duration.value) * 100
})

// Méthodes
const togglePlay = () => {
    if (isPlaying.value) {
        audioElement.value.pause()
        isPlaying.value = false
        emit('pause')
    } else {
        audioElement.value.play()
        isPlaying.value = true
        emit('play')
    }
}

const toggleMute = () => {
    isMuted.value = !isMuted.value
    audioElement.value.muted = isMuted.value
}

const updateVolume = () => {
    audioElement.value.volume = volume.value / 100
}

const seekTo = (event) => {
    const rect = event.currentTarget.getBoundingClientRect()
    const clickX = event.clientX - rect.left
    const percentage = clickX / rect.width
    const newTime = percentage * duration.value
    audioElement.value.currentTime = newTime
    currentTime.value = newTime
}

const toggleLike = () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    if (props.isLiked) {
        emit('unlike')
    } else {
        emit('like')
    }
}

const toggleFollow = () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    if (props.isFollowing) {
        emit('unfollow')
    } else {
        emit('follow')
    }
}

const addToPlaylist = () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    emit('add-to-playlist')
}

const shareTrack = () => {
    emit('share')
}

const previousTrack = () => {
    emit('previous')
}

const nextTrack = () => {
    emit('next')
}

// Événements audio
const onLoadedMetadata = () => {
    duration.value = audioElement.value.duration
}

const onTimeUpdate = () => {
    currentTime.value = audioElement.value.currentTime
    emit('timeupdate', currentTime.value)
}

const onEnded = () => {
    isPlaying.value = false
    emit('ended')
}

const onError = (error) => {
    console.error('Erreur audio:', error)
    // Réinitialiser l'état du lecteur en cas d'erreur
    isPlaying.value = false
    currentTime.value = 0
    duration.value = 0
}

// Utilitaires
const formatTime = (seconds) => {
    if (isNaN(seconds)) return '0:00'
    const mins = Math.floor(seconds / 60)
    const secs = Math.floor(seconds % 60)
    return `${mins}:${secs.toString().padStart(2, '0')}`
}

const formatNumber = (num) => {
    if (num === null || num === undefined || isNaN(num)) {
        return '0'
    }
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
}

// Watchers
watch(() => props.audioUrl, (newUrl) => {
    if (newUrl && audioElement.value) {
        audioElement.value.load()
    }
})

// Lifecycle
onMounted(() => {
    if (audioElement.value) {
        audioElement.value.volume = volume.value / 100
    }
})

onUnmounted(() => {
    if (audioElement.value) {
        audioElement.value.pause()
    }
})
</script>

<style scoped>
.custom-audio-player {
    @apply p-6 rounded-2xl border border-white/20;
}

.player-info {
    @apply flex items-center gap-4 mb-6;
}

.cover-container {
    @apply w-20 h-20 rounded-xl overflow-hidden flex-shrink-0;
}

.cover-image {
    @apply w-full h-full bg-cover bg-center;
}

.cover-placeholder {
    @apply w-full h-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 flex items-center justify-center;
}

.track-details {
    @apply flex-1 min-w-0;
}

.track-title {
    @apply text-white font-bold text-lg mb-1 truncate;
}

.track-artist {
    @apply text-white/80 text-sm mb-2;
}

.track-stats {
    @apply flex gap-4 text-white/60 text-xs;
}

.stat {
    @apply flex items-center gap-1;
}

.audio-controls {
    @apply space-y-4;
}

.progress-container {
    @apply space-y-2;
}

.progress-bar {
    @apply relative h-2 bg-white/20 rounded-full cursor-pointer overflow-hidden;
}

.progress-fill {
    @apply absolute top-0 left-0 h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-100;
}

.progress-handle {
    @apply absolute top-1/2 w-4 h-4 bg-white rounded-full transform -translate-y-1/2 -translate-x-1/2 shadow-lg transition-all duration-100;
}

.time-display {
    @apply flex justify-between text-white/60 text-xs;
}

.control-buttons {
    @apply flex items-center justify-center gap-4;
}

.control-btn {
    @apply p-2 text-white/80 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed;
}

.play-btn {
    @apply p-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:scale-110 transition-all duration-200 shadow-lg;
}

.additional-controls {
    @apply flex items-center gap-3;
}

.volume-container {
    @apply flex items-center gap-2;
}

.volume-slider {
    @apply w-20 h-1 bg-white/20 rounded-full appearance-none cursor-pointer;
}

.volume-slider::-webkit-slider-thumb {
    @apply appearance-none w-3 h-3 bg-white rounded-full cursor-pointer;
}

.volume-slider::-moz-range-thumb {
    @apply w-3 h-3 bg-white rounded-full cursor-pointer border-none;
}

.player-actions {
    @apply flex items-center justify-center gap-4 mt-6 pt-4 border-t border-white/20;
}

.action-btn {
    @apply p-2 text-white/80 hover:text-white transition-colors rounded-full hover:bg-white/10;
}

.action-btn.liked {
    @apply text-pink-500;
}

.action-btn.following {
    @apply text-green-500;
}

/* Responsive */
@media (max-width: 640px) {
    .custom-audio-player {
        @apply p-4;
    }

    .player-info {
        @apply flex-col text-center;
    }

    .cover-container {
        @apply w-16 h-16;
    }

    .control-buttons {
        @apply gap-2;
    }

    .play-btn {
        @apply p-2;
    }

    .player-actions {
        @apply gap-2;
    }
}
</style>
