<template>
    <div class="px-4 py-6 space-y-8">
        <!-- Section Meilleures Musiques (Classement) -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-white">Meilleures Musiques</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4">
                <div v-for="track in popularMusics" :key="track.id" class="flex-shrink-0 w-48">
                    <div class="music-card" @click="playTrack(track)">
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
                                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                                    <span v-for="genre in track.genres.slice(0, 2)" :key="genre.id"
                                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                                            backgroundColor: (genre.color || '#8B5CF6') + '20',
                                            color: genre.color || '#8B5CF6',
                                            border: `1px solid ${(genre.color || '#8B5CF6')}40`
                                        }">
                                        {{ genre.name }}
                                    </span>
                                    <span v-if="track.genres.length > 2" class="text-xs text-white/60">
                                        +{{ track.genres.length - 2 }}
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
                                        :alt="track.user?.name || 'Artiste'"
                                        class="w-full h-full rounded-full object-cover">
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full">
                                    </div>
                                </div>
                                <span class="artist-name">
                                    {{ track.user?.name || 'Artiste inconnu' }}
                                </span>
                                <button @click.stop="addToPlaylist(track)" class="menu-button">
                                    <EllipsisVerticalIcon
                                        class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Musiques Récentes -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-white">Musiques Récentes</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4">
                <div v-for="track in recentMusics" :key="track.id" class="flex-shrink-0 w-48">
                    <div class="music-card" @click="playTrack(track)">
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
                                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                                    <span v-for="genre in track.genres.slice(0, 2)" :key="genre.id"
                                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                                            backgroundColor: (genre.color || '#8B5CF6') + '20',
                                            color: genre.color || '#8B5CF6',
                                            border: `1px solid ${(genre.color || '#8B5CF6')}40`
                                        }">
                                        {{ genre.name }}
                                    </span>
                                    <span v-if="track.genres.length > 2" class="text-xs text-white/60">
                                        +{{ track.genres.length - 2 }}
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
                                        :alt="track.user?.name || 'Artiste'"
                                        class="w-full h-full rounded-full object-cover">
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full">
                                    </div>
                                </div>
                                <span class="artist-name">
                                    {{ track.user?.name || 'Artiste inconnu' }}
                                </span>
                                <button @click.stop="addToPlaylist(track)" class="menu-button">
                                    <EllipsisVerticalIcon
                                        class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Plus Vues -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-white">Plus Vues</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4">
                <div v-for="track in mostViewedTracks" :key="track.id" class="flex-shrink-0 w-48">
                    <div class="music-card" @click="playTrack(track)">
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
                                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                                    <span v-for="genre in track.genres.slice(0, 2)" :key="genre.id"
                                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                                            backgroundColor: (genre.color || '#8B5CF6') + '20',
                                            color: genre.color || '#8B5CF6',
                                            border: `1px solid ${(genre.color || '#8B5CF6')}40`
                                        }">
                                        {{ genre.name }}
                                    </span>
                                    <span v-if="track.genres.length > 2" class="text-xs text-white/60">
                                        +{{ track.genres.length - 2 }}
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
                                        :alt="track.user?.name || 'Artiste'"
                                        class="w-full h-full rounded-full object-cover">
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full">
                                    </div>
                                </div>
                                <span class="artist-name">
                                    {{ track.user?.name || 'Artiste inconnu' }}
                                </span>
                                <button @click.stop="addToPlaylist(track)" class="menu-button">
                                    <EllipsisVerticalIcon
                                        class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Plus Likées -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-white">Plus Likées</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4">
                <div v-for="track in mostLikedMusics" :key="track.id" class="flex-shrink-0 w-48">
                    <div class="music-card" @click="playTrack(track)">
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
                                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                                    <span v-for="genre in track.genres.slice(0, 2)" :key="genre.id"
                                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                                            backgroundColor: (genre.color || '#8B5CF6') + '20',
                                            color: genre.color || '#8B5CF6',
                                            border: `1px solid ${(genre.color || '#8B5CF6')}40`
                                        }">
                                        {{ genre.name }}
                                    </span>
                                    <span v-if="track.genres.length > 2" class="text-xs text-white/60">
                                        +{{ track.genres.length - 2 }}
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
                                        :alt="track.user?.name || 'Artiste'"
                                        class="w-full h-full rounded-full object-cover">
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full">
                                    </div>
                                </div>
                                <span class="artist-name">
                                    {{ track.user?.name || 'Artiste inconnu' }}
                                </span>
                                <button @click.stop="addToPlaylist(track)" class="menu-button">
                                    <EllipsisVerticalIcon
                                        class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sections par Genre -->
        <section v-for="genre in popularGenres" :key="genre.id" class="space-y-4">
            <h2 class="text-2xl font-bold text-white">{{ genre.name }}</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4">
                <div v-for="track in musicsByGenre[genre.id] || []" :key="track.id" class="flex-shrink-0 w-48">
                    <div class="music-card" @click="playTrack(track)">
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
                                <div v-if="track.genres && track.genres.length > 0" class="flex flex-wrap gap-1 mt-1">
                                    <span v-for="genre in track.genres.slice(0, 2)" :key="genre.id"
                                        class="genre-tag text-xs px-2 py-1 rounded-full" :style="{
                                            backgroundColor: (genre.color || '#8B5CF6') + '20',
                                            color: genre.color || '#8B5CF6',
                                            border: `1px solid ${(genre.color || '#8B5CF6')}40`
                                        }">
                                        {{ genre.name }}
                                    </span>
                                    <span v-if="track.genres.length > 2" class="text-xs text-white/60">
                                        +{{ track.genres.length - 2 }}
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
                                        :alt="track.user?.name || 'Artiste'"
                                        class="w-full h-full rounded-full object-cover">
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full">
                                    </div>
                                </div>
                                <span class="artist-name">
                                    {{ track.user?.name || 'Artiste inconnu' }}
                                </span>
                                <button @click.stop="addToPlaylist(track)" class="menu-button">
                                    <EllipsisVerticalIcon
                                        class="w-5 h-5 text-white/60 hover:text-white transition-colors" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import {
    PlayIcon,
    MusicalNoteIcon,
    EllipsisVerticalIcon,
    UserIcon,
    EyeIcon,
    HeartIcon
} from '@heroicons/vue/24/outline'

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
    mostViewedTracks: {
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
    }
})

const emit = defineEmits(['play', 'like', 'add-to-playlist'])

const playTrack = (track) => {
    emit('play', track)
}

const addToPlaylist = (track) => {
    emit('add-to-playlist', track)
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
</script>

<style scoped>
/* Styles identiques à MusicCard.vue */
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

.genre-tag {
    @apply text-xs px-2 py-1 rounded-full font-medium;
}

.track-stats {
    @apply text-white/70 text-xs mb-3 space-y-1;
}

.stat {
    @apply flex items-center gap-1;
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
    @apply p-1 hover:bg-white/10 rounded-full transition-all duration-300;
}

/* Scrollbar personnalisée pour mobile */
.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>
