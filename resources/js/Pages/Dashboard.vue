<template>

    <Head title="Tableau de bord - JaaJ FM" />

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
                        <h1 class="text-4xl font-bold text-white mb-2">Tableau de bord</h1>
                        <p class="text-white/90 text-lg">Bienvenue sur JaaJ FM</p>
                    </section>

                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4">Musiques</h3>
                            <p class="text-white/70">Gérez votre bibliothèque musicale</p>
                        </div>

                        <div class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4">Playlists</h3>
                            <p class="text-white/70">Créez et organisez vos playlists</p>
                        </div>

                        <div class="glass rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4">Radio</h3>
                            <p class="text-white/70">Écoutez la radio en direct</p>
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
                <div class="space-y-6">
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-4">
                        <h1 class="text-2xl font-bold text-white mb-2">Tableau de bord</h1>
                        <p class="text-white/90 text-sm">Bienvenue sur JaaJ FM</p>
                    </section>

                    <!-- Statistiques -->
                    <div class="space-y-4">
                        <div class="glass rounded-2xl p-4">
                            <h3 class="text-lg font-bold text-white mb-2">Musiques</h3>
                            <p class="text-white/70 text-sm">Gérez votre bibliothèque musicale</p>
                        </div>

                        <div class="glass rounded-2xl p-4">
                            <h3 class="text-lg font-bold text-white mb-2">Playlists</h3>
                            <p class="text-white/70 text-sm">Créez et organisez vos playlists</p>
                        </div>

                        <div class="glass rounded-2xl p-4">
                            <h3 class="text-lg font-bold text-white mb-2">Radio</h3>
                            <p class="text-white/70 text-sm">Écoutez la radio en direct</p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}
</style>
