<template>

    <Head title="Bibliothèque - JaaJ FM" />

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
                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <ChartBarIcon class="w-5 h-5 text-purple-400" />
                            Statistiques
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-4 border border-cyan-400/30">
                                <div class="text-2xl font-bold text-white">{{ publicPlaylists?.length || 0 }}</div>
                                <div class="text-white/80 text-sm">Playlists publiques</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-xl p-4 border border-orange-400/30">
                                <div class="text-2xl font-bold text-white">{{ userTracks?.length || 0 }}</div>
                                <div class="text-white/80 text-sm">Musiques créées</div>
                            </div>
                        </div>
                    </section>



                    <!-- Mes musiques créées -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <MusicalNoteIcon class="w-5 h-5 text-green-400" />
                            Mes Musiques Créées
                        </h2>

                        <div v-if="userTracks && userTracks.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                            <UserMusicCard v-for="track in userTracks" :key="track.id" :track="track"
                                @delete="deleteMusic" />
                        </div>

                        <div v-else class="text-center py-12">
                            <MusicalNoteIcon class="w-16 h-16 text-green-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune musique créée</h3>
                            <p class="text-white/80 mb-6">
                                Créez votre première musique pour commencer votre carrière d'artiste !
                            </p>
                            <Link href="/create"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Créer ma première musique
                            </Link>
                        </div>
                    </section>

                    <!-- Playlists publiques -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <BookOpenIcon class="w-5 h-5 text-orange-400" />
                            Mes Playlists Publiques
                        </h2>

                        <div v-if="publicPlaylists && publicPlaylists.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="playlist in publicPlaylists" :key="playlist.id" @click="playPlaylist(playlist)"
                                class="bg-white/10 rounded-xl p-6 backdrop-blur-lg border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer">
                                <div
                                    class="w-full h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-4">
                                    <BookOpenIcon class="w-12 h-12 text-white" />
                                </div>
                                <h3 class="text-white font-semibold text-lg mb-2">{{ playlist.name }}</h3>
                                <p class="text-white/60 text-sm mb-4">{{ playlist.description || 'Aucune description' }}
                                </p>
                                <div class="flex justify-center">
                                    <span class="text-white/80 text-sm">{{ playlist.musics_count || 0 }} musiques</span>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <BookOpenIcon class="w-16 h-16 text-orange-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune playlist publique</h3>
                            <p class="text-white/80 mb-6">
                                Créez votre première playlist publique pour partager vos musiques préférées !
                            </p>
                            <Link href="/playlists"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Créer une playlist
                            </Link>
                        </div>
                    </section>

                    <!-- Artistes suivis -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <UserGroupIcon class="w-5 h-5 text-cyan-400" />
                            Artistes suivis
                        </h2>

                        <div class="text-center py-12">
                            <UserGroupIcon class="w-16 h-16 text-cyan-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucun artiste suivi</h3>
                            <p class="text-white/80 mb-6">
                                Suivez vos artistes préférés pour recevoir leurs nouvelles sorties !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Découvrir des artistes
                            </Link>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Notification -->
        <div v-if="notification.show"
            class="fixed top-5 right-5 bg-gradient-to-r from-purple-600 to-cyan-500 text-white px-5 py-4 rounded-xl z-50 font-bold shadow-lg transform transition-transform duration-300"
            :class="notification.show ? 'translate-x-0' : 'translate-x-full'">
            {{ notification.message }}
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

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
                        <div class="grid grid-cols-2 gap-3">

                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-3 border border-cyan-400/30">
                                <div class="text-xl font-bold text-white">{{ publicPlaylists?.length || 0 }}</div>
                                <div class="text-white/80 text-xs">Playlists publiques</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-xl p-3 border border-orange-400/30">
                                <div class="text-xl font-bold text-white">{{ userTracks?.length || 0 }}</div>
                                <div class="text-white/80 text-xs">Musiques créées</div>
                            </div>
                        </div>
                    </section>



                    <!-- Mes musiques créées -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-4 h-4 text-green-400" />
                            Mes Musiques Créées
                        </h2>

                        <div v-if="userTracks && userTracks.length > 0" class="grid grid-cols-1 gap-4">
                            <UserMusicCard v-for="track in userTracks" :key="track.id" :track="track"
                                @delete="deleteMusic" />
                        </div>

                        <div v-else class="text-center py-8">
                            <MusicalNoteIcon class="w-12 h-12 text-green-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune musique créée</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Créez votre première musique pour commencer !
                            </p>
                            <Link href="/create"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-300 text-sm">
                            Créer une musique
                            </Link>
                        </div>
                    </section>

                    <!-- Playlists publiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <PlayIcon class="w-4 h-4 text-blue-400" />
                            Playlists Publiques
                        </h2>

                        <div v-if="publicPlaylists && publicPlaylists.length > 0" class="grid grid-cols-1 gap-4">
                            <div v-for="playlist in publicPlaylists" :key="playlist.id"
                                class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-colors cursor-pointer"
                                @click="playPlaylist(playlist)">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                            <PlayIcon class="w-6 h-6 text-white" />
                                        </div>
                                        <div>
                                            <h3 class="text-white font-semibold">{{ playlist.name }}</h3>
                                            <p class="text-white/60 text-sm">{{ playlist.musics_count }} musiques</p>
                                        </div>
                                    </div>
                                    <PlayIcon class="w-5 h-5 text-white/60" />
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <PlayIcon class="w-12 h-12 text-blue-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune playlist publique</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Créez des playlists pour les partager avec la communauté !
                            </p>
                            <Link href="/playlists"
                                class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 text-sm">
                            Créer une playlist
                            </Link>
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
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MusicCard from '@/Components/MusicCard.vue'
import UserMusicCard from '@/Components/UserMusicCard.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import {
    BookOpenIcon,
    HeartIcon,
    MusicalNoteIcon,
    UserGroupIcon,
    ChartBarIcon,
    ClockIcon,
    UserIcon,
    PlayIcon,
    EyeIcon
} from '@heroicons/vue/24/outline'

defineProps({
    userTracks: {
        type: Array,
        default: () => []
    },
    publicPlaylists: {
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


const showNotification = (message) => {
    notification.value = {
        show: true,
        message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

const formatNumber = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
}

const playMusic = (track) => {
    showNotification(`🎵 Lecture: ${track.title} - ${track.user?.name || 'Artiste inconnu'}`)
    // Rediriger vers la page de la musique
    router.get(`/music/${track.slug || track.id}`)
}

const deleteMusic = async (track) => {
    if (!confirm(`Êtes-vous sûr de vouloir supprimer "${track.title}" ? Cette action est irréversible.`)) {
        return
    }

    try {
        const response = await fetch(`/music/${track.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            showNotification(`🗑️ "${track.title}" supprimée avec succès`)
            // Recharger la page pour mettre à jour la liste
            window.location.reload()
        } else {
            showNotification('❌ Erreur lors de la suppression')
        }
    } catch (error) {
        console.error('Erreur lors de la suppression:', error)
        showNotification('❌ Erreur lors de la suppression')
    }
}

const playPlaylist = (playlist) => {
    if (playlist.musics_count > 0) {
        showNotification(`🎵 Lecture de la playlist "${playlist.name}"`)
        router.get(`/playlists/${playlist.slug || playlist.id}`)
    } else {
        showNotification('❌ Cette playlist ne contient aucune musique')
    }
}
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
