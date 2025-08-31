<template>

    <Head title="Gestion des utilisateurs - Admin JaaJ FM" />

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
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-8">
                        <h1 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
                            <UsersIcon class="w-10 h-10 text-blue-400" />
                            Gestion des utilisateurs
                        </h1>
                        <p class="text-white/90 text-lg">Gérez tous les utilisateurs de la plateforme</p>
                    </section>

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Statistiques</h2>
                        <div class="grid grid-cols-4 gap-6">
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <UsersIcon class="w-8 h-8 text-blue-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ users.total }}</div>
                                <div class="text-white/70 text-sm">Total utilisateurs</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ShieldCheckIcon class="w-8 h-8 text-purple-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ adminCount }}</div>
                                <div class="text-white/70 text-sm">Administrateurs</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <MusicalNoteIcon class="w-8 h-8 text-green-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ totalMusics }}</div>
                                <div class="text-white/70 text-sm">Musiques totales</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <HeartIcon class="w-8 h-8 text-red-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ totalLikes }}</div>
                                <div class="text-white/70 text-sm">Likes totales</div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActions />

                    <!-- Liste des utilisateurs -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Liste des utilisateurs</h2>

                        <!-- Filtres -->
                        <div class="mb-6 flex gap-4">
                            <input v-model="searchQuery" type="text" placeholder="Rechercher un utilisateur..."
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <select v-model="filterRole"
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Tous les rôles</option>
                                <option value="admin">Administrateurs</option>
                                <option value="user">Utilisateurs</option>
                            </select>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-white/20">
                                        <th class="text-left p-4 text-white font-semibold">Utilisateur</th>
                                        <th class="text-left p-4 text-white font-semibold">Statistiques</th>
                                        <th class="text-left p-4 text-white font-semibold">Rôle</th>
                                        <th class="text-left p-4 text-white font-semibold">Date d'inscription</th>
                                        <th class="text-left p-4 text-white font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in filteredUsers" :key="user.id"
                                        class="border-b border-white/10 hover:bg-white/5">
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <img v-if="user.profile_photo_url" :src="user.profile_photo_url"
                                                    :alt="user.name" class="w-10 h-10 rounded-full">
                                                <div v-else
                                                    class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold">{{ user.name.charAt(0) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-white font-semibold">{{ user.name }}</div>
                                                    <div class="text-white/70 text-sm">{{ user.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="grid grid-cols-2 gap-2 text-sm">
                                                <div class="text-white/70">
                                                    <MusicalNoteIcon class="w-4 h-4 inline mr-1" />
                                                    {{ user.musics_count }}
                                                </div>
                                                <div class="text-white/70">
                                                    <HeartIcon class="w-4 h-4 inline mr-1" />
                                                    {{ user.likes_count }}
                                                </div>
                                                <div class="text-white/70">
                                                    <ChatBubbleLeftIcon class="w-4 h-4 inline mr-1" />
                                                    {{ user.music_comments_count }}
                                                </div>
                                                <div class="text-white/70">
                                                    <UserGroupIcon class="w-4 h-4 inline mr-1" />
                                                    {{ user.followers_count }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <span v-if="user.is_admin"
                                                class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-sm">
                                                Admin
                                            </span>
                                            <span v-else
                                                class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-sm">
                                                Utilisateur
                                            </span>
                                        </td>
                                        <td class="p-4 text-white/70 text-sm">
                                            {{ formatDate(user.created_at) }}
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2">
                                                <Link :href="route('profile.user', user.name)"
                                                    class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 px-3 py-1 rounded-lg text-sm transition-all">
                                                Voir profil
                                                </Link>
                                                <button @click="confirmDeleteUser(user)"
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
                        <div v-if="users.links" class="mt-6 flex justify-center">
                            <nav class="flex gap-2">
                                <Link v-for="link in users.links" :key="link.label" :href="link.url || '#'" :class="[
                                    'px-3 py-2 rounded-lg text-sm transition-all',
                                    link.active
                                        ? 'bg-blue-500 text-white'
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
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <!-- Contenu -->
                <div class="space-y-6">
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-4">
                        <h1 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <UsersIcon class="w-6 h-6 text-blue-400" />
                            Gestion des utilisateurs
                        </h1>
                        <p class="text-white/90 text-sm">Gérez tous les utilisateurs de la plateforme</p>
                    </section>

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Statistiques</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <UsersIcon class="w-6 h-6 text-blue-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ users.total }}</div>
                                <div class="text-white/70 text-xs">Total utilisateurs</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <ShieldCheckIcon class="w-6 h-6 text-purple-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ adminCount }}</div>
                                <div class="text-white/70 text-xs">Administrateurs</div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActionsMobile />

                    <!-- Filtres -->
                    <section class="glass rounded-2xl p-4">
                        <div class="flex flex-col gap-3">
                            <input v-model="searchQuery" type="text" placeholder="Rechercher un utilisateur..."
                                class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                            <select v-model="filterRole"
                                class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                                <option value="">Tous les rôles</option>
                                <option value="admin">Administrateurs</option>
                                <option value="user">Utilisateurs</option>
                            </select>
                        </div>
                    </section>

                    <!-- Liste des utilisateurs -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Liste des utilisateurs</h2>

                        <div class="space-y-4">
                            <div v-for="user in filteredUsers" :key="user.id"
                                class="bg-white/5 rounded-xl p-4 space-y-3">
                                <!-- En-tête utilisateur -->
                                <div class="flex items-center gap-3">
                                    <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                                        class="w-12 h-12 rounded-full">
                                    <div v-else
                                        class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold">{{ user.name.charAt(0) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ user.name }}</div>
                                        <div class="text-white/70 text-sm">{{ user.email }}</div>
                                    </div>
                                    <span v-if="user.is_admin"
                                        class="bg-purple-500/20 text-purple-300 px-2 py-1 rounded-full text-xs">
                                        Admin
                                    </span>
                                    <span v-else class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded-full text-xs">
                                        Utilisateur
                                    </span>
                                </div>

                                <!-- Statistiques -->
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="text-white/70">
                                        <MusicalNoteIcon class="w-4 h-4 inline mr-1" />
                                        {{ user.musics_count }} musiques
                                    </div>
                                    <div class="text-white/70">
                                        <HeartIcon class="w-4 h-4 inline mr-1" />
                                        {{ user.likes_count }} likes
                                    </div>
                                    <div class="text-white/70">
                                        <ChatBubbleLeftIcon class="w-4 h-4 inline mr-1" />
                                        {{ user.music_comments_count }} commentaires
                                    </div>
                                    <div class="text-white/70">
                                        <UserGroupIcon class="w-4 h-4 inline mr-1" />
                                        {{ user.followers_count }} followers
                                    </div>
                                </div>

                                <!-- Date et actions -->
                                <div class="flex items-center justify-between pt-2 border-t border-white/10">
                                    <div class="text-white/50 text-xs">
                                        Inscrit le {{ formatDate(user.created_at) }}
                                    </div>
                                    <div class="flex gap-2">
                                        <Link :href="route('profile.user', user.name)"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 px-2 py-1 rounded text-xs transition-all">
                                        Voir profil
                                        </Link>
                                        <button @click="confirmDeleteUser(user)"
                                            class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-2 py-1 rounded text-xs transition-all">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination mobile -->
                        <div v-if="users.links" class="mt-6 flex justify-center">
                            <nav class="flex gap-1">
                                <Link v-for="link in users.links" :key="link.label" :href="link.url || '#'" :class="[
                                    'px-2 py-1 rounded text-xs transition-all',
                                    link.active
                                        ? 'bg-blue-500 text-white'
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
                    Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ userToDelete?.name }}</strong> ?
                    Cette action est irréversible et supprimera toutes ses données.
                </p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all">
                        Annuler
                    </button>
                    <button @click="deleteUser"
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
    UsersIcon,
    MusicalNoteIcon,
    HeartIcon,
    ChatBubbleLeftIcon,
    UserGroupIcon,
    ShieldCheckIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    users: Object
})

const searchQuery = ref('')
const filterRole = ref('')
const showDeleteModal = ref(false)
const userToDelete = ref(null)

const filteredUsers = computed(() => {
    let filtered = props.users.data

    if (searchQuery.value) {
        filtered = filtered.filter(user =>
            user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }

    if (filterRole.value === 'admin') {
        filtered = filtered.filter(user => user.is_admin)
    } else if (filterRole.value === 'user') {
        filtered = filtered.filter(user => !user.is_admin)
    }

    return filtered
})

const adminCount = computed(() => {
    return props.users.data.filter(user => user.is_admin).length
})

const totalMusics = computed(() => {
    return props.users.data.reduce((total, user) => total + user.musics_count, 0)
})

const totalLikes = computed(() => {
    return props.users.data.reduce((total, user) => total + user.likes_count, 0)
})



const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

const confirmDeleteUser = (user) => {
    userToDelete.value = user
    showDeleteModal.value = true
}

const deleteUser = () => {
    if (userToDelete.value) {
        router.delete(route('admin.users.delete', userToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false
                userToDelete.value = null
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
