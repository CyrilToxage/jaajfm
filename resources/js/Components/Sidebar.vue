<template>
    <aside class="w-64 bg-gradient-to-b from-cyan-500 to-purple-600 p-5 fixed h-full z-10 flex flex-col">
        <!-- Header avec photo de profil et pseudo centrés -->
        <div class="flex flex-col items-center mb-8">
            <!-- Photo de profil pour utilisateurs connectés -->
            <div v-if="$page.props.auth.user" class="mb-4">
                <Link href="/profile" class="block">
                <img v-if="$page.props.auth.user.profile_photo_url" :src="$page.props.auth.user.profile_photo_url"
                    :alt="$page.props.auth.user.name"
                    class="w-16 h-16 rounded-full object-cover border-2 border-white/30 hover:border-white/50 transition-colors cursor-pointer" />
                <div v-else
                    class="w-16 h-16 rounded-full bg-gray-700 border-2 border-white/30 flex items-center justify-center hover:border-white/50 transition-colors cursor-pointer">
                    <UserIcon class="w-8 h-8 text-white" />
                </div>
                </Link>
            </div>

            <!-- Avatar par défaut pour visiteurs -->
            <div v-else class="w-15 h-15 rounded-full bg-gray-700 mb-4 border-3 border-white/30"></div>

            <!-- Pseudo centré -->
            <div class="text-center">
                <Link v-if="$page.props.auth.user" href="/profile" class="block">
                <div class="font-semibold text-white hover:text-gray-200 transition-colors cursor-pointer">
                    {{ $page.props.auth.user.name }}
                </div>
                </Link>
                <div v-else class="font-semibold text-white">Bienvenue sur JaaJ FM</div>


            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1">
            <ul class="space-y-4">
                <!-- Pages publiques (toujours visibles) -->
                <li>
                    <Link href="/" class="nav-link" :class="{ 'active': $page.url === '/' }">
                    <HomeIcon class="w-5 h-5 mr-3" />
                    Accueil
                    </Link>
                </li>
                <li>
                    <Link href="/rankings" class="nav-link" :class="{ 'active': $page.url === '/rankings' }">
                    <TrophyIcon class="w-5 h-5 mr-3" />
                    Classements
                    </Link>
                </li>

                <!-- Pages privées (seulement si connecté) -->
                <template v-if="$page.props.auth.user">
                    <li>
                        <Link href="/create" class="nav-link" :class="{ 'active': $page.url === '/create' }">
                        <PlusIcon class="w-5 h-5 mr-3" />
                        Créer
                        </Link>
                    </li>
                    <li>
                        <Link href="/library" class="nav-link" :class="{ 'active': $page.url === '/library' }">
                        <BookOpenIcon class="w-5 h-5 mr-3" />
                        Bibliothèque
                        </Link>
                    </li>
                    <li>
                        <Link href="/subscriptions" class="nav-link"
                            :class="{ 'active': $page.url === '/subscriptions' }">
                        <UserGroupIcon class="w-5 h-5 mr-3" />
                        Abonnements
                        </Link>
                    </li>
                    <li>
                        <Link href="/playlists" class="nav-link" :class="{ 'active': $page.url === '/playlists' }">
                        <PlayIcon class="w-5 h-5 mr-3" />
                        Playlists
                        </Link>
                    </li>
                    <li>
                        <Link href="/likes" class="nav-link" :class="{ 'active': $page.url === '/likes' }">
                        <HeartIcon class="w-5 h-5 mr-3" />
                        Likes
                        </Link>
                    </li>
                    <li>
                        <Link href="/about" class="nav-link" :class="{ 'active': $page.url === '/about' }">
                        <InformationCircleIcon class="w-5 h-5 mr-3" />
                        À propos
                        </Link>
                    </li>
                    <!-- Lien Radio supprimé - déjà disponible via le bouton en haut à droite -->

                    <!-- Section Admin (seulement pour les admins) -->
                    <li v-if="$page.props.auth.user?.is_admin" class="pt-4 border-t border-white/20">
                        <div class="text-white/50 text-xs font-semibold mb-2 px-3">ADMINISTRATION</div>
                        <Link href="/admin" class="nav-link" :class="{ 'active': $page.url.startsWith('/admin') }">
                        <ShieldCheckIcon class="w-5 h-5 mr-3" />
                        Dashboard Admin
                        </Link>

                    </li>
                </template>

                <!-- Pages publiques pour visiteurs -->
                <template v-else>
                    <li>
                        <Link href="/about" class="nav-link" :class="{ 'active': $page.url === '/about' }">
                        <InformationCircleIcon class="w-5 h-5 mr-3" />
                        À propos
                        </Link>
                    </li>
                    <li class="pt-4 border-t border-white/20">
                        <Link href="/login" class="nav-link bg-white/20" :class="{ 'active': $page.url === '/login' }">
                        <UserIcon class="w-5 h-5 mr-3" />
                        Se connecter
                        </Link>
                    </li>
                    <li>
                        <Link href="/register" class="nav-link bg-gradient-to-r from-purple-500 to-pink-500"
                            :class="{ 'active': $page.url === '/register' }">
                        <UserPlusIcon class="w-5 h-5 mr-3" />
                        S'inscrire
                        </Link>
                    </li>
                </template>
            </ul>
        </nav>

        <!-- Boutons en bas (seulement si connecté) -->
        <div v-if="$page.props.auth.user" class="mt-auto pt-4 border-t border-white/20 space-y-2">
            <button @click="logout" class="nav-link w-full text-left bg-red-500/20 hover:bg-red-500/30">
                <ArrowRightOnRectangleIcon class="w-5 h-5 mr-3" />
                Se déconnecter
            </button>
        </div>
    </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import {
    HomeIcon,
    InformationCircleIcon,
    PlusIcon,
    BookOpenIcon,
    HeartIcon,
    PlayIcon,
    UserGroupIcon,
    UserIcon,
    UserPlusIcon,
    ArrowRightOnRectangleIcon,
    TrophyIcon,
    ShieldCheckIcon,

} from '@heroicons/vue/24/outline'

const logout = () => {
    router.post(route('logout'))
}


</script>

<style scoped>
.nav-link {
    @apply text-white text-lg font-medium px-4 py-3 rounded-lg flex items-center transition-all duration-300;
}

.nav-link:hover,
.nav-link.active {
    @apply bg-white/20 transform translate-x-1;
}
</style>
