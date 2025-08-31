<template>

    <Head title="À propos - JaaJ FM" />

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
                    <!-- Section Bienvenue -->
                    <section class="glass rounded-2xl p-8">
                        <h1 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
                            <MusicalNoteIcon class="w-10 h-10 text-purple-400" />
                            À propos de JaaJ FM
                        </h1>
                        <p class="text-white/90 leading-relaxed text-lg">
                            JaaJ FM est une plateforme de réseau social musical innovante où vous pouvez découvrir,
                            partager et créer de la musique. Que vous soyez un artiste, un producteur ou
                            simplement un passionné de musique, vous trouverez votre place dans notre communauté.
                        </p>
                    </section>

                    <!-- Fonctionnalités publiques -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                            <SparklesIcon class="w-8 h-8 text-yellow-400" />
                            Fonctionnalités publiques
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <SpeakerWaveIcon class="w-6 h-6 text-blue-400" />
                                    Écouter de la musique
                                </h3>
                                <p class="text-white/80">
                                    Découvrez des milliers de titres dans différents genres musicaux.
                                    Écoutez gratuitement et découvrez de nouveaux artistes.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <MagnifyingGlassIcon class="w-6 h-6 text-green-400" />
                                    Recherche intelligente
                                </h3>
                                <p class="text-white/80">
                                    Recherche avancée par titre, artiste, genre ou description.
                                    Résultats triés par pertinence pour une découverte optimale.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <TrophyIcon class="w-6 h-6 text-orange-400" />
                                    Classements
                                </h3>
                                <p class="text-white/80">
                                    Découvrez les meilleures musiques et artistes selon le ratio likes/vues.
                                    Classements mis à jour en temps réel.
                                </p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <PaintBrushIcon class="w-6 h-6 text-pink-400" />
                                    Exploration par genre
                                </h3>
                                <p class="text-white/80">
                                    Parcourez notre collection par catégories musicales :
                                    Rock, Électronique, Jazz, Classique, Pop, et bien plus encore.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Nouvelles fonctionnalités -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                            <StarIcon class="w-8 h-8 text-cyan-400" />
                            Nouvelles fonctionnalités
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <UserGroupIcon class="w-6 h-6 text-green-400" />
                                    Communauté
                                </h3>
                                <p class="text-white/80">
                                    Créez des posts et commentez ceux des autres utilisateurs.
                                    Partagez votre passion pour la musique avec la communauté.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <PlayIcon class="w-6 h-6 text-purple-400" />
                                    Playlists avancées
                                </h3>
                                <p class="text-white/80">
                                    Créez des playlists personnalisées avec drag & drop.
                                    Ajoutez des images de couverture et partagez-les.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <TagIcon class="w-6 h-6 text-red-400" />
                                    Système de genres
                                </h3>
                                <p class="text-white/80">
                                    Nouveau système de genres hiérarchiques avec sous-genres.
                                    Sélection multiple de genres pour vos musiques.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <EyeIcon class="w-6 h-6 text-cyan-400" />
                                    Système de vues unique
                                </h3>
                                <p class="text-white/80">
                                    Chaque utilisateur ne compte qu'une seule vue par musique.
                                    Classements plus équitables et précis.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Fonctionnalités premium -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                            <SparklesIcon class="w-8 h-8 text-yellow-400" />
                            Créez un compte pour débloquer
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <MusicalNoteIcon class="w-6 h-6 text-green-400" />
                                    Créer de la musique
                                </h3>
                                <p class="text-white/80">
                                    Uploadez vos créations originales avec images de couverture.
                                    Partagez votre talent avec la communauté mondiale.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <BookOpenIcon class="w-6 h-6 text-purple-400" />
                                    Bibliothèque personnelle
                                </h3>
                                <p class="text-white/80">
                                    Sauvegardez vos musiques préférées et créez votre
                                    collection personnelle accessible partout.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <HeartIcon class="w-6 h-6 text-red-400" />
                                    Likes et playlists
                                </h3>
                                <p class="text-white/80">
                                    Likez vos musiques préférées et créez des playlists
                                    thématiques pour partager avec vos amis.
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30">
                                <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2">
                                    <UserGroupIcon class="w-6 h-6 text-cyan-400" />
                                    Abonnements
                                </h3>
                                <p class="text-white/80">
                                    Suivez vos artistes préférés et recevez des notifications
                                    quand ils publient de nouveaux contenus.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- CTA Inscription -->
                    <section class="glass rounded-2xl p-8 text-center">
                        <h2 class="text-3xl font-bold text-white mb-6 flex items-center justify-center gap-3">
                            <RocketLaunchIcon class="w-8 h-8 text-orange-400" />
                            Prêt à rejoindre la communauté ?
                        </h2>
                        <p class="text-white/90 mb-8 text-lg">
                            Créez votre compte gratuitement et commencez à partager votre passion pour la musique !
                        </p>
                        <div class="flex justify-center gap-4 mb-8">
                            <Link href="/register"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-4 rounded-xl font-semibold hover:scale-105 transition-transform text-lg">
                            S'inscrire gratuitement
                            </Link>
                            <Link href="/login"
                                class="bg-white/20 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-colors text-lg">
                            Se connecter
                            </Link>
                        </div>
                    </section>

                    <!-- Liens légaux -->
                    <section class="glass rounded-2xl p-8 text-center">
                        <h2 class="text-2xl font-bold text-white mb-6">
                            Informations légales
                        </h2>
                        <div class="flex justify-center gap-6">
                            <Link href="/legal"
                                class="bg-white/10 text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/20 transition-colors">
                            Mentions légales
                            </Link>
                            <Link href="/privacy"
                                class="bg-white/10 text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/20 transition-colors">
                            Politique de confidentialité
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
            <MobilePageHeader @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <!-- Contenu -->
                <div class="space-y-6">
                    <!-- Hero Section -->
                    <section class="glass rounded-2xl p-6 text-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <MusicalNoteIcon class="w-10 h-10 text-white" />
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-3">À propos de JaaJ FM</h1>
                        <p class="text-white/80 text-sm leading-relaxed">
                            Découvrez la plateforme musicale qui révolutionne l'expérience d'écoute.
                            Partagez, découvrez et connectez-vous avec des artistes du monde entier.
                        </p>
                    </section>

                    <!-- Fonctionnalités -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <SparklesIcon class="w-4 h-4 text-purple-400" />
                            Nos Fonctionnalités
                        </h2>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                        <MusicalNoteIcon class="w-4 h-4 text-white" />
                                    </div>
                                    <h3 class="text-white font-semibold">Upload de Musique</h3>
                                </div>
                                <p class="text-white/70 text-sm">Partagez vos créations musicales avec le monde entier
                                </p>
                            </div>

                            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                        <PlayIcon class="w-4 h-4 text-white" />
                                    </div>
                                    <h3 class="text-white font-semibold">Playlists Personnalisées</h3>
                                </div>
                                <p class="text-white/70 text-sm">Créez et partagez vos playlists favorites</p>
                            </div>

                            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                        <UserGroupIcon class="w-4 h-4 text-white" />
                                    </div>
                                    <h3 class="text-white font-semibold">Communauté Active</h3>
                                </div>
                                <p class="text-white/70 text-sm">Connectez-vous avec d'autres passionnés de musique</p>
                            </div>

                            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                                        <TrophyIcon class="w-4 h-4 text-white" />
                                    </div>
                                    <h3 class="text-white font-semibold">Classements</h3>
                                </div>
                                <p class="text-white/70 text-sm">Découvrez les musiques et artistes les plus populaires
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <ChartBarIcon class="w-4 h-4 text-purple-400" />
                            Statistiques
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-4 border border-purple-400/30 text-center">
                                <div class="text-2xl font-bold text-white">1000+</div>
                                <div class="text-white/80 text-xs">Musiques</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl p-4 border border-blue-400/30 text-center">
                                <div class="text-2xl font-bold text-white">500+</div>
                                <div class="text-white/80 text-xs">Artistes</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl p-4 border border-green-400/30 text-center">
                                <div class="text-2xl font-bold text-white">200+</div>
                                <div class="text-white/80 text-xs">Playlists</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-xl p-4 border border-orange-400/30 text-center">
                                <div class="text-2xl font-bold text-white">50K+</div>
                                <div class="text-white/80 text-xs">Écoutes</div>
                            </div>
                        </div>
                    </section>

                    <!-- Liens légaux -->
                    <section class="glass rounded-2xl p-6 text-center">
                        <h2 class="text-lg font-bold text-white mb-4">
                            Informations légales
                        </h2>
                        <div class="flex flex-col gap-3">
                            <Link href="/legal"
                                class="bg-white/10 text-white px-4 py-2 rounded-xl font-semibold hover:bg-white/20 transition-colors text-sm">
                            Mentions légales
                            </Link>
                            <Link href="/privacy"
                                class="bg-white/10 text-white px-4 py-2 rounded-xl font-semibold hover:bg-white/20 transition-colors text-sm">
                            Politique de confidentialité
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
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import {
    MusicalNoteIcon,
    SpeakerWaveIcon,
    MagnifyingGlassIcon,
    BookOpenIcon,
    HeartIcon,
    UserGroupIcon,
    SparklesIcon,
    PaintBrushIcon,
    StarIcon,
    RocketLaunchIcon,
    TrophyIcon,
    PlayIcon,
    TagIcon,
    EyeIcon,
    ChartBarIcon
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

