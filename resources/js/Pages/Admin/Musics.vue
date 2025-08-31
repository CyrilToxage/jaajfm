<template>

    <Head title="Gestion des musiques - Admin JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
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
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-8">
                        <h1 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
                            <MusicalNoteIcon class="w-10 h-10 text-green-400" />
                            Gestion des musiques
                        </h1>
                        <p class="text-white/90 text-lg">Gérez toutes les musiques de la plateforme</p>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActions />

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Statistiques</h2>
                        <div class="grid grid-cols-4 gap-6">
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <MusicalNoteIcon class="w-8 h-8 text-green-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ musics.total }}</div>
                                <div class="text-white/70 text-sm">Total musiques</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <HeartIcon class="w-8 h-8 text-red-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ totalLikes }}</div>
                                <div class="text-white/70 text-sm">Likes totales</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <EyeIcon class="w-8 h-8 text-blue-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ totalViews }}</div>
                                <div class="text-white/70 text-sm">Vues totales</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ChatBubbleLeftIcon class="w-8 h-8 text-yellow-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ totalComments }}</div>
                                <div class="text-white/70 text-sm">Commentaires</div>
                            </div>
                        </div>
                    </section>

                    <!-- Liste des musiques -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Liste des musiques</h2>

                        <!-- Filtres -->
                        <div class="mb-6 flex gap-4">
                            <input v-model="searchQuery" type="text" placeholder="Rechercher une musique..."
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <select v-model="filterGenre"
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Tous les genres</option>
                                <option v-for="genre in availableGenres" :key="genre" :value="genre">{{ genre }}
                                </option>
                            </select>
                            <select v-model="sortBy"
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="created_at">Plus récentes</option>
                                <option value="likes_count">Plus likées</option>
                                <option value="views_count">Plus vues</option>
                                <option value="comments_count">Plus commentées</option>
                            </select>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-white/20">
                                        <th class="text-left p-4 text-white font-semibold">Musique</th>
                                        <th class="text-left p-4 text-white font-semibold">Artiste</th>
                                        <th class="text-left p-4 text-white font-semibold">Genres</th>
                                        <th class="text-left p-4 text-white font-semibold">Statistiques</th>
                                        <th class="text-left p-4 text-white font-semibold">Date</th>
                                        <th class="text-left p-4 text-white font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="music in filteredMusics" :key="music.id"
                                        class="border-b border-white/10 hover:bg-white/5">
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div v-if="music.cover_image_url"
                                                    class="w-12 h-12 rounded-lg overflow-hidden">
                                                    <img :src="music.cover_image_url" :alt="music.title"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div v-else
                                                    class="w-12 h-12 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                                    <MusicalNoteIcon class="w-6 h-6 text-white" />
                                                </div>
                                                <div>
                                                    <div class="text-white font-semibold">{{ music.title }}</div>
                                                    <div class="text-white/70 text-sm">{{ music.duration }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center gap-2">
                                                <img v-if="music.user?.profile_photo_url"
                                                    :src="music.user.profile_photo_url" :alt="music.user.name"
                                                    class="w-6 h-6 rounded-full">
                                                <div v-else
                                                    class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">{{
                                                        music.user?.name?.charAt(0) }}</span>
                                                </div>
                                                <span class="text-white">{{ music.user?.name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span v-for="genre in music.genres" :key="genre.id"
                                                    class="bg-purple-500/20 text-purple-300 px-2 py-1 rounded-full text-xs">
                                                    {{ genre.name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="grid grid-cols-3 gap-2 text-sm">
                                                <div class="text-white/70">
                                                    <HeartIcon class="w-4 h-4 inline mr-1" />
                                                    {{ music.likes_count }}
                                                </div>
                                                <div class="text-white/70">
                                                    <EyeIcon class="w-4 h-4 inline mr-1" />
                                                    {{ music.views_count || 0 }}
                                                </div>
                                                <div class="text-white/70">
                                                    <ChatBubbleLeftIcon class="w-4 h-4 inline mr-1" />
                                                    {{ music.comments_count }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-white/70 text-sm">
                                            {{ formatDate(music.created_at) }}
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2">
                                                <Link :href="route('music.show', music.slug)"
                                                    class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 px-3 py-1 rounded-lg text-sm transition-all">
                                                Écouter
                                                </Link>
                                                <button @click="confirmDeleteMusic(music)"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-3 py-1 rounded-lg text-sm transition-all">
                                                    Supprimer
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div v-if="musics.links" class="mt-6 flex justify-center">
                            <nav class="flex gap-2">
                                <Link v-for="link in musics.links" :key="link.label" :href="link.url || '#'" :class="[
                                    'px-3 py-2 rounded-lg text-sm transition-all',
                                    link.active
                                        ? 'bg-green-500 text-white'
                                        : link.url
                                            ? 'bg-white/10 text-white/70 hover:bg-white/20'
                                            : 'bg-white/5 text-white/30 cursor-not-allowed'
                                ]" v-html="link.label">
                                </Link>
                            </nav>
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
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-4">
                        <h1 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-6 h-6 text-green-400" />
                            Gestion des musiques
                        </h1>
                        <p class="text-white/90 text-sm">Gérez toutes les musiques de la plateforme</p>
                    </section>

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Statistiques</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <MusicalNoteIcon class="w-6 h-6 text-green-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ musics.total }}</div>
                                <div class="text-white/70 text-xs">Total musiques</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <HeartIcon class="w-6 h-6 text-red-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ totalLikes }}</div>
                                <div class="text-white/70 text-xs">Likes totales</div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActionsMobile />

                    <!-- Filtres -->
                    <section class="glass rounded-2xl p-4">
                        <div class="flex flex-col gap-3">
                            <input v-model="searchQuery" type="text" placeholder="Rechercher une musique..."
                                class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm">
                            <select v-model="filterGenre"
                                class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-400 text-sm">
                                <option value="">Tous les genres</option>
                                <option v-for="genre in availableGenres" :key="genre" :value="genre">{{ genre }}
                                </option>
                            </select>
                        </div>
                    </section>

                    <!-- Liste des musiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Liste des musiques</h2>

                        <div class="space-y-4">
                            <div v-for="music in filteredMusics" :key="music.id"
                                class="bg-white/5 rounded-xl p-4 space-y-3">
                                <!-- En-tête musique -->
                                <div class="flex items-center gap-3">
                                    <div v-if="music.cover_image_url" class="w-16 h-16 rounded-lg overflow-hidden">
                                        <img :src="music.cover_image_url" :alt="music.title"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div v-else
                                        class="w-16 h-16 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-8 h-8 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ music.title }}</div>
                                        <div class="text-white/70 text-sm">{{ music.duration }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <img v-if="music.user?.profile_photo_url"
                                                :src="music.user.profile_photo_url" :alt="music.user.name"
                                                class="w-4 h-4 rounded-full">
                                            <div v-else
                                                class="w-4 h-4 bg-purple-500 rounded-full flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">{{
                                                    music.user?.name?.charAt(0) }}</span>
                                            </div>
                                            <span class="text-white/70 text-xs">{{ music.user?.name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Genres -->
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="genre in music.genres" :key="genre.id"
                                        class="bg-purple-500/20 text-purple-300 px-2 py-1 rounded-full text-xs">
                                        {{ genre.name }}
                                    </span>
                                </div>

                                <!-- Statistiques -->
                                <div class="grid grid-cols-3 gap-2 text-sm">
                                    <div class="text-white/70">
                                        <HeartIcon class="w-4 h-4 inline mr-1" />
                                        {{ music.likes_count }}
                                    </div>
                                    <div class="text-white/70">
                                        <EyeIcon class="w-4 h-4 inline mr-1" />
                                        {{ music.views_count || 0 }}
                                    </div>
                                    <div class="text-white/70">
                                        <ChatBubbleLeftIcon class="w-4 h-4 inline mr-1" />
                                        {{ music.comments_count }}
                                    </div>
                                </div>

                                <!-- Date et actions -->
                                <div class="flex items-center justify-between pt-2 border-t border-white/10">
                                    <div class="text-white/50 text-xs">
                                        Ajoutée le {{ formatDate(music.created_at) }}
                                    </div>
                                    <div class="flex gap-2">
                                        <Link :href="route('music.show', music.slug)"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 px-2 py-1 rounded text-xs transition-all">
                                        Écouter
                                        </Link>
                                        <button @click="confirmDeleteMusic(music)"
                                            class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-2 py-1 rounded text-xs transition-all">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination mobile -->
                        <div v-if="musics.links" class="mt-6 flex justify-center">
                            <nav class="flex gap-1">
                                <Link v-for="link in musics.links" :key="link.label" :href="link.url || '#'" :class="[
                                    'px-2 py-1 rounded text-xs transition-all',
                                    link.active
                                        ? 'bg-green-500 text-white'
                                        : link.url
                                            ? 'bg-white/10 text-white/70 hover:bg-white/20'
                                            : 'bg-white/5 text-white/30 cursor-not-allowed'
                                ]" v-html="link.label">
                                </Link>
                            </nav>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>

        <!-- Modal de confirmation -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-gray-800 rounded-2xl p-6 max-w-md w-full">
                <h3 class="text-xl font-bold text-white mb-4">Confirmer la suppression</h3>
                <p class="text-white/70 mb-6">
                    Êtes-vous sûr de vouloir supprimer la musique <strong>{{ musicToDelete?.title }}</strong> ?
                    Cette action est irréversible et supprimera le fichier audio.
                </p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all">
                        Annuler
                    </button>
                    <button @click="deleteMusic"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import AdminQuickActions from '@/Components/AdminQuickActions.vue'
import AdminQuickActionsMobile from '@/Components/AdminQuickActionsMobile.vue'
import {
    MusicalNoteIcon,
    HeartIcon,
    EyeIcon,
    ChatBubbleLeftIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    musics: Object
})

const searchQuery = ref('')
const filterGenre = ref('')
const sortBy = ref('created_at')
const showDeleteModal = ref(false)
const musicToDelete = ref(null)

const availableGenres = computed(() => {
    const genres = new Set()
    props.musics.data.forEach(music => {
        music.genres.forEach(genre => genres.add(genre.name))
    })
    return Array.from(genres).sort()
})

const filteredMusics = computed(() => {
    let filtered = props.musics.data

    if (searchQuery.value) {
        filtered = filtered.filter(music =>
            music.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            music.user?.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }

    if (filterGenre.value) {
        filtered = filtered.filter(music =>
            music.genres.some(genre => genre.name === filterGenre.value)
        )
    }

    // Tri
    filtered.sort((a, b) => {
        if (sortBy.value === 'likes_count') {
            return b.likes_count - a.likes_count
        } else if (sortBy.value === 'views_count') {
            return (b.views_count || 0) - (a.views_count || 0)
        } else if (sortBy.value === 'comments_count') {
            return b.comments_count - a.comments_count
        } else {
            return new Date(b.created_at) - new Date(a.created_at)
        }
    })

    return filtered
})

const totalLikes = computed(() => {
    return props.musics.data.reduce((total, music) => total + music.likes_count, 0)
})

const totalViews = computed(() => {
    return props.musics.data.reduce((total, music) => total + (music.views_count || 0), 0)
})

const totalComments = computed(() => {
    return props.musics.data.reduce((total, music) => total + music.comments_count, 0)
})

const handleLiveRadioToggle = (isPlaying) => {
    // Gestion du toggle radio live
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

const confirmDeleteMusic = (music) => {
    musicToDelete.value = music
    showDeleteModal.value = true
}

const deleteMusic = () => {
    if (musicToDelete.value) {
        router.delete(route('admin.musics.delete', musicToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false
                musicToDelete.value = null
            }
        })
    }
}
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}
</style>
