<template>

    <Head :title="`${music?.title || 'Musique'} - JaaJ FM`" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- En-tête de la musique -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-start gap-6">
                            <!-- Cover de la musique -->
                            <div class="cover-section">
                                <div v-if="music?.cover_image_url" class="music-cover"
                                    :style="{ backgroundImage: `url(${music.cover_image_url})` }"></div>
                                <div v-else class="music-cover-placeholder">
                                    <MusicalNoteIcon class="w-16 h-16 text-white opacity-90" />
                                </div>
                            </div>

                            <!-- Informations de la musique -->
                            <div class="music-info flex-1">
                                <div class="music-header">
                                    <h1 class="music-title">
                                        {{ music?.title || 'Titre inconnu' }}
                                        <span v-if="music?.is_ai_generated" class="ai-badge">🤖 AI</span>
                                    </h1>
                                    <p class="music-artist">
                                        <span v-if="music?.user?.name" @click="goToArtistProfile(music.user.name)"
                                            class="artist-link cursor-pointer hover:text-purple-300 transition-colors">
                                            {{ music.user.name }}
                                        </span>
                                        <span v-else>Artiste inconnu</span>
                                    </p>
                                </div>

                                <!-- Statistiques -->
                                <div class="music-stats">
                                    <div class="stat-item">
                                        <EyeIcon class="w-5 h-5" />
                                        <span>{{ formatNumber(music?.views || 0) }} vues</span>
                                    </div>
                                    <div class="stat-item">
                                        <HeartIcon class="w-5 h-5" />
                                        <span>{{ formatNumber(music?.likes_count || 0) }} likes</span>
                                    </div>
                                    <div class="stat-item">
                                        <ChatBubbleLeftIcon class="w-5 h-5" />
                                        <span>{{ formatNumber(music?.comments_count || 0) }} commentaires</span>
                                    </div>
                                </div>

                                <!-- Genres -->
                                <div v-if="music?.genres && music.genres.length > 0" class="music-genres">
                                    <span v-for="genre in music.genres" :key="genre.id" class="genre-tag"
                                        :style="{ backgroundColor: genre.color + '20', color: genre.color }">
                                        {{ genre.name }}
                                    </span>
                                </div>

                                <!-- Description -->
                                <div v-if="music?.description" class="music-description">
                                    <p class="text-white/80">{{ music.description }}</p>
                                </div>

                                <!-- Date de publication -->
                                <div class="music-date">
                                    <CalendarIcon class="w-4 h-4" />
                                    <span>Publié le {{ formatDate(music?.created_at) }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="music-actions">
                                <button @click="toggleLike" class="action-btn" :class="{ 'liked': isLiked }">
                                    <HeartIcon v-if="!isLiked" class="w-6 h-6" />
                                    <HeartSolidIcon v-else class="w-6 h-6" />
                                    <span>{{ isLiked ? 'Aimé' : 'Aimer' }}</span>
                                </button>

                                <button @click="toggleFollow" class="action-btn" :class="{ 'following': isFollowing }">
                                    <UserPlusIcon v-if="!isFollowing" class="w-6 h-6" />
                                    <CheckIcon v-else class="w-6 h-6" />
                                    <span>{{ isFollowing ? 'Abonné' : 'S\'abonner' }}</span>
                                </button>

                                <button @click="addToPlaylist" class="action-btn">
                                    <PlusIcon class="w-6 h-6" />
                                    <span>Ajouter</span>
                                </button>

                                <button @click="shareMusic" class="action-btn">
                                    <ShareIcon class="w-6 h-6" />
                                    <span>Partager</span>
                                </button>

                                <button @click="openReportModal" class="action-btn">
                                    <ExclamationTriangleIcon class="w-6 h-6" />
                                    <span>Signaler</span>
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Lecteur audio personnalisé -->
                    <section v-if="music" class="glass rounded-2xl">
                        <CustomAudioPlayer :track="music" :audio-url="audioUrl" :is-liked="isLiked"
                            :is-following="isFollowing" :has-previous="hasPrevious" :has-next="hasNext" @play="onPlay"
                            @pause="onPause" @like="toggleLike" @unlike="toggleLike" @follow="toggleFollow"
                            @unfollow="toggleFollow" @add-to-playlist="addToPlaylist" @share="shareMusic"
                            @previous="previousTrack" @next="nextTrack" />
                    </section>

                    <!-- Musiques similaires -->
                    <section v-if="similarTracks.length > 0" class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Musiques similaires</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <MusicCard v-for="track in similarTracks" :key="track.id" :track="track"
                                @play="playSimilarTrack" />
                        </div>
                    </section>

                    <!-- Commentaires -->
                    <section class="glass rounded-2xl">
                        <MusicComments :comments="comments" :user="user" :has-more-comments="hasMoreComments"
                            :is-loading-more="isLoadingMore" @submit-comment="submitComment" @submit-reply="submitReply"
                            @like-comment="likeComment" @delete-comment="deleteComment" @load-more="loadMoreComments"
                            @report-comment="handleCommentReport" />
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <div class="space-y-6">
                    <!-- En-tête de la musique -->
                    <section class="glass rounded-2xl p-4">
                        <div class="flex items-start gap-4">
                            <!-- Cover de la musique -->
                            <div class="cover-section">
                                <div v-if="music?.cover_image_url" class="music-cover-mobile"
                                    :style="{ backgroundImage: `url(${music.cover_image_url})` }"></div>
                                <div v-else class="music-cover-placeholder-mobile">
                                    <MusicalNoteIcon class="w-12 h-12 text-white opacity-90" />
                                </div>
                            </div>

                            <!-- Informations de la musique -->
                            <div class="music-info flex-1">
                                <div class="music-header">
                                    <h1 class="music-title-mobile">
                                        {{ music?.title || 'Titre inconnu' }}
                                        <span v-if="music?.is_ai_generated" class="ai-badge">🤖 AI</span>
                                    </h1>
                                    <p class="music-artist-mobile">
                                        <span v-if="music?.user?.name" @click="goToArtistProfile(music.user.name)"
                                            class="artist-link cursor-pointer hover:text-purple-300 transition-colors">
                                            {{ music.user.name }}
                                        </span>
                                        <span v-else>Artiste inconnu</span>
                                    </p>
                                </div>

                                <!-- Statistiques -->
                                <div class="music-stats-mobile">
                                    <div class="stat-item">
                                        <EyeIcon class="w-4 h-4" />
                                        <span>{{ formatNumber(music?.views || 0) }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <HeartIcon class="w-4 h-4" />
                                        <span>{{ formatNumber(music?.likes_count || 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Lecteur audio personnalisé -->
                    <section v-if="music" class="glass rounded-2xl">
                        <CustomAudioPlayer :track="music" :audio-url="audioUrl" :is-liked="isLiked"
                            :is-following="isFollowing" :has-previous="hasPrevious" :has-next="hasNext" @play="onPlay"
                            @pause="onPause" @like="toggleLike" @unlike="toggleLike" @follow="toggleFollow"
                            @unfollow="toggleFollow" @add-to-playlist="addToPlaylist" @share="shareMusic"
                            @previous="previousTrack" @next="nextTrack" />
                    </section>

                    <!-- Actions mobiles -->
                    <section class="glass rounded-2xl p-4">
                        <div class="flex justify-around">
                            <button @click="toggleLike" class="mobile-action-btn" :class="{ 'liked': isLiked }">
                                <HeartIcon v-if="!isLiked" class="w-6 h-6" />
                                <HeartSolidIcon v-else class="w-6 h-6" />
                                <span class="text-xs">{{ isLiked ? 'Aimé' : 'Aimer' }}</span>
                            </button>

                            <button @click="toggleFollow" class="mobile-action-btn"
                                :class="{ 'following': isFollowing }">
                                <UserPlusIcon v-if="!isFollowing" class="w-6 h-6" />
                                <CheckIcon v-else class="w-6 h-6" />
                                <span class="text-xs">{{ isFollowing ? 'Abonné' : 'S\'abonner' }}</span>
                            </button>

                            <button @click="openReportModal" class="mobile-action-btn">
                                <ExclamationTriangleIcon class="w-6 h-6" />
                                <span class="text-xs">Signaler</span>
                            </button>

                            <button @click="addToPlaylist" class="mobile-action-btn">
                                <PlusIcon class="w-6 h-6" />
                                <span class="text-xs">Ajouter</span>
                            </button>

                            <button @click="shareMusic" class="mobile-action-btn">
                                <ShareIcon class="w-6 h-6" />
                                <span class="text-xs">Partager</span>
                            </button>
                        </div>
                    </section>

                    <!-- Commentaires -->
                    <section class="glass rounded-2xl">
                        <MusicComments :comments="comments" :user="user" :has-more-comments="hasMoreComments"
                            :is-loading-more="isLoadingMore" @submit-comment="submitComment" @submit-reply="submitReply"
                            @like-comment="likeComment" @delete-comment="deleteComment" @load-more="loadMoreComments" />
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>

    <!-- Modal Playlist -->
    <PlaylistModal :show="showPlaylistModal" :music-id="selectedMusicId" @close="showPlaylistModal = false"
        @playlist-created="handlePlaylistCreated" @music-added="handleMusicAdded" />

    <!-- Modal Signalement -->
    <ReportModal :show="showReportModal" :reportable-type="selectedReportableType || 'App\\Models\\Music'" :reportable-id="selectedReportableId || music?.id"
        @close="showReportModal = false" @reported="handleReportSubmitted" />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import {
    EyeIcon, HeartIcon, ChatBubbleLeftIcon, CalendarIcon,
    MusicalNoteIcon, UserPlusIcon, CheckIcon, PlusIcon, ShareIcon,
    ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid'

import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import CustomAudioPlayer from '@/Components/CustomAudioPlayer.vue'
import MusicComments from '@/Components/MusicComments.vue'
import MusicCard from '@/Components/MusicCard.vue'
import PlaylistModal from '@/Components/PlaylistModal.vue'
import ReportModal from '@/Components/ReportModal.vue'

// Props
const props = defineProps({
    music: Object,
    user: Object,
    comments: {
        type: Array,
        default: () => []
    },
    similarTracks: {
        type: Array,
        default: () => []
    },
    isLiked: {
        type: Boolean,
        default: false
    },
    isFollowing: {
        type: Boolean,
        default: false
    },
    hasMoreComments: {
        type: Boolean,
        default: false
    },
    isLoadingMore: {
        type: Boolean,
        default: false
    }
})

// État local
const isLiked = ref(props.isLiked)
const isFollowing = ref(props.isFollowing)
const hasPrevious = ref(false)
const hasNext = ref(false)
const currentPage = ref(1)

// Modal playlist
const showPlaylistModal = ref(false)
const selectedMusicId = ref(null)

// Modal signalement
const showReportModal = ref(false)
const selectedReportableId = ref(null)
const selectedReportableType = ref(null)

// Computed
const audioUrl = computed(() => {
    if (!props.music?.file_path) return ''
    return `/storage/${props.music.file_path}`
})

// Méthodes
const toggleLike = async () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/music/${props.music.id}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        if (response.ok) {
            isLiked.value = !isLiked.value
        }
    } catch (error) {
        console.error('Erreur lors du like:', error)
    }
}

const toggleFollow = async () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/users/${props.music.user.id}/follow`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        if (response.ok) {
            isFollowing.value = !isFollowing.value
        }
    } catch (error) {
        console.error('Erreur lors de l\'abonnement:', error)
    }
}

const addToPlaylist = () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    selectedMusicId.value = props.music.id
    showPlaylistModal.value = true
}

const shareMusic = () => {
    if (navigator.share) {
        navigator.share({
            title: props.music.title,
            text: `Écoutez "${props.music.title}" par ${props.music.user.name} sur JaaJ FM`,
            url: window.location.href
        })
    } else {
        // Fallback: copier le lien
        navigator.clipboard.writeText(window.location.href)
        // TODO: Afficher une notification
    }
}

const onPlay = () => {
    console.log('Musique en lecture')
}

const onPause = () => {
    console.log('Musique en pause')
}

const previousTrack = () => {
    // TODO: Implémenter la piste précédente
    console.log('Piste précédente')
}

const nextTrack = () => {
    // TODO: Implémenter la piste suivante
    console.log('Piste suivante')
}

const playSimilarTrack = (track) => {
    router.visit(`/music/${track.slug || track.id}`)
}

const submitComment = async (content) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/music/${props.music.id}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content })
        })
        if (response.ok) {
            // Recharger la page pour afficher le nouveau commentaire
            window.location.reload()
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout du commentaire:', error)
    }
}

const submitReply = async ({ commentId, content }) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/comments/${commentId}/replies`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content })
        })
        if (response.ok) {
            // Recharger la page pour afficher la nouvelle réponse
            window.location.reload()
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout de la réponse:', error)
    }
}

const likeComment = async (commentId) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        if (response.ok) {
            // Recharger la page pour mettre à jour les likes
            window.location.reload()
        }
    } catch (error) {
        console.error('Erreur lors du like du commentaire:', error)
    }
}

const deleteComment = async (commentId) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        if (response.ok) {
            // Recharger la page pour supprimer le commentaire
            window.location.reload()
        }
    } catch (error) {
        console.error('Erreur lors de la suppression du commentaire:', error)
    }
}

const loadMoreComments = async () => {
    try {
        const response = await fetch(`/music/${props.music.id}/comments?page=${currentPage.value + 1}`)
        if (response.ok) {
            const data = await response.json()
            // TODO: Implémenter le chargement de plus de commentaires
            console.log('Chargement de plus de commentaires:', data)
        }
    } catch (error) {
        console.error('Erreur lors du chargement des commentaires:', error)
    }
}

const handlePlaylistCreated = (playlist) => {
    showNotification(`🎵 Playlist "${playlist.name}" créée et musique ajoutée !`)
}

const handleMusicAdded = ({ playlist, message }) => {
    showNotification(`🎵 Musique ajoutée à "${playlist.name}" !`)
}

const showNotification = (message) => {
    // TODO: Implémenter un système de notification
    console.log(message)
}

const openReportModal = () => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    showReportModal.value = true
}

const handleReportSubmitted = () => {
    showReportModal.value = false
    // Optionnel: afficher une notification de succès
    console.log('Signalement soumis avec succès')
}

const handleCommentReport = (comment) => {
    showReportModal.value = true
    selectedReportableId.value = comment.id
    selectedReportableType.value = 'comment'
}

// Utilitaires
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

const formatDate = (date) => {
    if (!date) return ''
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    })
}

const goToArtistProfile = (artistName) => {
    // Rechercher l'artiste par son nom et naviguer vers son profil
    router.get(`/profile/${encodeURIComponent(artistName)}`)
}

// Lifecycle
onMounted(() => {
    // Marquer la musique comme vue
    if (props.music) {
        fetch(`/music/${props.music.id}/view`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
    }
})
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}

.cover-section {
    @apply flex-shrink-0;
}

.music-cover {
    @apply w-48 h-48 rounded-2xl bg-cover bg-center shadow-2xl;
}

.music-cover-placeholder {
    @apply w-48 h-48 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-2xl;
}

.music-cover-mobile {
    @apply w-20 h-20 rounded-xl bg-cover bg-center;
}

.music-cover-placeholder-mobile {
    @apply w-20 h-20 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-xl flex items-center justify-center;
}

.music-info {
    @apply flex-1 min-w-0;
}

.music-header {
    @apply mb-4;
}

.music-title {
    @apply text-3xl font-bold text-white mb-2 flex items-center gap-2;
}

.music-title-mobile {
    @apply text-lg font-bold text-white mb-1 flex items-center gap-2;
}

.music-artist {
    @apply text-xl text-white/80;
}

.music-artist-mobile {
    @apply text-sm text-white/80;
}

.ai-badge {
    @apply text-cyan-400 text-sm bg-cyan-400/20 px-2 py-1 rounded-full;
}

.music-stats {
    @apply flex gap-6 mb-4;
}

.music-stats-mobile {
    @apply flex gap-4;
}

.stat-item {
    @apply flex items-center gap-2 text-white/60 text-sm;
}

.music-genres {
    @apply flex flex-wrap gap-2 mb-4;
}

.genre-tag {
    @apply text-xs px-3 py-1 rounded-full font-medium;
}

.music-description {
    @apply mb-4;
}

.music-date {
    @apply flex items-center gap-2 text-white/40 text-sm;
}

.music-actions {
    @apply flex flex-col gap-3;
}

.action-btn {
    @apply flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-xl text-white hover:bg-white/20 transition-all;
}

.action-btn.liked {
    @apply bg-pink-500/20 border-pink-500/30 text-pink-400;
}

.action-btn.following {
    @apply bg-green-500/20 border-green-500/30 text-green-400;
}

.mobile-action-btn {
    @apply flex flex-col items-center gap-1 p-3 text-white/80 hover:text-white transition-colors;
}

.mobile-action-btn.liked {
    @apply text-pink-400;
}

.mobile-action-btn.following {
    @apply text-green-400;
}

/* Responsive */
@media (max-width: 640px) {
    .music-cover {
        @apply w-32 h-32;
    }

    .music-cover-placeholder {
        @apply w-32 h-32;
    }

    .music-title {
        @apply text-xl;
    }

    .music-stats {
        @apply gap-4;
    }

    .stat-item {
        @apply text-xs;
    }
}
</style>
