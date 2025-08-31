<template>
    <section v-if="tracks.length > 0">
        <h2 class="section-title flex items-center gap-3">
            <component :is="icon" class="w-8 h-8" :class="iconColor" />
            {{ title }}
        </h2>
        <div class="music-grid">
            <MusicCard v-for="track in tracks" :key="track.id" :track="track" @play="handlePlay" @like="handleLike" @add-to-playlist="handleAddToPlaylist" />
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import MusicCard from '@/Components/MusicCard.vue'
import {
    FireIcon,
    CalendarIcon,
    SparklesIcon,
    MusicalNoteIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    tracks: {
        type: Array,
        default: () => []
    },
    type: {
        type: String,
        default: 'trending', // 'trending', 'new', 'category', 'search'
        validator: (value) => ['trending', 'new', 'category', 'search'].includes(value)
    }
})

const emit = defineEmits(['play', 'like', 'add-to-playlist'])

// Définir l'icône et la couleur selon le type
const icon = computed(() => {
    switch (props.type) {
        case 'trending':
            return FireIcon
        case 'new':
            return CalendarIcon
        case 'category':
            return SparklesIcon
        case 'search':
            return MusicalNoteIcon
        default:
            return MusicalNoteIcon
    }
})

const iconColor = computed(() => {
    switch (props.type) {
        case 'trending':
            return 'text-orange-400'
        case 'new':
            return 'text-green-400'
        case 'category':
            return 'text-purple-400'
        case 'search':
            return 'text-cyan-400'
        default:
            return 'text-cyan-400'
    }
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
