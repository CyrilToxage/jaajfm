<template>

    <Head title="Abonnements - JaaJ FM" />

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
                                <div class="text-2xl font-bold text-white">{{ subscriptions.length }}</div>
                                <div class="text-white/80 text-sm">Artistes suivis</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-xl p-4 border border-cyan-400/30">
                                <div class="text-2xl font-bold text-white">{{ safeNewReleases.length }}</div>
                                <div class="text-white/80 text-sm">Nouvelles sorties</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-xl p-4 border border-orange-400/30">
                                <div class="text-2xl font-bold text-white">0</div>
                                <div class="text-white/80 text-sm">Notifications</div>
                            </div>
                        </div>
                    </section>

                    <!-- Artistes suivis -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <MusicalNoteIcon class="w-5 h-5 text-purple-400" />
                            Artistes suivis
                        </h2>

                        <div v-if="subscriptions.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="subscription in subscriptions" :key="subscription.id"
                                class="bg-white/10 rounded-xl p-6 backdrop-blur-lg border border-white/20 hover:bg-white/20 transition-all duration-300">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold mr-4">
                                        {{ subscription?.name?.charAt(0) || '?' }}
                                    </div>
                                    <div>
                                        <h3 class="text-white font-semibold text-lg">{{ getDisplayName(subscription) }}
                                        </h3>
                                        <p class="text-white/60 text-sm">{{ getDisplayEmail(subscription) }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <button @click="viewProfile(subscription)"
                                        class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                                        Voir le profil
                                    </button>
                                    <button @click="unsubscribe(subscription)"
                                        class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-red-700 hover:to-pink-700 transition-all duration-300">
                                        Se désabonner
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
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

                    <!-- Nouvelles sorties -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <SparklesIcon class="w-5 h-5 text-blue-400" />
                            Nouvelles sorties
                        </h2>

                        <div v-if="safeNewReleases.length > 0"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                            <MusicCard v-for="track in safeNewReleases" :key="track.id" :track="track" @play="playMusic"
                                @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />
                        </div>

                        <div v-else class="text-center py-12">
                            <MusicalNoteIcon class="w-16 h-16 text-purple-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">Aucune nouvelle sortie</h3>
                            <p class="text-white/80 mb-6">
                                Suivez des artistes pour voir leurs nouvelles sorties ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                            Explorer la musique
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
                                <div class="text-lg font-bold text-white">{{ subscriptions.length }}</div>
                                <div class="text-white/80 text-xs">Artistes suivis</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-lg p-3 border border-cyan-400/30">
                                <div class="text-lg font-bold text-white">{{ safeNewReleases.length }}</div>
                                <div class="text-white/80 text-xs">Nouvelles sorties</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-lg p-3 border border-orange-400/30">
                                <div class="text-lg font-bold text-white">0</div>
                                <div class="text-white/80 text-xs">Notifications</div>
                            </div>
                        </div>
                    </section>

                    <!-- Artistes suivis -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-4 h-4 text-purple-400" />
                            Artistes suivis
                        </h2>

                        <div v-if="subscriptions.length > 0" class="space-y-4">
                            <div v-for="subscription in subscriptions" :key="subscription.id"
                                class="bg-white/10 rounded-xl p-4 backdrop-blur-lg border border-white/20">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-lg font-bold mr-3">
                                        {{ subscription?.name?.charAt(0) || '?' }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-white font-semibold text-base">{{ getDisplayName(subscription)
                                        }}
                                        </h3>
                                        <p class="text-white/60 text-xs">{{ getDisplayEmail(subscription) }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="viewProfile(subscription)"
                                        class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-3 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                        Voir le profil
                                    </button>
                                    <button @click="unsubscribe(subscription)"
                                        class="flex-1 bg-gradient-to-r from-red-600 to-pink-600 text-white px-3 py-2 rounded-lg font-semibold hover:from-red-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                        Se désabonner
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8">
                            <UserGroupIcon class="w-12 h-12 text-cyan-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucun artiste suivi</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Suivez vos artistes préférés pour recevoir leurs nouvelles sorties !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                            Découvrir des artistes
                            </Link>
                        </div>
                    </section>

                    <!-- Nouvelles sorties -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <SparklesIcon class="w-4 h-4 text-blue-400" />
                            Nouvelles sorties
                        </h2>

                        <div v-if="safeNewReleases.length > 0" class="grid grid-cols-1 gap-4">
                            <MusicCard v-for="track in safeNewReleases" :key="track.id" :track="track" @play="playMusic"
                                @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />
                        </div>

                        <div v-else class="text-center py-8">
                            <MusicalNoteIcon class="w-12 h-12 text-purple-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">Aucune nouvelle sortie</h3>
                            <p class="text-white/80 mb-4 text-sm">
                                Suivez des artistes pour voir leurs nouvelles sorties ici !
                            </p>
                            <Link href="/"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                            Explorer la musique
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
    UserGroupIcon,
    MagnifyingGlassIcon,
    MusicalNoteIcon,
    SparklesIcon,
    ChartBarIcon,
    BellIcon,
    UserIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    subscriptions: {
        type: Array,
        default: () => []
    },
    newReleases: {
        type: Array,
        default: () => []
    },
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

// Computed properties
const safeNewReleases = computed(() => {
    return Array.isArray(props.newReleases) ? props.newReleases : []
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

    showNotification('🎵 Sélectionnez une playlist pour ajouter cette musique')
    // Ici vous pourriez ouvrir un modal de sélection de playlist
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

const getDisplayName = (subscription) => {
    return subscription?.name || 'Utilisateur inconnu'
}

const getDisplayEmail = (subscription) => {
    return subscription?.email || 'Email non disponible'
}

const viewProfile = (subscription) => {
    if (subscription?.name) {
        router.get(`/profile/${encodeURIComponent(subscription.name)}`)
    }
}

const unsubscribe = async (subscription) => {
    if (!subscription?.id) {
        showNotification('❌ Erreur: Utilisateur non trouvé')
        return
    }

    try {
        const response = await fetch(`/unfollow/${subscription.id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })

        const data = await response.json()

        if (data.success) {
            showNotification('✅ Désabonnement réussi')
            // Recharger la page pour mettre à jour la liste
            window.location.reload()
        } else {
            showNotification('❌ Erreur: ' + data.message)
        }
    } catch (error) {
        console.error('Erreur lors du désabonnement:', error)
        showNotification('❌ Erreur lors du désabonnement')
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
