<template>
    <!-- Actions rapides Mobile -->
    <section class="glass rounded-2xl p-4">
        <h2 class="text-lg font-bold text-white mb-4">Actions rapides</h2>
        <div class="grid grid-cols-2 gap-3">
            <Link :href="route('admin.users')"
                class="bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 rounded-xl p-4 text-center transition-all">
            <UsersIcon class="w-6 h-6 text-blue-400 mx-auto mb-2" />
            <div class="text-white font-semibold text-sm">Utilisateurs</div>
            </Link>
            <Link :href="route('admin.musics')"
                class="bg-green-500/20 hover:bg-green-500/30 border border-green-500/30 rounded-xl p-4 text-center transition-all">
            <MusicalNoteIcon class="w-6 h-6 text-green-400 mx-auto mb-2" />
            <div class="text-white font-semibold text-sm">Musiques</div>
            </Link>
            <Link :href="route('admin.reports')"
                class="bg-orange-500/20 hover:bg-orange-500/30 border border-orange-500/30 rounded-xl p-4 text-center transition-all">
            <ExclamationTriangleIcon class="w-6 h-6 text-orange-400 mx-auto mb-2" />
            <div class="text-white font-semibold text-sm">Signalements</div>
            </Link>
            <Link :href="route('admin.rankings')"
                class="bg-purple-500/20 hover:bg-purple-500/30 border border-purple-500/30 rounded-xl p-4 text-center transition-all">
            <TrophyIcon class="w-6 h-6 text-purple-400 mx-auto mb-2" />
            <div class="text-white font-semibold text-sm">Classements</div>
            </Link>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import {
    UsersIcon,
    MusicalNoteIcon,
    ExclamationTriangleIcon,
    TrophyIcon
} from '@heroicons/vue/24/outline'
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}
</style>
