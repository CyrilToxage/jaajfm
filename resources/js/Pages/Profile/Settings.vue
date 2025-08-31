<template>
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
            <!-- Sidebar personnalisée -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @search="handleSearch" @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu des paramètres -->
                <div class="space-y-8 mt-8 max-w-4xl mx-auto">
                    <!-- En-tête des paramètres -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-6 mb-6">
                            <div
                                class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                                <UserIcon class="w-10 h-10 text-white" />
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-white flex items-center gap-2">
                                    <UserIcon class="w-8 h-8 text-purple-400" />
                                    Paramètres du profil
                                </h1>
                                <p class="text-white/80 text-lg">Gérez vos informations personnelles</p>
                            </div>
                        </div>
                    </section>

                    <!-- Informations du profil -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <UserIcon class="w-6 h-6 text-blue-400" />
                            <h2 class="text-2xl font-bold text-white">Informations du profil</h2>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-xl p-6 border border-blue-400/20">
                            <form @submit.prevent="updateProfile" class="space-y-6">
                                <!-- Photo de profil -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Photo de profil</label>
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-16 h-16 rounded-full overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
                                            <img v-if="user.profile_photo_url" :src="user.profile_photo_url"
                                                :alt="user.name" class="w-full h-full object-cover">
                                            <div v-else class="w-full h-full flex items-center justify-center">
                                                <span class="text-white font-bold text-xl">{{ user.name.charAt(0)
                                                }}</span>
                                            </div>
                                        </div>
                                        <input type="file" @change="handlePhotoChange" accept="image/*"
                                            class="text-white">
                                    </div>
                                </div>

                                <!-- Nom -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Nom</label>
                                    <input v-model="form.name" type="text"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Email</label>
                                    <input v-model="form.email" type="email"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <!-- Bouton de sauvegarde -->
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                                        Sauvegarder les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!-- Changer le mot de passe -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <ShieldCheckIcon class="w-6 h-6 text-green-400" />
                            <h2 class="text-2xl font-bold text-white">Changer le mot de passe</h2>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-xl p-6 border border-green-400/20">
                            <form @submit.prevent="updatePassword" class="space-y-6">
                                <!-- Mot de passe actuel -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Mot de passe actuel</label>
                                    <input v-model="passwordForm.current_password" type="password"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <!-- Nouveau mot de passe -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Nouveau mot de passe</label>
                                    <input v-model="passwordForm.password" type="password"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <!-- Confirmation du nouveau mot de passe -->
                                <div>
                                    <label class="block text-white font-medium mb-2">Confirmer le nouveau mot de
                                        passe</label>
                                    <input v-model="passwordForm.password_confirmation" type="password"
                                        class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>

                                <!-- Bouton de sauvegarde -->
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-300">
                                        Changer le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!-- Sessions de navigateur -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <ComputerDesktopIcon class="w-6 h-6 text-blue-400" />
                            <h2 class="text-2xl font-bold text-white">Sessions de navigateur</h2>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-xl p-6 border border-blue-400/20">
                            <div class="space-y-4">
                                <p class="text-white/80">
                                    Gérez et déconnectez vos sessions actives sur d'autres navigateurs et appareils.
                                </p>

                                <div v-if="sessions && sessions.length > 0" class="space-y-3">
                                    <div v-for="session in sessions" :key="session.id"
                                        class="flex items-center justify-between p-4 bg-white/10 rounded-lg">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <ComputerDesktopIcon class="w-4 h-4 text-blue-400" />
                                                <span class="text-white font-medium">{{ session.agent.platform }}</span>
                                                <span v-if="session.agent.browser" class="text-white/70">- {{
                                                    session.agent.browser }}</span>
                                            </div>
                                            <div class="text-white/60 text-sm mt-1">
                                                {{ session.agent.ip_address }} • {{ formatDate(session.last_active) }}
                                            </div>
                                        </div>
                                        <button v-if="!session.is_current_device" @click="logoutOtherBrowserSessions"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors">
                                            Déconnecter
                                        </button>
                                        <span v-else class="text-green-400 text-sm font-medium">Cette session</span>
                                    </div>
                                </div>

                                <button @click="logoutOtherBrowserSessions"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    Déconnecter toutes les autres sessions
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Suppression de compte -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <ExclamationTriangleIcon class="w-6 h-6 text-red-400" />
                            <h2 class="text-2xl font-bold text-white">Suppression de compte</h2>
                        </div>
                        <div
                            class="bg-gradient-to-br from-red-500/10 to-pink-500/10 rounded-xl p-6 border border-red-400/20">
                            <div class="space-y-4">
                                <p class="text-white/80">
                                    Une fois votre compte supprimé, toutes ses ressources et données seront
                                    définitivement effacées. Avant de supprimer votre compte, veuillez télécharger
                                    toutes les données ou informations que vous souhaitez conserver.
                                </p>

                                <button @click="confirmUserDeletion"
                                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-lg hover:from-red-700 hover:to-pink-700 transition-all duration-300">
                                    Supprimer le compte
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden min-h-screen">
            <!-- Header mobile -->
            <MobileHeader @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu mobile -->
            <main class="p-4 relative">
                <!-- En-tête des paramètres -->
                <section class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <UserIcon class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                                <UserIcon class="w-6 h-6 text-purple-400" />
                                Paramètres
                            </h1>
                            <p class="text-white/80">Gérez votre profil</p>
                        </div>
                    </div>
                </section>

                <!-- Informations du profil -->
                <section class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <UserIcon class="w-5 h-5 text-blue-400" />
                        <h2 class="text-xl font-bold text-white">Informations du profil</h2>
                    </div>
                    <div
                        class="bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-xl p-4 border border-blue-400/20">
                        <form @submit.prevent="updateProfile" class="space-y-4">
                            <!-- Photo de profil -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Photo de profil</label>
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 rounded-full overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
                                        <img v-if="user.profile_photo_url" :src="user.profile_photo_url"
                                            :alt="user.name" class="w-full h-full object-cover">
                                        <div v-else class="w-full h-full flex items-center justify-center">
                                            <span class="text-white font-bold text-lg">{{ user.name.charAt(0) }}</span>
                                        </div>
                                    </div>
                                    <input type="file" @change="handlePhotoChange" accept="image/*"
                                        class="text-white text-sm">
                                </div>
                            </div>

                            <!-- Nom -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Nom</label>
                                <input v-model="form.name" type="text"
                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Email</label>
                                <input v-model="form.email" type="email"
                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>

                            <!-- Bouton de sauvegarde -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                    Sauvegarder
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Changer le mot de passe -->
                <section class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <ShieldCheckIcon class="w-5 h-5 text-green-400" />
                        <h2 class="text-xl font-bold text-white">Changer le mot de passe</h2>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-xl p-4 border border-green-400/20">
                        <form @submit.prevent="updatePassword" class="space-y-4">
                            <!-- Mot de passe actuel -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Mot de passe actuel</label>
                                <input v-model="passwordForm.current_password" type="password"
                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Nouveau mot de passe</label>
                                <input v-model="passwordForm.password" type="password"
                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>

                            <!-- Confirmation du nouveau mot de passe -->
                            <div>
                                <label class="block text-white font-medium mb-2 text-sm">Confirmer le nouveau mot de
                                    passe</label>
                                <input v-model="passwordForm.password_confirmation" type="password"
                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>

                            <!-- Bouton de sauvegarde -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-300 text-sm">
                                    Changer le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Sessions de navigateur -->
                <section class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <ComputerDesktopIcon class="w-5 h-5 text-blue-400" />
                        <h2 class="text-xl font-bold text-white">Sessions de navigateur</h2>
                    </div>
                    <div
                        class="bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-xl p-4 border border-blue-400/20">
                        <div class="space-y-4">
                            <p class="text-white/80 text-sm">
                                Gérez et déconnectez vos sessions actives sur d'autres navigateurs et appareils.
                            </p>

                            <div v-if="sessions && sessions.length > 0" class="space-y-3">
                                <div v-for="session in sessions" :key="session.id"
                                    class="flex items-center justify-between p-3 bg-white/10 rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <ComputerDesktopIcon class="w-4 h-4 text-blue-400" />
                                            <span class="text-white font-medium text-sm">{{ session.agent.platform
                                            }}</span>
                                            <span v-if="session.agent.browser" class="text-white/70 text-sm">- {{
                                                session.agent.browser }}</span>
                                        </div>
                                        <div class="text-white/60 text-xs mt-1">
                                            {{ session.agent.ip_address }} • {{ formatDate(session.last_active) }}
                                        </div>
                                    </div>
                                    <button v-if="!session.is_current_device" @click="logoutOtherBrowserSessions"
                                        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs transition-colors ml-2">
                                        Déconnecter
                                    </button>
                                    <span v-else class="text-green-400 text-xs font-medium ml-2">Cette session</span>
                                </div>
                            </div>

                            <button @click="logoutOtherBrowserSessions"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm">
                                Déconnecter toutes les autres sessions
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Suppression de compte -->
                <section class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <ExclamationTriangleIcon class="w-5 h-5 text-red-400" />
                        <h2 class="text-xl font-bold text-white">Suppression de compte</h2>
                    </div>
                    <div
                        class="bg-gradient-to-br from-red-500/10 to-pink-500/10 rounded-xl p-4 border border-red-400/20">
                        <div class="space-y-4">
                            <p class="text-white/80 text-sm">
                                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
                                effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou
                                informations que vous souhaitez conserver.
                            </p>

                            <button @click="confirmUserDeletion"
                                class="w-full px-4 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-lg hover:from-red-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                Supprimer le compte
                            </button>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <!-- Notification -->
        <div v-if="notification.show"
            class="fixed bottom-4 right-4 bg-white/90 backdrop-blur-lg rounded-lg p-4 shadow-lg border border-white/20 z-50">
            <p class="text-gray-800">{{ notification.message }}</p>
        </div>
    </div>
</template>

<script setup>
import { Head, usePage, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobileHeader from '@/Components/MobileHeader.vue'
import {
    UserIcon,
    ShieldCheckIcon,
    ComputerDesktopIcon,
    ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'

const page = usePage()

// Props pour les composants Jetstream
const props = defineProps({
    user: Object,
    sessions: Array,
    confirmsTwoFactorAuthentication: Boolean,
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

const user = ref(props.user || page.props.auth.user)

// Formulaires
const form = ref({
    name: user.value.name,
    email: user.value.email,
    photo: null
})

const passwordForm = ref({
    current_password: '',
    password: '',
    password_confirmation: ''
})

// Variables pour l'authentification à deux facteurs
const twoFactorEnabled = ref(props.user?.two_factor_secret ? true : false)

// Variables pour les sessions
const sessions = ref(props.sessions || [])

// Méthodes
const handleSearch = (query) => {
    router.get('/search', { q: query })
}

const handleLiveRadioToggle = (isPlaying) => {
    showNotification(isPlaying ? 'Connexion au Live Radio...' : 'Radio arrêtée')
}

const showNotification = (message, type = 'info') => {
    notification.value = {
        show: true,
        message: message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

const handlePhotoChange = (event) => {
    form.value.photo = event.target.files[0]
}

const updateProfile = async () => {
    try {
        const formData = new FormData()
        formData.append('name', form.value.name)
        formData.append('email', form.value.email)
        if (form.value.photo) {
            formData.append('photo', form.value.photo)
        }

        const response = await fetch('/profile/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })

        if (response.ok) {
            showNotification('Profil mis à jour avec succès !', 'success')
            // Recharger la page pour mettre à jour les données
            window.location.reload()
        } else {
            showNotification('Erreur lors de la mise à jour du profil', 'error')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors de la mise à jour du profil', 'error')
    }
}

const updatePassword = async () => {
    try {
        const response = await fetch('/profile/password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(passwordForm.value)
        })

        if (response.ok) {
            showNotification('Mot de passe mis à jour avec succès !', 'success')
            passwordForm.value = {
                current_password: '',
                password: '',
                password_confirmation: ''
            }
        } else {
            showNotification('Erreur lors de la mise à jour du mot de passe', 'error')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors de la mise à jour du mot de passe', 'error')
    }
}

// Fonctions pour l'authentification à deux facteurs
const enableTwoFactor = () => {
    // Utiliser la route POST pour activer
    router.post('/user/two-factor-authentication')
}

const disableTwoFactor = () => {
    if (confirm('Êtes-vous sûr de vouloir désactiver l\'authentification à deux facteurs ?')) {
        router.delete('/user/two-factor-authentication')
    }
}

const regenerateRecoveryCodes = () => {
    router.post('/user/two-factor-recovery-codes')
}

// Fonctions pour les sessions
const logoutOtherBrowserSessions = () => {
    if (confirm('Êtes-vous sûr de vouloir déconnecter toutes les autres sessions ?')) {
        router.delete('/user/other-browser-sessions')
    }
}

// Fonction pour la suppression de compte
const confirmUserDeletion = () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
        router.delete('/user')
    }
}

// Fonction utilitaire pour formater les dates
const formatDate = (dateString) => {
    if (!dateString) return 'Date inconnue'
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
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
