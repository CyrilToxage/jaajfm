<template>

    <Head title="Dashboard Admin - JaaJ FM" />

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
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-8">
                        <h1 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
                            <ShieldCheckIcon class="w-10 h-10 text-purple-400" />
                            Dashboard Administrateur
                        </h1>
                        <p class="text-white/90 text-lg">Bienvenue dans votre espace d'administration JaaJ FM</p>
                    </section>

                    <!-- Statistiques générales -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Statistiques générales</h2>
                        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <UsersIcon class="w-8 h-8 text-blue-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.total_users }}</div>
                                <div class="text-white/70 text-sm">Utilisateurs</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <MusicalNoteIcon class="w-8 h-8 text-green-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.total_musics }}</div>
                                <div class="text-white/70 text-sm">Musiques</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <HeartIcon class="w-8 h-8 text-red-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.total_likes }}</div>
                                <div class="text-white/70 text-sm">Likes</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ChatBubbleLeftIcon class="w-8 h-8 text-yellow-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.total_comments }}</div>
                                <div class="text-white/70 text-sm">Commentaires</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ListBulletIcon class="w-8 h-8 text-purple-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.total_playlists }}</div>
                                <div class="text-white/70 text-sm">Playlists</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ExclamationTriangleIcon class="w-8 h-8 text-orange-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.pending_reports }}</div>
                                <div class="text-white/70 text-sm">Signalements</div>
                            </div>
                        </div>
                    </section>

                    <!-- Aperçus récents -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Utilisateurs récents -->
                        <section class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <UsersIcon class="w-5 h-5 text-blue-400" />
                                Utilisateurs récents
                            </h3>
                            <div class="space-y-3">
                                <div v-for="user in stats.recent_users" :key="user.id"
                                    class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                    <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                                        class="w-8 h-8 rounded-full">
                                    <div v-else
                                        class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">{{ user.name.charAt(0) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ user.name }}</div>
                                        <div class="text-white/70 text-sm">{{ user.email }}</div>
                                    </div>
                                    <div class="text-white/50 text-xs">
                                        {{ formatDate(user.created_at) }}
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Musiques récentes -->
                        <section class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <MusicalNoteIcon class="w-5 h-5 text-green-400" />
                                Musiques récentes
                            </h3>
                            <div class="space-y-3">
                                <div v-for="music in stats.recent_musics" :key="music.id"
                                    class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-4 h-4 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ music.title }}</div>
                                        <div class="text-white/70 text-sm">{{ music.user?.name }}</div>
                                    </div>
                                    <div class="text-white/50 text-xs">
                                        {{ formatDate(music.created_at) }}
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Signalements récents -->
                        <section class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <ExclamationTriangleIcon class="w-5 h-5 text-orange-400" />
                                Signalements récents
                            </h3>
                            <div class="space-y-3">
                                <div v-for="report in stats.recent_reports" :key="report.id"
                                    class="p-3 bg-white/5 rounded-lg">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-white/70 text-sm">{{ report.reporter?.name }}</span>
                                        <span class="text-white/50">•</span>
                                        <span class="text-white/70 text-sm">{{ report.reason }}</span>
                                    </div>
                                    <div class="text-white/90 text-sm">
                                        {{ report.description?.substring(0, 50) }}...
                                    </div>
                                    <div class="text-white/50 text-xs mt-2">
                                        {{ formatDate(report.created_at) }}
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Actions rapides -->
                    <AdminQuickActions />
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
                            <ShieldCheckIcon class="w-6 h-6 text-purple-400" />
                            Dashboard Admin
                        </h1>
                        <p class="text-white/90 text-sm">Bienvenue dans votre espace d'administration</p>
                    </section>

                    <!-- Statistiques générales -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Statistiques générales</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <UsersIcon class="w-6 h-6 text-blue-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.total_users }}</div>
                                <div class="text-white/70 text-xs">Utilisateurs</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <MusicalNoteIcon class="w-6 h-6 text-green-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.total_musics }}</div>
                                <div class="text-white/70 text-xs">Musiques</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <HeartIcon class="w-6 h-6 text-red-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.total_likes }}</div>
                                <div class="text-white/70 text-xs">Likes</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <ExclamationTriangleIcon class="w-6 h-6 text-orange-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.pending_reports }}</div>
                                <div class="text-white/70 text-xs">Signalements</div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActionsMobile />
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import AdminQuickActions from '@/Components/AdminQuickActions.vue'
import AdminQuickActionsMobile from '@/Components/AdminQuickActionsMobile.vue'
import {
    ShieldCheckIcon,
    UsersIcon,
    MusicalNoteIcon,
    HeartIcon,
    ChatBubbleLeftIcon,
    ListBulletIcon,
    ExclamationTriangleIcon,
    TrophyIcon
} from '@heroicons/vue/24/outline'

defineProps({
    stats: Object
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
