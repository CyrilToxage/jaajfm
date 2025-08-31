<template>
    <div class="music-card" @click="playTrack">
        <div class="album-cover">
            <div v-if="track.cover_image_url" class="w-full h-full bg-cover bg-center rounded-lg"
                :style="{ backgroundImage: `url(${track.cover_image_url})` }"></div>
            <div v-else
                class="w-full h-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                <MusicalNoteIcon class="w-12 h-12 text-white opacity-90" />
            </div>
            <div class="play-overlay">
                <button class="play-button">
                    <PlayIcon class="w-8 h-8 text-white" />
                </button>
            </div>
        </div>

        <div class="music-info">
            <h3 class="track-title">
                {{ track.title }}
                <span v-if="track.is_ai_generated" class="ai-indicator">🤖 AI</span>
            </h3>

            <div class="track-meta">
                <span v-if="track.category && track.category.name" class="category-tag"
                    :style="{ backgroundColor: (track.category.color || '#8B5CF6') + '20', color: track.category.color || '#8B5CF6' }">
                    {{ track.category.name }}
                </span>
                <!-- Genres -->
                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                    <span v-for="genre in track.genres.slice(0, 3)" :key="genre.id"
                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                            backgroundColor: genre.color + '20',
                            color: genre.color,
                            border: `1px solid ${genre.color}40`
                        }">
                        {{ genre.name }}
                    </span>
                    <span v-if="track.genres.length > 3" class="text-xs text-white/60">
                        +{{ track.genres.length - 3 }}
                    </span>
                </div>

            </div>

            <div class="track-stats">
                <div class="stat">
                    <EyeIcon class="w-4 h-4 text-white/60" />
                    {{ formatNumber(track.views) }} vues
                </div>
                <div class="stat">
                    <HeartIcon class="w-4 h-4 text-white/60" />
                    {{ formatNumber(track.likes_count) }} likes
                </div>
            </div>

            <div class="artist-info">
                <div class="artist-avatar">
                    <img v-if="track.user?.profile_photo_url" :src="track.user.profile_photo_url"
                        :alt="track.user?.name || 'Artiste'" class="w-full h-full rounded-full object-cover">
                    <div v-else class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full"></div>
                </div>
                <span @click.stop="goToProfile" class="artist-name cursor-pointer hover:text-white transition-colors">
                    {{ track.user?.name || 'Artiste inconnu' }}
                </span>
                <button @click.stop="toggleMenu" class="menu-button">
                    <EllipsisVerticalIcon class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                </button>

                <!-- Menu déroulant -->
                <div v-if="showMenu" class="menu-dropdown">
                    <button @click.stop="addToPlaylist" class="menu-item">
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Ajouter à une playlist
                    </button>
                    <button @click.stop="openReportModal" class="menu-item">
                        <FlagIcon class="w-4 h-4 mr-2" />
                        Signaler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de signalement -->
    <ReportModal :show="showReportModal" :reportable-id="track.id" :reportable-type="'App\\Models\\Music'"
        @close="showReportModal = false" @reported="handleReportSubmitted" />
</template>

<script setup>
import { defineProps, defineEmits, ref, onMounted, onUnmounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { HeartIcon, EyeIcon, EllipsisVerticalIcon, PlusIcon, FlagIcon, PlayIcon, MusicalNoteIcon } from '@heroicons/vue/24/outline'
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid'
import ReportModal from '@/Components/ReportModal.vue'

const props = defineProps({
    track: {
        type: Object,
        required: true
    }
})

// Debug: afficher les données du track
console.log('MusicCard track data:', props.track)
console.log('Track views:', props.track.views)
console.log('Track likes_count:', props.track.likes_count)


const emit = defineEmits(['play', 'like'])

// État du menu
const showMenu = ref(false)
const showReportModal = ref(false)

const playTrack = () => {
    // Naviguer vers la page détaillée de la musique
    router.get(`/music/${props.track.slug || props.track.id}`)
}

const goToProfile = () => {
    // Naviguer vers le profil de l'utilisateur
    if (props.track.user?.name) {
        const encodedName = encodeURIComponent(props.track.user.name)
        console.log('Navigating to profile:', `/profile/${encodedName}`)
        router.visit(`/profile/${encodedName}`)
    }
}

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}

const addToPlaylist = () => {
    showMenu.value = false

    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    emit('add-to-playlist', props.track.id)
}

const openReportModal = () => {
    showMenu.value = false
    showReportModal.value = true
}

const handleReportSubmitted = () => {
    showReportModal.value = false
    // Optionnel: afficher une notification de succès
    console.log('Signalement soumis avec succès')
}

// Fermer le menu quand on clique ailleurs
const handleClickOutside = (event) => {
    if (showMenu.value) {
        showMenu.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

const formatNumber = (num) => {
    // Debug: afficher la valeur reçue
    console.log('formatNumber received:', num, 'type:', typeof num)

    // Vérifier si num est null, undefined ou NaN
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
</script>

<style scoped>
.music-card {
    @apply bg-white/15 backdrop-blur-lg rounded-2xl p-4 border border-white/20 transition-all duration-300 cursor-pointer relative overflow-hidden;
}

.music-card::before {
    content: "";
    @apply absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -translate-x-full transition-transform duration-600;
}

.music-card:hover::before {
    @apply translate-x-full;
}

.music-card:hover {
    @apply transform -translate-y-2 bg-white/25 shadow-2xl;
}

.album-cover {
    @apply w-full aspect-square rounded-xl mb-3 relative overflow-hidden;
}

.play-overlay {
    @apply absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 transition-opacity duration-300;
}

.music-card:hover .play-overlay {
    @apply opacity-100;
}

.play-button {
    @apply bg-white/20 backdrop-blur-lg border border-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300;
}

.play-button:hover {
    @apply transform scale-110 bg-white/30 border-white/50;
}

.track-title {
    @apply text-white font-bold text-base mb-2 line-clamp-1;
}

.ai-indicator {
    @apply text-cyan-400 text-xs ml-1;
}

.track-meta {
    @apply mb-2;
}

.category-tag {
    @apply text-xs px-2 py-1 rounded-full font-medium;
}

.track-stats {
    @apply text-white/70 text-xs mb-3 space-y-1;
}

.stat {
    @apply flex items-center gap-1;
}

.stat-icon {
    @apply text-xs;
}

.artist-info {
    @apply flex items-center justify-between;
}

.artist-avatar {
    @apply w-6 h-6 rounded-full mr-2 overflow-hidden;
}

.artist-name {
    @apply text-white text-sm font-medium flex-1 truncate;
}

.menu-button {
    @apply absolute bottom-2 right-2 p-1 hover:bg-white/10 rounded-full transition-all duration-300;
}

.menu-dropdown {
    @apply absolute bottom-10 right-0 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl p-2 min-w-48 z-50;
}

.menu-item {
    @apply flex items-center w-full px-3 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 text-sm;
}



/* Responsive */
@media (max-width: 640px) {
    .music-card {
        @apply p-3;
    }

    .track-title {
        @apply text-sm;
    }

    .artist-name {
        @apply text-xs;
    }
}
</style>
