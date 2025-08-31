<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    MusicalNoteIcon,
    BookOpenIcon,
    HeartIcon,
    UserGroupIcon
} from '@heroicons/vue/24/outline'
import Sidebar from '@/Components/Sidebar.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => {
    form.post(route('register.post'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>

    <Head title="Inscription - JaaJ FM" />

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
                <div class="flex items-center justify-center min-h-screen">
                    <div class="w-full max-w-md">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-4xl font-bold text-white mb-2 flex items-center justify-center gap-2">
                                <MusicalNoteIcon class="w-8 h-8 text-purple-400" />
                                Inscription
                            </h1>
                            <p class="text-white/80">Rejoignez la communauté JaaJ FM</p>
                        </div>

                        <!-- Formulaire d'inscription -->
                        <div class="glass rounded-2xl p-8">
                            <form @submit.prevent="submit">
                                <!-- Nom -->
                                <div class="mb-6">
                                    <label for="name" class="block text-white font-medium mb-2">
                                        Nom complet
                                    </label>
                                    <input id="name" v-model="form.name" type="text"
                                        class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent"
                                        placeholder="Votre nom complet" required autofocus />
                                    <div v-if="form.errors.name" class="text-red-300 text-sm mt-1">
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-6">
                                    <label for="email" class="block text-white font-medium mb-2">
                                        Adresse email
                                    </label>
                                    <input id="email" v-model="form.email" type="email"
                                        class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent"
                                        placeholder="votre@email.com" required />
                                    <div v-if="form.errors.email" class="text-red-300 text-sm mt-1">
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <!-- Mot de passe -->
                                <div class="mb-6">
                                    <label for="password" class="block text-white font-medium mb-2">
                                        Mot de passe
                                    </label>
                                    <input id="password" v-model="form.password" type="password"
                                        class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent"
                                        placeholder="Votre mot de passe" required autocomplete="new-password" />
                                    <div v-if="form.errors.password" class="text-red-300 text-sm mt-1">
                                        {{ form.errors.password }}
                                    </div>
                                </div>

                                <!-- Confirmation du mot de passe -->
                                <div class="mb-6">
                                    <label for="password_confirmation" class="block text-white font-medium mb-2">
                                        Confirmer le mot de passe
                                    </label>
                                    <input id="password_confirmation" v-model="form.password_confirmation"
                                        type="password"
                                        class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent"
                                        placeholder="Confirmez votre mot de passe" required
                                        autocomplete="new-password" />
                                </div>

                                <!-- Conditions d'utilisation -->
                                <div class="mb-6">
                                    <label class="flex items-start">
                                        <input v-model="form.terms" type="checkbox"
                                            class="mt-1 rounded border-white/30 bg-white/20 text-purple-600 focus:ring-purple-400"
                                            required />
                                        <span class="ml-2 text-white/80 text-sm">
                                            J'accepte les
                                            <Link href="/terms" class="text-purple-300 hover:text-purple-200">
                                            conditions d'utilisation
                                            </Link>
                                            et la
                                            <Link href="/privacy" class="text-purple-300 hover:text-purple-200">
                                            politique de confidentialité
                                            </Link>
                                        </span>
                                    </label>
                                    <div v-if="form.errors.terms" class="text-red-300 text-sm mt-1">
                                        {{ form.errors.terms }}
                                    </div>
                                </div>

                                <!-- Bouton d'inscription -->
                                <button type="submit" :disabled="form.processing"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-transparent transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="form.processing">Inscription en cours...</span>
                                    <span v-else>Créer mon compte</span>
                                </button>
                            </form>

                            <!-- Séparateur -->
                            <div class="my-6 flex items-center">
                                <div class="flex-1 border-t border-white/20"></div>
                                <span class="px-4 text-white/60 text-sm">ou</span>
                                <div class="flex-1 border-t border-white/20"></div>
                            </div>

                            <!-- Lien de connexion -->
                            <div class="text-center">
                                <p class="text-white/80 text-sm">
                                    Déjà un compte ?
                                    <Link href="/login" class="text-purple-300 hover:text-purple-200 font-medium">
                                    Connectez-vous
                                    </Link>
                                </p>
                            </div>
                        </div>

                        <!-- Avantages de l'inscription -->
                        <div class="mt-6 glass rounded-xl p-4">
                            <h3 class="text-white font-semibold mb-3">✨ Avantages de l'inscription</h3>
                            <ul class="text-white/80 text-sm space-y-2">
                                <li class="flex items-center">
                                    <MusicalNoteIcon class="w-5 h-5 text-purple-300 mr-2" />
                                    Créer et partager votre musique
                                </li>
                                <li class="flex items-center">
                                    <BookOpenIcon class="w-5 h-5 text-purple-300 mr-2" />
                                    Bibliothèque personnelle
                                </li>
                                <li class="flex items-center">
                                    <HeartIcon class="w-5 h-5 text-purple-300 mr-2" />
                                    Likes et playlists
                                </li>
                                <li class="flex items-center">
                                    <UserGroupIcon class="w-5 h-5 text-purple-300 mr-2" />
                                    Suivre vos artistes préférés
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <div class="flex items-center justify-center min-h-[calc(100vh-120px)]">
                    <div class="w-full max-w-sm">
                        <!-- Header -->
                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-white mb-2 flex items-center justify-center gap-2">
                                <MusicalNoteIcon class="w-6 h-6 text-purple-400" />
                                Inscription
                            </h1>
                            <p class="text-white/80 text-sm">Rejoignez la communauté JaaJ FM</p>
                        </div>

                        <!-- Formulaire d'inscription -->
                        <div class="glass rounded-2xl p-6">
                            <form @submit.prevent="submit">
                                <!-- Nom -->
                                <div class="mb-4">
                                    <label for="name-mobile" class="block text-white font-medium mb-2 text-sm">
                                        Nom complet
                                    </label>
                                    <input id="name-mobile" v-model="form.name" type="text"
                                        class="w-full px-3 py-2 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-sm"
                                        placeholder="Votre nom complet" required autofocus />
                                    <div v-if="form.errors.name" class="text-red-300 text-xs mt-1">
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email-mobile" class="block text-white font-medium mb-2 text-sm">
                                        Adresse email
                                    </label>
                                    <input id="email-mobile" v-model="form.email" type="email"
                                        class="w-full px-3 py-2 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-sm"
                                        placeholder="votre@email.com" required />
                                    <div v-if="form.errors.email" class="text-red-300 text-xs mt-1">
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <!-- Mot de passe -->
                                <div class="mb-4">
                                    <label for="password-mobile" class="block text-white font-medium mb-2 text-sm">
                                        Mot de passe
                                    </label>
                                    <input id="password-mobile" v-model="form.password" type="password"
                                        class="w-full px-3 py-2 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-sm"
                                        placeholder="Votre mot de passe" required autocomplete="new-password" />
                                    <div v-if="form.errors.password" class="text-red-300 text-xs mt-1">
                                        {{ form.errors.password }}
                                    </div>
                                </div>

                                <!-- Confirmation du mot de passe -->
                                <div class="mb-4">
                                    <label for="password_confirmation-mobile"
                                        class="block text-white font-medium mb-2 text-sm">
                                        Confirmer le mot de passe
                                    </label>
                                    <input id="password_confirmation-mobile" v-model="form.password_confirmation"
                                        type="password"
                                        class="w-full px-3 py-2 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-sm"
                                        placeholder="Confirmez votre mot de passe" required
                                        autocomplete="new-password" />
                                </div>

                                <!-- Conditions d'utilisation -->
                                <div class="mb-4">
                                    <label class="flex items-start">
                                        <input v-model="form.terms" type="checkbox"
                                            class="mt-1 rounded border-white/30 bg-white/20 text-purple-600 focus:ring-purple-400"
                                            required />
                                        <span class="ml-2 text-white/80 text-xs">
                                            J'accepte les
                                            <Link href="/terms" class="text-purple-300 hover:text-purple-200">
                                            conditions d'utilisation
                                            </Link>
                                            et la
                                            <Link href="/privacy" class="text-purple-300 hover:text-purple-200">
                                            politique de confidentialité
                                            </Link>
                                        </span>
                                    </label>
                                    <div v-if="form.errors.terms" class="text-red-300 text-xs mt-1">
                                        {{ form.errors.terms }}
                                    </div>
                                </div>

                                <!-- Bouton d'inscription -->
                                <button type="submit" :disabled="form.processing"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-4 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-transparent transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                    <span v-if="form.processing">Inscription en cours...</span>
                                    <span v-else>Créer mon compte</span>
                                </button>
                            </form>

                            <!-- Séparateur -->
                            <div class="my-4 flex items-center">
                                <div class="flex-1 border-t border-white/20"></div>
                                <span class="px-3 text-white/60 text-xs">ou</span>
                                <div class="flex-1 border-t border-white/20"></div>
                            </div>

                            <!-- Lien de connexion -->
                            <div class="text-center">
                                <p class="text-white/80 text-xs">
                                    Déjà un compte ?
                                    <Link href="/login" class="text-purple-300 hover:text-purple-200 font-medium">
                                    Connectez-vous
                                    </Link>
                                </p>
                            </div>
                        </div>

                        <!-- Avantages de l'inscription -->
                        <div class="mt-4 glass rounded-xl p-4">
                            <h3 class="text-white font-semibold mb-3 text-sm">✨ Avantages de l'inscription</h3>
                            <ul class="text-white/80 text-xs space-y-2">
                                <li class="flex items-center">
                                    <MusicalNoteIcon class="w-4 h-4 text-purple-300 mr-2" />
                                    Créer et partager votre musique
                                </li>
                                <li class="flex items-center">
                                    <BookOpenIcon class="w-4 h-4 text-purple-300 mr-2" />
                                    Bibliothèque personnelle
                                </li>
                                <li class="flex items-center">
                                    <HeartIcon class="w-4 h-4 text-purple-300 mr-2" />
                                    Likes et playlists
                                </li>
                                <li class="flex items-center">
                                    <UserGroupIcon class="w-4 h-4 text-purple-300 mr-2" />
                                    Suivre vos artistes préférés
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

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
