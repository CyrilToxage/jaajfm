<template>

    <Head title="Likes - JaaJ FM" />

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
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <ChartBarIcon class="w-5 h-5 text-purple-400" />
                            Statistiques
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <div class="text-2xl font-bold text-white">{{ likedTracks.length }}</div>
                                <div class="text-white/80 text-sm">Musiques likées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-4 border border-cyan-400/30">
                                <div class="text-2xl font-bold text-white">{{ uniqueArtists }}</div>
                                <div class="text-white/80 text-sm">Artistes différents</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-xl p-4 border border-orange-400/30">
                                <div class="text-2xl font-bold text-white">{{ uniqueGenres }}</div>
                                <div class="text-white/80 text-sm">Genres musicaux</div>
                            </div>
                        </div>
                    </section>

                    <!-- Musiques likées -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <MusicalNoteIcon class="w-5 h-5 text-purple-400" />
                            Musiques likées
                        </h2>

                        <div v-if="likedTracks.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                            <MusicCard v-for="track in likedTracks" :key="track.id" :track="track" @play="playMusic" @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />
                        </div>

                        <div v-else class="text-center py-12">
                            <HeartIcon class="w-16 h-16 text-red-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune musique likée</h3>
                            <p class="text-white/80 mb-6">
                                Commencez à liker des musiques pour les retrouver ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Découvrir de la musique
                            </Link>
                        </div>
                    </section>

                    <!-- Artistes préférés -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <UserIcon class="w-5 h-5 text-purple-400" />
                            Artistes préférés
                        </h2>

                        <div v-if="favoriteArtists.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="artist in favoriteArtists" :key="artist.id"
                                class="bg-white/10 rounded-xl p-6 backdrop-blur-lg border border-white/20 hover:bg-white/20 transition-all duration-300">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold mr-4">
                                        {{ artist.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <h3 class="text-white font-semibold text-lg">{{ artist.name }}</h3>
                                        <p class="text-white/60 text-sm">{{ artist.likes_count }} musiques likées</p>
                                    </div>
                                </div>
                                <button @click="goToArtistProfile(artist.name)"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                                    Voir le profil
                                </button>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <UserIcon class="w-16 h-16 text-purple-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucun artiste préféré</h3>
                            <p class="text-white/80 mb-6">
                                Likez des musiques d'artistes différents pour les voir apparaître ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Explorer des artistes
                            </Link>
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
            <main class="pt-20 pb-24 px-4">
                <!-- Contenu -->
                <div class="space-y-6">
                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                            <ChartBarIcon class="w-4 h-4 text-purple-400" />
                            Statistiques
                        </h2>
                        <div class="grid grid-cols-3 gap-3">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-lg p-3 border border-purple-400/30">
                                <div class="text-lg font-bold text-white">{{ likedTracks.length }}</div>
                                <div class="text-white/80 text-xs">Musiques likées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-lg p-3 border border-cyan-400/30">
                                <div class="text-lg font-bold text-white">{{ uniqueArtists }}</div>
                                <div class="text-white/80 text-xs">Artistes différents</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-lg p-3 border border-orange-400/30">
                                <div class="text-lg font-bold text-white">{{ uniqueGenres }}</div>
                                <div class="text-white/80 text-xs">Genres musicaux</div>
                            </div>
                        </div>
                    </section>

                    <!-- Musiques likées -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-4 h-4 text-purple-400" />
                            Musiques likées
                        </h2>

                        <div v-if="likedTracks.length > 0" class="space-y-4">
                            <MusicCard v-for="track in likedTracks" :key="track.id" :track="track" @play="playMusic" @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />
                        </div>

                        <div v-else class="text-center py-8">
                            <HeartIcon class="w-12 h-12 text-red-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune musique likée</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Commencez à liker des musiques pour les retrouver ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                            Découvrir de la musique
                            </Link>
                        </div>
                    </section>

                    <!-- Artistes préférés -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <UserIcon class="w-4 h-4 text-purple-400" />
                            Artistes préférés
                        </h2>

                        <div v-if="favoriteArtists.length > 0" class="space-y-4">
                            <div v-for="artist in favoriteArtists" :key="artist.id"
                                class="bg-white/10 rounded-xl p-4 backdrop-blur-lg border border-white/20">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-lg font-bold mr-3">
                                        {{ artist.name.charAt(0) }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-white font-semibold text-base">{{ artist.name }}</h3>
                                        <p class="text-white/60 text-xs">{{ artist.likes_count }} musiques likées</p>
                                    </div>
                                </div>
                                <button @click="goToArtistProfile(artist.name)"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                    Voir le profil
                                </button>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <UserIcon class="w-12 h-12 text-purple-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucun artiste préféré</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Likez des musiques d'artistes différents pour les voir apparaître ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                            Explorer des artistes
                            </Link>
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
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import MusicCard from '@/Components/MusicCard.vue'
import {
    HeartIcon,
    MusicalNoteIcon,
    ChartBarIcon,
    UserIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    likedTracks: {
        type: Array,
        default: () => []
    },
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

// Méthodes
const handleLiveRadioToggle = (isPlaying) => {
    showNotification(isPlaying ? '🔴 Connexion au Live Radio...' : '⏸️ Radio arrêtée')
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

const goToArtistProfile = (artistName) => {
    if (artistName) {
        router.get(`/profile/${encodeURIComponent(artistName)}`)
    }
}

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

    showNotification('🎵 Sélectionnez une playlist pour ajouter cette musique')
    // Ici vous pourriez ouvrir un modal de sélection de playlist
}

// Calculs pour les statistiques
const uniqueArtists = computed(() => {
    const artists = new Set(props.likedTracks.map(track => track.user?.id))
    return artists.size
})

const uniqueGenres = computed(() => {
    const genres = new Set()
    props.likedTracks.forEach(track => {
        if (track.genres && Array.isArray(track.genres)) {
            track.genres.forEach(genre => {
                if (genre && genre.name) {
                    genres.add(genre.name)
                }
            })
        }
    })
    return genres.size
})

const favoriteArtists = computed(() => {
    const artistCounts = {}
    props.likedTracks.forEach(track => {
        const artistId = track.user?.id
        if (artistId) {
            if (!artistCounts[artistId]) {
                artistCounts[artistId] = {
                    id: artistId,
                    name: track.user.name,
                    likes_count: 0
                }
            }
            artistCounts[artistId].likes_count++
        }
    })
    return Object.values(artistCounts).sort((a, b) => b.likes_count - a.likes_count).slice(0, 6)
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
