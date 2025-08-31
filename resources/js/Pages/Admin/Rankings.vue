<template>

    <Head title="Classements - Admin JaaJ FM" />

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
                            <TrophyIcon class="w-10 h-10 text-yellow-400" />
                            Classements
                        </h1>
                        <p class="text-white/90 text-lg">Découvrez les meilleurs contenus et utilisateurs de la
                            plateforme</p>
                    </section>

                    <!-- Classements des musiques -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Musiques les plus likées -->
                        <section class="glass rounded-2xl p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <HeartIcon class="w-6 h-6 text-red-400" />
                                Musiques les plus likées
                            </h2>
                            <div class="space-y-4">
                                <div v-for="(music, index) in rankings.most_liked" :key="music.id"
                                    class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div v-if="music.cover_image_url" class="w-12 h-12 rounded-lg overflow-hidden">
                                        <img :src="music.cover_image_url" :alt="music.title"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div v-else
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ music.title }}</div>
                                        <div class="text-white/70 text-sm">{{ music.user?.name }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-bold">{{ music.likes_count }}</div>
                                        <div class="text-white/50 text-xs">likes</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Musiques les plus vues -->
                        <section class="glass rounded-2xl p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <EyeIcon class="w-6 h-6 text-blue-400" />
                                Musiques les plus vues
                            </h2>
                            <div class="space-y-4">
                                <div v-for="(music, index) in rankings.most_viewed" :key="music.id"
                                    class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div v-if="music.cover_image_url" class="w-12 h-12 rounded-lg overflow-hidden">
                                        <img :src="music.cover_image_url" :alt="music.title"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div v-else
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ music.title }}</div>
                                        <div class="text-white/70 text-sm">{{ music.user?.name }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-bold">{{ music.views_count || 0 }}</div>
                                        <div class="text-white/50 text-xs">vues</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Musiques les plus commentées -->
                        <section class="glass rounded-2xl p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <ChatBubbleLeftIcon class="w-6 h-6 text-yellow-400" />
                                Musiques les plus commentées
                            </h2>
                            <div class="space-y-4">
                                <div v-for="(music, index) in rankings.most_commented" :key="music.id"
                                    class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div v-if="music.cover_image_url" class="w-12 h-12 rounded-lg overflow-hidden">
                                        <img :src="music.cover_image_url" :alt="music.title"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div v-else
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ music.title }}</div>
                                        <div class="text-white/70 text-sm">{{ music.user?.name }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-bold">{{ music.comments_count }}</div>
                                        <div class="text-white/50 text-xs">commentaires</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Top utilisateurs -->
                        <section class="glass rounded-2xl p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <UsersIcon class="w-6 h-6 text-purple-400" />
                                Top utilisateurs
                            </h2>
                            <div class="space-y-4">
                                <div v-for="(user, index) in rankings.top_users" :key="user.id"
                                    class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                                        class="w-12 h-12 rounded-full">
                                    <div v-else
                                        class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold">{{ user.name.charAt(0) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-semibold">{{ user.name }}</div>
                                        <div class="text-white/70 text-sm">{{ user.musics_count }} musiques</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-bold">{{ user.followers_count }}</div>
                                        <div class="text-white/50 text-xs">followers</div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Actions rapides -->
                    <AdminQuickActions />

                    <!-- Statistiques globales -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Statistiques globales</h2>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
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
                    <!-- Actions rapides -->
                    <AdminQuickActionsMobile />

                    <!-- Titre -->
                    <section class="glass rounded-2xl p-4">
                        <h1 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <TrophyIcon class="w-6 h-6 text-yellow-400" />
                            Classements
                        </h1>
                        <p class="text-white/90 text-sm">Découvrez les meilleurs contenus et utilisateurs</p>
                    </section>

                    <!-- Musiques les plus likées -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <HeartIcon class="w-5 h-5 text-red-400" />
                            Musiques les plus likées
                        </h2>
                        <div class="space-y-3">
                            <div v-for="(music, index) in rankings.most_liked.slice(0, 5)" :key="music.id"
                                class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                <div
                                    class="w-6 h-6 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ index + 1 }}
                                </div>
                                <div v-if="music.cover_image_url" class="w-10 h-10 rounded-lg overflow-hidden">
                                    <img :src="music.cover_image_url" :alt="music.title"
                                        class="w-full h-full object-cover">
                                </div>
                                <div v-else
                                    class="w-10 h-10 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                    <MusicalNoteIcon class="w-5 h-5 text-white" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-white font-semibold text-sm">{{ music.title }}</div>
                                    <div class="text-white/70 text-xs">{{ music.user?.name }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-white font-bold text-sm">{{ music.likes_count }}</div>
                                    <div class="text-white/50 text-xs">likes</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Musiques les plus vues -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <EyeIcon class="w-5 h-5 text-blue-400" />
                            Musiques les plus vues
                        </h2>
                        <div class="space-y-3">
                            <div v-for="(music, index) in (rankings.most_viewed || []).slice(0, 5)" :key="music.id"
                                class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                <div
                                    class="w-6 h-6 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ index + 1 }}
                                </div>
                                <div v-if="music.cover_image_url" class="w-10 h-10 rounded-lg overflow-hidden">
                                    <img :src="music.cover_image_url" :alt="music.title"
                                        class="w-full h-full object-cover">
                                </div>
                                <div v-else
                                    class="w-10 h-10 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-lg flex items-center justify-center">
                                    <MusicalNoteIcon class="w-5 h-5 text-white" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-white font-semibold text-sm">{{ music.title }}</div>
                                    <div class="text-white/70 text-xs">{{ music.user?.name }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-white font-bold text-sm">{{ music.views_count }}</div>
                                    <div class="text-white/50 text-xs">vues</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Top utilisateurs -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <UsersIcon class="w-5 h-5 text-purple-400" />
                            Top utilisateurs
                        </h2>
                        <div class="space-y-3">
                            <div v-for="(user, index) in rankings.top_users.slice(0, 5)" :key="user.id"
                                class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                <div
                                    class="w-6 h-6 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ index + 1 }}
                                </div>
                                <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                                    class="w-10 h-10 rounded-full">
                                <div v-else
                                    class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ user.name.charAt(0) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-white font-semibold text-sm">{{ user.name }}</div>
                                    <div class="text-white/70 text-xs">{{ user.musics_count }} musiques</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-white font-bold text-sm">{{ user.followers_count }}</div>
                                    <div class="text-white/50 text-xs">followers</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Statistiques globales -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Statistiques globales</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <MusicalNoteIcon class="w-6 h-6 text-green-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ totalMusics }}</div>
                                <div class="text-white/70 text-xs">Musiques totales</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <HeartIcon class="w-6 h-6 text-red-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ totalLikes }}</div>
                                <div class="text-white/70 text-xs">Likes totales</div>
                            </div>
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
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import AdminQuickActions from '@/Components/AdminQuickActions.vue'
import AdminQuickActionsMobile from '@/Components/AdminQuickActionsMobile.vue'
import {
    TrophyIcon,
    HeartIcon,
    EyeIcon,
    ChatBubbleLeftIcon,
    MusicalNoteIcon,
    UsersIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    rankings: Object
})

const totalMusics = computed(() => {
    return props.rankings.most_liked.length + props.rankings.most_viewed.length + props.rankings.most_commented.length
})

const totalLikes = computed(() => {
    return props.rankings.most_liked.reduce((total, music) => total + music.likes_count, 0)
})

const totalViews = computed(() => {
    return props.rankings.most_viewed.reduce((total, music) => total + (music.views_count || 0), 0)
})

const totalComments = computed(() => {
    return props.rankings.most_commented.reduce((total, music) => total + music.comments_count, 0)
})

const handleLiveRadioToggle = (isPlaying) => {
    // Gestion du toggle radio live
}
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}
</style>
