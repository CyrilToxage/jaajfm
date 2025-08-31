<template>

    <Head title="JaaJ FM - Plateforme Musicale" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header />

                <!-- Contenu -->
                <HomeContent :popular-musics="safePopularMusics" :recent-musics="safeRecentMusics"
                    :most-liked-musics="safeMostLikedMusics" :popular-genres="safePopularGenres"
                    :musics-by-genre="safeMusicsByGenre" @play="playMusic" @like="toggleLike"
                    @add-to-playlist="handleAddToPlaylist" />
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-20"> <!-- pt-20 pour le header fixe, pb-20 pour la navigation mobile -->
                <MobileHomeContent :popular-musics="safePopularMusics" :recent-musics="safeRecentMusics"
                    :most-liked-musics="safeMostLikedMusics" :most-viewed-tracks="safePopularMusics" :popular-genres="safePopularGenres"
                    :musics-by-genre="safeMusicsByGenre" @play="playMusic" @like="toggleLike"
                    @add-to-playlist="handleAddToPlaylist" />
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

        <!-- Modal Playlist -->
        <PlaylistModal :show="showPlaylistModal" :music-id="selectedMusicId" @close="showPlaylistModal = false"
            @playlist-created="handlePlaylistCreated" @music-added="handleMusicAdded" />
    </div>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import HomeContent from '@/Components/HomeContent.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import MobileHomeContent from '@/Components/MobileHomeContent.vue'
import PlaylistModal from '@/Components/PlaylistModal.vue'
import {
    PlayIcon,
    FireIcon,
    EyeIcon,
    HeartIcon,
    CalendarIcon,
    MusicalNoteIcon,
    SparklesIcon,
    UserGroupIcon,
    MagnifyingGlassIcon,
    QuestionMarkCircleIcon,
    SpeakerWaveIcon,
    SpeakerXMarkIcon
} from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    popularMusics: {
        type: Array,
        default: () => []
    },
    recentMusics: {
        type: Array,
        default: () => []
    },
    mostLikedMusics: {
        type: Array,
        default: () => []
    },
    popularGenres: {
        type: Array,
        default: () => []
    },
    musicsByGenre: {
        type: Object,
        default: () => ({})
    },
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

const showPlaylistModal = ref(false)
const selectedMusicId = ref(null)

// Computed properties pour une meilleure gestion des données
const safePopularMusics = computed(() => {
    return Array.isArray(props.popularMusics) ? props.popularMusics : []
})
const safeRecentMusics = computed(() => {
    return Array.isArray(props.recentMusics) ? props.recentMusics : []
})
const safeMostLikedMusics = computed(() => {
    return Array.isArray(props.mostLikedMusics) ? props.mostLikedMusics : []
})
const safePopularGenres = computed(() => {
    return Array.isArray(props.popularGenres) ? props.popularGenres : []
})
const safeMusicsByGenre = computed(() => {
    return props.musicsByGenre || {}
})

// Méthodes
const playMusic = (track) => {
    showNotification(`🎵 Lecture: ${track.title} - ${track.user?.name || 'Artiste inconnu'}`)
    // Naviguer vers la page de la musique
    router.visit(`/music/${track.slug || track.id}`)
}

const toggleLike = (track) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    showNotification(`${track.is_liked ? 'Retiré des' : 'Ajouté aux'} likes: ${track.title}`)
    // Ici vous pourriez faire un appel API pour liker/unliker
}

const handleAddToPlaylist = (musicId) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    selectedMusicId.value = musicId
    showPlaylistModal.value = true
}

const handlePlaylistCreated = (playlist) => {
    showNotification(`🎵 Playlist "${playlist.name}" créée et musique ajoutée !`)
}

const handleMusicAdded = ({ playlist, message }) => {
    showNotification(`🎵 Musique ajoutée à "${playlist.name}" !`)
}





const showNotification = (message) => {
    notification.value = {
        show: true,
        message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

// Cycle de vie
onMounted(() => {
    showNotification('Bienvenue sur JaaJ FM !')
})
</script>

<style scoped>
.live-button {
    @apply bg-gradient-to-r from-purple-600 to-pink-500 text-white border-none px-6 py-3 rounded-xl text-lg font-bold cursor-pointer transition-transform duration-300;
}

.live-button:hover {
    @apply transform scale-105;
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

/* Responsive */
@media (max-width: 768px) {
    .music-grid {
        @apply grid-cols-2 md:grid-cols-3;
    }
}

@media (max-width: 640px) {
    .music-grid {
        @apply grid-cols-1 sm:grid-cols-2;
    }
}
</style>
