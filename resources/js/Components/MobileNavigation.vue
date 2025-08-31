<template>
    <!-- Navigation mobile fixe en bas -->
    <div class="fixed bottom-0 left-0 right-0 z-50 md:hidden">
        <!-- Fond avec le même gradient que le popup -->
        <div class="bg-gradient-to-r from-cyan-500 to-purple-600 border-t border-white/20 backdrop-blur-lg">
            <!-- Navigation pour utilisateurs connectés -->
            <div v-if="auth?.user" class="flex justify-around items-center py-4 px-6">
                <!-- Accueil -->
                <button @click="navigateTo('/')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <HomeIcon class="w-6 h-6" />
                </button>

                <!-- Créer -->
                <button @click="navigateTo('/create')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/create' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <PlusIcon class="w-6 h-6" />
                </button>

                <!-- Menu Plus -->
                <button @click="toggleMenu" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    showMenu ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <Bars3Icon class="w-6 h-6" />
                </button>

                <!-- Bibliothèque -->
                <button @click="navigateTo('/library')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/library' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <BookOpenIcon class="w-6 h-6" />
                </button>

                <!-- Profil -->
                <button @click="navigateTo('/profile')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url.startsWith('/profile') ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <UserIcon class="w-6 h-6" />
                </button>
            </div>

            <!-- Navigation pour visiteurs -->
            <div v-else class="flex justify-around items-center py-4 px-6">
                <!-- Accueil -->
                <button @click="navigateTo('/')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <HomeIcon class="w-6 h-6" />
                </button>

                <!-- Classements -->
                <button @click="navigateTo('/rankings')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/rankings' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <TrophyIcon class="w-6 h-6" />
                </button>

                <!-- Menu Plus -->
                <button @click="toggleMenu" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    showMenu ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <Bars3Icon class="w-6 h-6" />
                </button>

                <!-- À propos -->
                <button @click="navigateTo('/about')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/about' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <InformationCircleIcon class="w-6 h-6" />
                </button>

                <!-- Connexion -->
                <button @click="navigateTo('/login')" :class="[
                    'flex items-center justify-center transition-all duration-300 w-12 h-12 rounded-lg',
                    $page.url === '/login' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'
                ]">
                    <UserIcon class="w-6 h-6" />
                </button>
            </div>
        </div>

        <!-- Menu déroulant pour les éléments supplémentaires -->
        <div v-if="showMenu" class="fixed inset-0 bg-black/50 z-40 md:hidden" @click="closeMenu">
            <div class="absolute bottom-20 left-4 right-4 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl p-4 border border-white/20 backdrop-blur-lg"
                @click.stop>
                <div class="grid grid-cols-2 gap-3">
                    <!-- Classements -->
                    <button @click="navigateTo('/rankings')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300">
                        <TrophyIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Classements</span>
                    </button>

                    <!-- Abonnements -->
                    <button v-if="auth?.user" @click="navigateTo('/subscriptions')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300">
                        <UserGroupIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Abonnements</span>
                    </button>

                    <!-- Playlists -->
                    <button v-if="auth?.user" @click="navigateTo('/playlists')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300">
                        <PlayIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Playlists</span>
                    </button>

                    <!-- Likes -->
                    <button v-if="auth?.user" @click="navigateTo('/likes')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300">
                        <HeartIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Likes</span>
                    </button>

                    <!-- À propos -->
                    <button @click="navigateTo('/about')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300">
                        <InformationCircleIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">À propos</span>
                    </button>

                    <!-- Radio Live supprimé - déjà disponible via le bouton en haut à droite -->

                    <!-- Se connecter (pour visiteurs) -->
                    <button v-if="!auth?.user" @click="navigateTo('/login')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-white/20 hover:bg-white/30 transition-all duration-300">
                        <UserIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Se connecter</span>
                    </button>

                    <!-- S'inscrire (pour visiteurs) -->
                    <button v-if="!auth?.user" @click="navigateTo('/register')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                        <UserPlusIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">S'inscrire</span>
                    </button>

                    <!-- Admin (pour administrateurs) -->
                    <button v-if="auth?.user?.is_admin" @click="navigateTo('/admin')"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-yellow-500/20 hover:bg-yellow-500/30 transition-all duration-300">
                        <ShieldCheckIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Admin</span>
                    </button>

                    <!-- Se déconnecter (pour utilisateurs connectés) -->
                    <button v-if="auth?.user" @click="logout"
                        class="flex flex-col items-center space-y-1 p-3 rounded-lg bg-red-500/20 hover:bg-red-500/30 transition-all duration-300">
                        <ArrowRightOnRectangleIcon class="w-6 h-6 text-white" />
                        <span class="text-xs font-medium text-white">Déconnexion</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import {
    HomeIcon,
    PlusIcon,
    BookOpenIcon,
    UserGroupIcon,
    UserIcon,
    Bars3Icon,
    TrophyIcon,
    PlayIcon,
    HeartIcon,
    InformationCircleIcon,
    UserPlusIcon,
    ArrowRightOnRectangleIcon,
    ShieldCheckIcon
} from '@heroicons/vue/24/outline'

const $page = usePage()
const auth = $page.props.auth
const showMenu = ref(false)

const navigateTo = (url) => {
    router.visit(url)
    showMenu.value = false
}

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}

const closeMenu = () => {
    showMenu.value = false
}

const logout = () => {
    router.post(route('logout'))
    showMenu.value = false
}
</script>

<style scoped>
/* Animation pour les boutons actifs */
button:active {
    transform: scale(0.95);
}
</style>
