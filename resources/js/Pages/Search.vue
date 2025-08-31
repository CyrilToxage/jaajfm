<template>

    <Head title="Recherche - JaaJ FM" />

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
                <Header :initial-query="query" @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Résultats de recherche -->
                <div class="space-y-6">
                    <!-- Informations sur la recherche -->
                    <div class="glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-2">
                            <span v-if="category">Musiques de la catégorie "{{ category }}"</span>
                            <span v-else>Recherche pour "{{ query }}"</span>
                        </h2>
                        <p class="text-white/80">
                            {{ allResults.length }} résultat{{ allResults.length > 1 ? 's' : '' }} trouvé{{
                                allResults.length > 1 ? 's' : '' }}
                        </p>
                    </div>

                    <!-- Section Musiques -->
                    <section v-if="musics.length > 0" class="glass rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-6 h-6 text-green-400" />
                            Musiques ({{ musics.length }})
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <MusicCard v-for="music in musics" :key="music.id" :track="music" @play="playMusic"
                                @like="toggleLike" />
                        </div>
                    </section>

                    <!-- Section Playlists -->
                    <section v-if="playlists.length > 0" class="glass rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <PlayIcon class="w-6 h-6 text-purple-400" />
                            Playlists ({{ playlists.length }})
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div v-for="playlist in playlists" :key="playlist.id"
                                class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                @click="goToPlaylist(playlist)">
                                <div class="flex items-center gap-3">
                                    <div v-if="playlist.cover_image_url"
                                        class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                        <img :src="playlist.cover_image_url" :alt="playlist.name"
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div v-else
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <PlayIcon class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold truncate">{{ playlist.name }}</h3>
                                        <p class="text-white/60 text-sm">{{ playlist.musics_count }} musique{{
                                            playlist.musics_count > 1 ? 's' : '' }}</p>
                                        <p class="text-white/40 text-xs">par {{ playlist.user?.name }}</p>
                                    </div>
                                    <ChevronRightIcon class="w-5 h-5 text-white/60" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section Artistes -->
                    <section v-if="artists.length > 0" class="glass rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <UsersIcon class="w-6 h-6 text-blue-400" />
                            Artistes ({{ artists.length }})
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div v-for="artist in artists" :key="artist.id"
                                class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                @click="goToArtistProfile(artist)">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                        <img v-if="artist.profile_photo_url" :src="artist.profile_photo_url"
                                            :alt="artist.name" class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white font-bold text-lg">{{
                                                artist.name.charAt(0).toUpperCase() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-white font-semibold truncate">{{ artist.name }}</h3>
                                        <p class="text-white/60 text-sm">{{ artist.musics_count }} musique{{
                                            artist.musics_count > 1 ? 's' : '' }}</p>
                                    </div>
                                    <ChevronRightIcon class="w-5 h-5 text-white/60" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Aucun résultat -->
                    <section v-else-if="query && allResults.length === 0" class="glass rounded-2xl p-6 text-center">
                        <MagnifyingGlassIcon class="w-12 h-12 text-purple-400 mb-3" />
                        <h3 class="text-lg font-semibold text-white mb-2">Aucun résultat trouvé</h3>
                        <p class="text-white/60">Essayez avec d'autres mots-clés</p>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden min-h-screen">
            <!-- Header mobile -->
            <MobileHeader :initial-query="query" @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu mobile -->
            <main class="p-4 pt-20 relative">
                <!-- Résultats de recherche -->
                <div class="space-y-4">
                    <!-- Informations sur la recherche -->
                    <div class="glass rounded-2xl p-4">
                        <h2 class="text-xl font-bold text-white mb-2">
                            <span v-if="category">Musiques de la catégorie "{{ category }}"</span>
                            <span v-else>Recherche pour "{{ query }}"</span>
                        </h2>
                        <p class="text-white/80 text-sm">
                            {{ allResults.length }} résultat{{ allResults.length > 1 ? 's' : '' }} trouvé{{
                                allResults.length > 1 ? 's' : '' }}
                        </p>
                    </div>

                    <!-- Résultats dans l'ordre de priorité -->
                    <div v-if="allResults.length > 0" class="glass rounded-2xl p-4">
                        <div class="space-y-3">
                            <!-- Musiques -->
                            <template v-for="item in allResults" :key="`${item.type}-${item.id}`">
                                <!-- Carte de musique -->
                                <div v-if="item.type === 'music'"
                                    class="bg-white/10 rounded-xl p-3 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                    @click="playMusic(item)">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                            <img v-if="item.cover_image_url" :src="item.cover_image_url"
                                                :alt="item.title" class="w-full h-full object-cover" />
                                            <div v-else
                                                class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                                <MusicalNoteIcon class="w-5 h-5 text-white" />
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-white font-semibold truncate text-sm">{{ item.title }}</h3>
                                            <p class="text-white/60 text-xs truncate">{{ item.user?.name || 'Artiste inconnu' }}</p>
                                        </div>
                                        <PlayIcon class="w-4 h-4 text-white/60" />
                                    </div>
                                </div>

                                <!-- Carte de playlist -->
                                <div v-else-if="item.type === 'playlist'"
                                    class="bg-white/10 rounded-xl p-3 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                    @click="goToPlaylist(item)">
                                    <div class="flex items-center gap-3">
                                        <div v-if="item.cover_image_url"
                                            class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                            <img :src="item.cover_image_url" :alt="item.name"
                                                class="w-full h-full object-cover" />
                                        </div>
                                        <div v-else
                                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <PlayIcon class="w-5 h-5 text-white" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-white font-semibold truncate text-sm">{{ item.name }}</h3>
                                            <p class="text-white/60 text-xs">{{ item.musics_count }} musique{{
                                                item.musics_count > 1 ? 's' : '' }}</p>
                                            <p class="text-white/40 text-xs">par {{ item.user?.name }}</p>
                                        </div>
                                        <ChevronRightIcon class="w-4 h-4 text-white/60" />
                                    </div>
                                </div>

                                <!-- Carte d'artiste -->
                                <div v-else-if="item.type === 'artist'"
                                    class="bg-white/10 rounded-xl p-3 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer"
                                    @click="goToArtistProfile(item)">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                            <img v-if="item.profile_photo_url" :src="item.profile_photo_url"
                                                :alt="item.name" class="w-full h-full object-cover" />
                                            <div v-else
                                                class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{
                                                    item.name.charAt(0).toUpperCase() }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-white font-semibold truncate text-sm">{{ item.name }}</h3>
                                            <p class="text-white/60 text-xs">{{ item.musics_count }} musique{{
                                                item.musics_count > 1 ? 's' : '' }}</p>
                                        </div>
                                        <ChevronRightIcon class="w-4 h-4 text-white/60" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Aucun résultat -->
                    <section v-else-if="query && allResults.length === 0" class="glass rounded-2xl p-4 text-center">
                        <MagnifyingGlassIcon class="w-12 h-12 text-purple-400 mb-3" />
                        <h3 class="text-lg font-semibold text-white mb-2">Aucun résultat trouvé</h3>
                        <p class="text-white/60 text-sm">Essayez avec d'autres mots-clés</p>
                    </section>
                </div>
            </main>
        </div>

        <!-- Notification -->
        <div v-if="notification.show"
            class="fixed bottom-4 right-4 bg-white/90 backdrop-blur-lg rounded-lg p-4 shadow-lg border border-white/20 z-50">
            <p class="text-gray-800">{{ notification.message }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import {
    MagnifyingGlassIcon,
    MusicalNoteIcon,
    PlayIcon,
    ChevronRightIcon
} from '@heroicons/vue/24/outline'

// Components
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobileHeader from '@/Components/MobileHeader.vue'
import MusicCard from '@/Components/MusicCard.vue'

// Props
const props = defineProps({
    musics: {
        type: Array,
        default: () => []
    },
    playlists: {
        type: Array,
        default: () => []
    },
    artists: {
        type: Array,
        default: () => []
    },
    query: {
        type: String,
        default: ''
    },
    category: {
        type: String,
        default: ''
    },
    category_id: {
        type: [String, Number],
        default: null
    }
})

// Réactifs
const notification = ref({
    show: false,
    message: ''
})

// Computed properties pour organiser les résultats dans l'ordre demandé
const allResults = computed(() => {
    const results = []

    // 1. Toutes les musiques (qui commencent par + qui contiennent)
    props.musics.forEach(music => {
        results.push({ ...music, type: 'music', priority: 1 })
    })

    // 2. Playlists publiques
    props.playlists.forEach(playlist => {
        results.push({ ...playlist, type: 'playlist', priority: 2 })
    })

    // 3. Tous les artistes (qui commencent par + qui contiennent)
    props.artists.forEach(artist => {
        results.push({ ...artist, type: 'artist', priority: 3 })
    })

    // Trier par priorité
    return results.sort((a, b) => a.priority - b.priority)
})

// Méthodes
const clearSearch = () => {
    localQuery.value = ''
    router.get('/search', { q: '' })
}

const playMusic = (track) => {
    showNotification(`🎵 Lecture: ${track.title} - ${track.user?.name || 'Artiste inconnu'}`)
    // Naviguer vers la page de la musique
    router.visit(`/music/${track.slug || track.id}`)
}

const goToArtistProfile = (artist) => {
    const encodedName = encodeURIComponent(artist.name)
    router.visit(`/profile/${encodedName}`)
}

const goToPlaylist = (playlist) => {
    router.visit(`/playlists/${playlist.slug || playlist.id}`)
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

// Cycle de vie
onMounted(() => {
    if (props.query) {
        showNotification(`Recherche pour "${props.query}" terminée`)
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
