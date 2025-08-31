<template>

    <Head title="Aide - JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu de l'aide -->
                <div class="space-y-8">
                    <!-- Section Bienvenue -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <MusicalNoteIcon class="w-6 h-6 text-purple-400" />
                            Bienvenue sur JaaJ FM
                        </h2>
                        <p class="text-white/90 leading-relaxed">
                            JaaJ FM est une plateforme de réseau social musical où vous pouvez découvrir,
                            partager et créer de la musique. Que vous soyez un artiste, un producteur ou
                            simplement un passionné de musique, vous trouverez votre place dans notre communauté.
                        </p>
                    </section>

                    <!-- Fonctionnalités publiques -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <SparklesIcon class="w-6 h-6 text-yellow-400" />
                            Fonctionnalités publiques
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-white/10 rounded-xl p-4">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <SpeakerWaveIcon class="w-5 h-5 text-blue-400" />
                                    Écouter de la musique
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Découvrez des milliers de titres dans différents genres musicaux.
                                    Écoutez gratuitement et découvrez de nouveaux artistes.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <MagnifyingGlassIcon class="w-5 h-5 text-green-400" />
                                    Rechercher
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Utilisez notre barre de recherche pour trouver des musiques,
                                    artistes ou playlists par genre, titre ou description.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <RadioIcon class="w-5 h-5 text-orange-400" />
                                    Radio Live
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Écoutez notre radio en direct et participez aux sessions live
                                    avec d'autres auditeurs de la communauté.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <PaintBrushIcon class="w-5 h-5 text-pink-400" />
                                    Explorer par genre
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Parcourez notre collection par catégories musicales :
                                    Pop, Rock, Électronique, Jazz, Classique, et plus encore.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Fonctionnalités premium -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <StarIcon class="w-6 h-6 text-cyan-400" />
                            Créez un compte pour débloquer
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <MusicalNoteIcon class="w-5 h-5 text-green-400" />
                                    Créer de la musique
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Uploadez vos créations originales ou générées par IA.
                                    Partagez votre talent avec la communauté mondiale.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <BookOpenIcon class="w-5 h-5 text-purple-400" />
                                    Bibliothèque personnelle
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Sauvegardez vos musiques préférées et créez votre
                                    collection personnelle accessible partout.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <HeartIcon class="w-5 h-5 text-red-400" />
                                    Likes et playlists
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Likez vos musiques préférées et créez des playlists
                                    thématiques pour partager avec vos amis.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30">
                                <h3 class="text-lg font-semibold text-white mb-2 flex items-center gap-2">
                                    <UserGroupIcon class="w-5 h-5 text-cyan-400" />
                                    Abonnements
                                </h3>
                                <p class="text-white/80 text-sm">
                                    Suivez vos artistes préférés et recevez des notifications
                                    quand ils publient de nouveaux contenus.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- CTA Inscription -->
                    <section class="glass rounded-2xl p-6 text-center">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center justify-center gap-2">
                            <RocketLaunchIcon class="w-6 h-6 text-orange-400" />
                            Prêt à rejoindre la communauté ?
                        </h2>
                        <p class="text-white/90 mb-6">
                            Créez votre compte gratuitement et commencez à partager votre passion pour la musique !
                        </p>
                        <div class="flex justify-center gap-4">
                            <Link href="/register"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-xl font-semibold hover:scale-105 transition-transform">
                            S'inscrire gratuitement
                            </Link>
                            <Link href="/login"
                                class="bg-white/20 text-white px-8 py-3 rounded-xl font-semibold hover:bg-white/30 transition-colors">
                            Se connecter
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
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import {
    MusicalNoteIcon,
    SpeakerWaveIcon,
    MagnifyingGlassIcon,
    BookOpenIcon,
    HeartIcon,
    UserGroupIcon,
    SparklesIcon,
    RadioIcon,
    PaintBrushIcon,
    StarIcon,
    RocketLaunchIcon
} from '@heroicons/vue/24/outline'

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
