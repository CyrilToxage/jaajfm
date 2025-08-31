<template>
    <section v-if="tracks.length > 0">
        <h2 class="section-title flex items-center gap-3">
            <MusicalNoteIcon class="w-8 h-8 text-purple-400" />
            {{ genreName }}
        </h2>
        <div class="music-grid">
            <MusicCard
                v-for="track in tracks"
                :key="track.id"
                :track="track"
                @play="handlePlay"
                @like="handleLike"
                @add-to-playlist="handleAddToPlaylist"
            />
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import MusicCard from '@/Components/MusicCard.vue'
import { MusicalNoteIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    genre: {
        type: Object,
        required: true
    },
    tracks: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['play', 'like', 'add-to-playlist'])

// Computed pour le nom du genre
const genreName = computed(() => {
    return `Musiques ${props.genre.name}`
})

const handlePlay = (track) => {
    emit('play', track)
}

const handleLike = (track) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    emit('like', track)
}

const handleAddToPlaylist = (musicId) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    emit('add-to-playlist', musicId)
}
</script>

<style scoped>
.section-title {
    @apply text-3xl font-bold text-white mb-5 drop-shadow-lg;
}

.music-grid {
    @apply grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5;
}
</style>
