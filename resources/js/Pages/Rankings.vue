<template>

    <Head title="Classements - JaaJ FM" />

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
                <div class="space-y-8">
                    <!-- Titre de la page -->
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-white mb-4 flex items-center justify-center gap-3">
                            <TrophyIcon class="w-10 h-10 text-yellow-400" />
                            Classements
                        </h1>
                        <p class="text-white/80 text-lg">Découvrez les meilleures musiques et artistes de JaaJ FM</p>
                        <div class="mt-4 text-white/60 text-sm">
                            <p>🎵 <strong>Musiques :</strong> Classement basé sur le ratio likes/vues</p>
                            <p>👨‍🎤 <strong>Artistes :</strong> Classement basé sur le ratio total likes/vues de toutes leurs musiques</p>
                        </div>
                    </div>

                    <!-- Onglets -->
                    <div class="flex justify-center mb-8">
                        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-1">
                            <button @click="activeTab = 'tracks'" :class="[
                                'px-6 py-3 rounded-lg font-semibold transition-all duration-300',
                                activeTab === 'tracks'
                                    ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg'
                                    : 'text-white/80 hover:text-white'
                            ]">
                                <MusicalNoteIcon class="w-5 h-5 inline mr-2" />
                                Meilleures Musiques
                            </button>
                            <button @click="activeTab = 'artists'" :class="[
                                'px-6 py-3 rounded-lg font-semibold transition-all duration-300',
                                activeTab === 'artists'
                                    ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg'
                                    : 'text-white/80 hover:text-white'
                            ]">
                                <UserGroupIcon class="w-5 h-5 inline mr-2" />
                                Meilleurs Artistes
                            </button>
                        </div>
                    </div>

                    <!-- Classement des musiques -->
                    <div v-if="activeTab === 'tracks'" class="space-y-6">
                        <div class="glass rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <MusicalNoteIcon class="w-6 h-6 text-purple-400" />
                                Top 10 des Meilleures Musiques
                            </h2>

                            <div class="space-y-4">
                                <div v-for="(track, index) in topTracks" :key="track.id"
                                    class="flex items-center p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors cursor-pointer"
                                    @click="playMusic(track)">
                                    <!-- Position -->
                                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center mr-4">
                                        <div :class="[
                                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg',
                                            index === 0 ? 'bg-yellow-500 text-white' :
                                                index === 1 ? 'bg-gray-400 text-white' :
                                                    index === 2 ? 'bg-orange-600 text-white' :
                                                        'bg-white/20 text-white'
                                        ]">
                                            {{ index + 1 }}
                                        </div>
                                    </div>

                                    <!-- Cover -->
                                    <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden mr-4">
                                        <div v-if="track.cover_image_url" class="w-full h-full">
                                            <img :src="track.cover_image_url" :alt="track.title"
                                                class="w-full h-full object-cover" />
                                        </div>
                                        <div v-else
                                            class="w-full h-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 flex items-center justify-center">
                                            <MusicalNoteIcon class="w-8 h-8 text-white opacity-90" />
                                        </div>
                                    </div>

                                    <!-- Informations -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold text-lg truncate">{{ track.title }}</h3>
                                        <p class="text-white/70 truncate">{{ track.user.name }}</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="text-white/60 text-sm">
                                                <HeartIcon class="w-4 h-4 inline mr-1" />
                                                {{ track.likes_count }}
                                            </span>
                                            <span class="text-white/60 text-sm">
                                                <EyeIcon class="w-4 h-4 inline mr-1" />
                                                {{ track.views }}
                                            </span>
                                            <span class="text-purple-400 font-semibold text-sm">
                                                Ratio: {{ (track.score * 100).toFixed(1) }}%
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Bouton play -->
                                    <button @click.stop="playMusic(track)"
                                        class="flex-shrink-0 w-12 h-12 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center transition-colors">
                                        <PlayIcon class="w-5 h-5 text-white" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Classement des artistes -->
                    <div v-if="activeTab === 'artists'" class="space-y-6">
                        <div class="glass rounded-2xl p-8">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <UserGroupIcon class="w-6 h-6 text-purple-400" />
                                Top 10 des Meilleurs Artistes
                            </h2>

                            <div class="space-y-4">
                                <div v-for="(artist, index) in topArtists" :key="artist.id"
                                    class="flex items-center p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors cursor-pointer"
                                    @click="goToArtistProfile(artist)">
                                    <!-- Position -->
                                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center mr-4">
                                        <div :class="[
                                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg',
                                            index === 0 ? 'bg-yellow-500 text-white' :
                                                index === 1 ? 'bg-gray-400 text-white' :
                                                    index === 2 ? 'bg-orange-600 text-white' :
                                                        'bg-white/20 text-white'
                                        ]">
                                            {{ index + 1 }}
                                        </div>
                                    </div>

                                    <!-- Photo de profil -->
                                    <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden mr-4">
                                        <img :src="artist.profile_photo_url || '/default-avatar.jpg'" :alt="artist.name"
                                            class="w-full h-full object-cover" />
                                    </div>

                                    <!-- Informations -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold text-lg truncate">{{ artist.name }}</h3>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="text-white/60 text-sm">
                                                <MusicalNoteIcon class="w-4 h-4 inline mr-1" />
                                                {{ artist.musics_count }} musiques
                                            </span>
                                            <span class="text-white/60 text-sm">
                                                <HeartIcon class="w-4 h-4 inline mr-1" />
                                                {{ artist.total_likes }} likes
                                            </span>
                                            <span class="text-white/60 text-sm">
                                                <EyeIcon class="w-4 h-4 inline mr-1" />
                                                {{ artist.total_views }} vues
                                            </span>
                                            <span class="text-purple-400 font-semibold text-sm">
                                                Ratio: {{ (artist.score * 100).toFixed(1) }}%
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Bouton profil -->
                                    <button
                                        class="flex-shrink-0 w-12 h-12 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center transition-colors">
                                        <ArrowTopRightOnSquareIcon class="w-5 h-5 text-white" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <!-- Contenu -->
                <div class="space-y-6">
                    <!-- Onglets -->
                    <div class="flex space-x-2 bg-white/10 rounded-xl p-1 backdrop-blur-lg">
                        <button @click="activeTab = 'tracks'" :class="[
                            'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 text-sm',
                            activeTab === 'tracks'
                                ? 'bg-white text-gray-800 shadow-lg'
                                : 'text-white hover:bg-white/20'
                        ]">
                            <TrophyIcon class="w-4 h-4 inline mr-2" />
                            Top Musiques
                        </button>
                        <button @click="activeTab = 'artists'" :class="[
                            'flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 text-sm',
                            activeTab === 'artists'
                                ? 'bg-white text-gray-800 shadow-lg'
                                : 'text-white hover:bg-white/20'
                        ]">
                            <UserGroupIcon class="w-4 h-4 inline mr-2" />
                            Top Artistes
                        </button>
                    </div>

                    <!-- Top Musiques -->
                    <section v-if="activeTab === 'tracks'" class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <TrophyIcon class="w-4 h-4 text-yellow-400" />
                            Top Musiques
                        </h2>

                        <div v-if="topTracks.length > 0" class="space-y-3">
                            <div v-for="(track, index) in topTracks" :key="track.id"
                                class="bg-white/10 rounded-xl p-3 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                @click="playMusic(track)">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                        <img v-if="track.cover_image_url" :src="track.cover_image_url"
                                            :alt="track.title" class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                            <MusicalNoteIcon class="w-6 h-6 text-white" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold truncate">{{ track.title }}</h3>
                                                                                 <p class="text-white/60 text-sm truncate">{{ track.user?.name || 'Artiste inconnu' }}</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="text-white/40 text-xs flex items-center gap-1">
                                                <EyeIcon class="w-3 h-3" />
                                                {{ formatNumber(track.views || 0) }}
                                            </span>
                                            <span class="text-white/40 text-xs flex items-center gap-1">
                                                <HeartIcon class="w-3 h-3" />
                                                {{ formatNumber(track.likes_count || 0) }}
                                            </span>
                                        </div>
                                    </div>
                                    <PlayIcon class="w-5 h-5 text-white/60" />
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <TrophyIcon class="w-12 h-12 text-yellow-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune donnée</h3>
                            <p class="text-white/80 text-sm">Les classements seront bientôt disponibles</p>
                        </div>
                    </section>

                    <!-- Top Artistes -->
                    <section v-if="activeTab === 'artists'" class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <UserGroupIcon class="w-4 h-4 text-blue-400" />
                            Top Artistes
                        </h2>

                        <div v-if="topArtists.length > 0" class="space-y-3">
                            <div v-for="(artist, index) in topArtists" :key="artist.id"
                                class="bg-white/10 rounded-xl p-3 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                @click="goToArtistProfile(artist)">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                        <img v-if="artist.profile_photo_url" :src="artist.profile_photo_url"
                                            :alt="artist.name" class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                            <UserGroupIcon class="w-6 h-6 text-white" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold truncate">{{ artist.name }}</h3>
                                        <p class="text-white/60 text-sm">{{ artist.tracks_count || 0 }} musiques</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="text-white/40 text-xs flex items-center gap-1">
                                                <HeartIcon class="w-3 h-3" />
                                                {{ formatNumber(artist.followers_count || 0) }} abonnés
                                            </span>
                                        </div>
                                    </div>
                                    <ArrowTopRightOnSquareIcon class="w-5 h-5 text-white/60" />
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <UserGroupIcon class="w-12 h-12 text-blue-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune donnée</h3>
                            <p class="text-white/80 text-sm">Les classements seront bientôt disponibles</p>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import {
    TrophyIcon,
    MusicalNoteIcon,
    UserGroupIcon,
    HeartIcon,
    EyeIcon,
    PlayIcon,
    ArrowTopRightOnSquareIcon
} from '@heroicons/vue/24/outline'

// État réactif
const activeTab = ref('tracks')
const topTracks = ref([])
const topArtists = ref([])

// Méthodes
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

const loadRankings = async () => {
    try {
        const response = await fetch('/api/rankings')
        const data = await response.json()

        if (data.success) {
            topTracks.value = data.topTracks
            topArtists.value = data.topArtists
        }
    } catch (error) {
        console.error('Erreur lors du chargement des classements:', error)
    }
}

const playMusic = (track) => {
    // Navigation vers la page de la musique
    if (track.slug) {
        router.visit(`/music/${track.slug}`)
    } else {
        router.visit(`/music/${track.id}`)
    }
}

const goToArtistProfile = (artist) => {
    // Navigation vers le profil de l'artiste
    router.visit(`/profile/${encodeURIComponent(artist.name)}`)
}

// Charger les données au montage
onMounted(() => {
    loadRankings()
})
</script>

<style scoped>
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
        transform: translateY(20px) rotate(45deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}

.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>
