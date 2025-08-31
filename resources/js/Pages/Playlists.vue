<template>

    <Head title="Playlists - JaaJ FM" />

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
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <div class="text-2xl font-bold text-white">{{ playlists.length }}</div>
                                <div class="text-white/80 text-sm">Playlists créées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl p-4 border border-green-400/30">
                                <div class="text-2xl font-bold text-white">{{playlists.filter(p => p.is_public).length
                                    }}</div>
                                <div class="text-white/80 text-sm">Playlists publiques</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-xl p-4 border border-orange-400/30">
                                <div class="text-2xl font-bold text-white">{{playlists.filter(p => !p.is_public).length
                                    }}</div>
                                <div class="text-white/80 text-sm">Playlists privées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-4 border border-cyan-400/30">
                                <div class="text-2xl font-bold text-white">{{playlists.reduce((total, p) => total +
                                    (p.musics_count || p.musics?.length || 0), 0) }}</div>
                                <div class="text-white/80 text-sm">Musiques totales</div>
                            </div>
                        </div>
                    </section>

                    <!-- Mes playlists -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <MusicalNoteIcon class="w-5 h-5 text-purple-400" />
                            Mes Playlists
                        </h2>



                        <div v-if="playlists.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <div v-for="playlist in playlists" :key="playlist.id"
                                class="bg-white/10 rounded-xl p-4 backdrop-blur-lg border border-white/20 hover:bg-white/25 hover:transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 flex flex-col cursor-pointer"
                                @click="goToPlaylist(playlist)">
                                <div class="w-full aspect-square rounded-xl mb-3 relative overflow-hidden">
                                    <div v-if="playlist.cover_image_url"
                                        class="w-full h-full bg-cover bg-center rounded-lg"
                                        :style="{ backgroundImage: `url(${playlist.cover_image_url})` }"></div>
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                        <span class="text-4xl text-white font-bold">{{ playlist.name.substring(0,
                                            3).toUpperCase() }}</span>
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                        <button
                                            class="bg-white/20 backdrop-blur-lg border border-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:transform hover:scale-110 hover:bg-white/30 hover:border-white/50">
                                            <PlayIcon class="w-8 h-8 text-white" />
                                        </button>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-white font-semibold text-lg truncate flex-1">{{ playlist.name }}
                                        </h3>
                                        <!-- Toggle public/privé -->
                                        <button @click.stop="togglePlaylistVisibility(playlist)" :class="[
                                            'flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium transition-all duration-300 hover:scale-105',
                                            playlist.is_public
                                                ? 'bg-green-500/20 text-green-300 border border-green-400/30 hover:bg-green-500/30'
                                                : 'bg-orange-500/20 text-orange-300 border border-orange-400/30 hover:bg-orange-500/30'
                                        ]" :title="playlist.is_public ? 'Rendre privée' : 'Rendre publique'">
                                            <div :class="[
                                                'w-2 h-2 rounded-full',
                                                playlist.is_public ? 'bg-green-400' : 'bg-orange-400'
                                            ]"></div>
                                            <span>{{ playlist.is_public ? 'Public' : 'Privé' }}</span>
                                        </button>
                                    </div>
                                    <p class="text-white/60 text-sm mb-3 flex-1 overflow-hidden"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ playlist.description || 'Aucune description' }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <span class="text-white/80 text-sm">{{ playlist.musics_count ||
                                            playlist.musics?.length || 0 }}
                                            musiques</span>
                                        <button @click="playPlaylist(playlist)"
                                            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-3 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                            Écouter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <BookOpenIcon class="w-16 h-16 text-purple-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune playlist créée</h3>
                            <p class="text-white/80 mb-6">
                                Créez votre première playlist pour organiser vos musiques préférées !
                            </p>
                            <button @click="showCreateModal = true"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                                Créer ma première playlist
                            </button>
                        </div>
                    </section>

                    <!-- Playlists recommandées -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <LightBulbIcon class="w-5 h-5 text-yellow-400" />
                            Playlists recommandées
                        </h2>

                        <div class="text-center py-12">
                            <MusicalNoteIcon class="w-16 h-16 text-purple-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune recommandation</h3>
                            <p class="text-white/80 mb-6">
                                Likez plus de musiques pour recevoir des recommandations personnalisées !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Découvrir de la musique
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

        <!-- Modal de création de playlist -->
        <div v-if="showCreateModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Créer une nouvelle playlist</h3>
                    <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">
                        <XMarkIcon class="w-6 h-6" />
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la playlist</label>
                        <input v-model="newPlaylist.name" type="text" placeholder="Ma playlist"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (optionnel)</label>
                        <textarea v-model="newPlaylist.description" placeholder="Description de votre playlist..."
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <input v-model="newPlaylist.is_public" type="checkbox" id="public-playlist"
                                class="mr-3 w-4 h-4 text-purple-600 bg-white border-gray-300 rounded focus:ring-purple-500" />
                            <label for="public-playlist" class="text-sm font-medium text-gray-700">Playlist
                                publique</label>
                        </div>
                        <!-- Indicateur visuel -->
                        <div class="flex items-center gap-2">
                            <div v-if="newPlaylist.is_public"
                                class="flex items-center gap-1 px-2 py-1 bg-green-100 border border-green-300 rounded-full">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-green-700 text-xs font-medium">Public</span>
                            </div>
                            <div v-else
                                class="flex items-center gap-1 px-2 py-1 bg-orange-100 border border-orange-300 rounded-full">
                                <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                <span class="text-orange-700 text-xs font-medium">Privé</span>
                            </div>
                        </div>
                    </div>
                                          <p class="text-xs text-gray-500 -mt-2">
                          {{ newPlaylist.is_public ? 'Votre playlist sera visible par tous les utilisateurs' : 'Votre playlist ne sera visible que par vous' }}
                      </p>

                    <div class="flex space-x-3 pt-4">
                        <button @click="showCreateModal = false"
                            class="flex-1 px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Annuler
                        </button>
                        <button @click="createPlaylist" :disabled="!newPlaylist.name.trim()"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Créer
                        </button>
                    </div>
                </div>
            </div>
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
                        <div class="grid grid-cols-2 gap-3">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-3 border border-purple-400/30">
                                <div class="text-xl font-bold text-white">{{ playlists.length }}</div>
                                <div class="text-white/80 text-xs">Playlists créées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl p-3 border border-green-400/30">
                                <div class="text-xl font-bold text-white">{{playlists.filter(p => p.is_public).length
                                    }}</div>
                                <div class="text-white/80 text-xs">Playlists publiques</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-xl p-3 border border-orange-400/30">
                                <div class="text-xl font-bold text-white">{{playlists.filter(p => !p.is_public).length
                                    }}</div>
                                <div class="text-white/80 text-xs">Playlists privées</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-3 border border-cyan-400/30">
                                <div class="text-xl font-bold text-white">{{playlists.reduce((total, p) => total +
                                    (p.musics_count || p.musics?.length || 0), 0) }}</div>
                                <div class="text-white/80 text-xs">Musiques totales</div>
                            </div>
                        </div>
                    </section>

                    <!-- Mes playlists -->
                    <section class="glass rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <MusicalNoteIcon class="w-4 h-4 text-purple-400" />
                                Mes Playlists
                            </h2>
                            <button @click="showCreateModal = true"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-3 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm flex items-center gap-2">
                                <PlusIcon class="w-4 h-4" />
                                Créer
                            </button>
                        </div>

                        <div v-if="playlists.length > 0" class="grid grid-cols-1 gap-4">
                            <div v-for="playlist in playlists" :key="playlist.id"
                                class="bg-white/10 rounded-xl p-4 backdrop-blur-lg border border-white/20 hover:bg-white/25 transition-all duration-300 flex items-center cursor-pointer"
                                @click="goToPlaylist(playlist)">
                                <div class="w-16 h-16 rounded-xl mr-4 relative overflow-hidden flex-shrink-0">
                                    <div v-if="playlist.cover_image_url"
                                        class="w-full h-full bg-cover bg-center rounded-lg"
                                        :style="{ backgroundImage: `url(${playlist.cover_image_url})` }"></div>
                                    <div v-else
                                        class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                        <span class="text-lg text-white font-bold">{{ playlist.name.substring(0,
                                            3).toUpperCase() }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-white font-semibold truncate">{{ playlist.name }}</h3>
                                        <!-- Toggle public/privé -->
                                        <button @click.stop="togglePlaylistVisibility(playlist)" :class="[
                                            'flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium transition-all duration-300',
                                            playlist.is_public
                                                ? 'bg-green-500/20 text-green-300 border border-green-400/30'
                                                : 'bg-orange-500/20 text-orange-300 border border-orange-400/30'
                                        ]" :title="playlist.is_public ? 'Rendre privée' : 'Rendre publique'">
                                            <div :class="[
                                                'w-2 h-2 rounded-full',
                                                playlist.is_public ? 'bg-green-400' : 'bg-orange-400'
                                            ]"></div>
                                            <span>{{ playlist.is_public ? 'Public' : 'Privé' }}</span>
                                        </button>
                                    </div>
                                    <p class="text-white/60 text-sm">{{ playlist.musics_count || playlist.musics?.length
                                        || 0 }} musiques</p>
                                    <p v-if="playlist.description" class="text-white/40 text-xs mt-1 truncate">{{
                                        playlist.description }}</p>
                                </div>
                                <PlayIcon class="w-5 h-5 text-white/60 ml-2" />
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <MusicalNoteIcon class="w-12 h-12 text-purple-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune playlist</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Créez votre première playlist pour commencer !
                            </p>
                            <button @click="showCreateModal = true"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                Créer une playlist
                            </button>
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
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import {
    PlusIcon,
    MusicalNoteIcon,
    ChartBarIcon,
    ClockIcon,
    BookOpenIcon,
    LightBulbIcon,
    XMarkIcon,
    PlayIcon
} from '@heroicons/vue/24/outline'

defineProps({
    playlists: Array,
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

const showCreateModal = ref(false)

const newPlaylist = ref({
    name: '',
    description: '',
    is_public: true
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

const createPlaylist = async () => {
    if (!newPlaylist.value.name.trim()) return

    try {
        const response = await fetch('/playlists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(newPlaylist.value)
        })

        const data = await response.json()

        if (data.success) {
            showNotification(`🎵 Playlist "${newPlaylist.value.name}" créée avec succès !`)
            showCreateModal.value = false

            // Réinitialiser le formulaire
            newPlaylist.value = {
                name: '',
                description: '',
                is_public: true
            }

            // Recharger la page pour afficher la nouvelle playlist
            window.location.reload()
        } else {
            showNotification('❌ Erreur lors de la création de la playlist')
        }
    } catch (error) {
        console.error('Erreur lors de la création:', error)
        showNotification('❌ Erreur lors de la création de la playlist')
    }
}

const goToPlaylist = (playlist) => {
    router.get(`/playlists/${playlist.slug || playlist.id}`)
}

const togglePlaylistVisibility = async (playlist) => {
    try {
        const response = await fetch(`/playlists/${playlist.id}/toggle-visibility`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            const data = await response.json()
            // Mettre à jour le statut localement
            playlist.is_public = data.is_public
            showNotification(`🎵 Playlist ${data.is_public ? 'rendue publique' : 'rendue privée'} !`)
        } else {
            showNotification('❌ Erreur lors du changement de statut')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('❌ Erreur lors du changement de statut')
    }
}

const playPlaylist = (playlist) => {
    if (playlist.musics && playlist.musics.length > 0) {
        // Rediriger vers la page de la playlist
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
