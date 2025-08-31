<template>
    <div class="relative z-10">
        <!-- Sections de musiques -->
        <div class="space-y-10">
            <!-- Meilleures Musiques (Classement) -->
            <MusicSection title="Meilleures Musiques" :tracks="safePopularMusics" type="ranking" @play="playMusic"
                @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />

            <!-- Musiques Récentes -->
            <MusicSection title="Musiques Récentes" :tracks="safeRecentMusics" type="recent" @play="playMusic"
                @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />

            <!-- Musiques les Plus Likées -->
            <MusicSection title="Musiques les Plus Likées" :tracks="safeMostLikedMusics" type="most-liked"
                @play="playMusic" @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />

            <!-- Musiques les Plus Vues -->
            <MusicSection title="Musiques les Plus Vues" :tracks="safePopularMusics" type="most-viewed"
                @play="playMusic" @like="toggleLike" @add-to-playlist="handleAddToPlaylist" />

            <!-- Musiques par Genre -->
            <GenreMusicSection v-for="genre in safePopularGenres" :key="genre.id" :genre="genre"
                :tracks="safeMusicsByGenre[genre.id] || []" @play="playMusic" @like="toggleLike"
                @add-to-playlist="handleAddToPlaylist" />

            <!-- Message si pas de données -->
            <section
                v-if="safePopularMusics.length === 0 && safeRecentMusics.length === 0 && safeMostLikedMusics.length === 0 && Object.keys(safeMusicsByGenre).length === 0">
                <div class="text-center py-12">
                    <div class="flex justify-center mb-4">
                        <MusicalNoteIcon class="w-16 h-16 text-white/80" />
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Bienvenue sur JaaJ FM</h3>
                    <p class="text-white/80 mb-6">
                        Aucune musique disponible pour le moment...
                    </p>
                    <div class="text-white/60 text-sm">
                        Debug: popularMusics={{ safePopularMusics.length }},
                        recentMusics={{ safeRecentMusics.length }},
                        mostLikedMusics={{ safeMostLikedMusics.length }},
                        musicsByGenre={{ Object.keys(safeMusicsByGenre).length }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import MusicSection from '@/Components/MusicSection.vue'
import CategorySection from '@/Components/CategorySection.vue'
import GenreMusicSection from '@/Components/GenreMusicSection.vue'
import { MusicalNoteIcon } from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    popularMusics: {
        type: Array,
        default: () => []
    },
    recentMusics: {
        type: Array,
        default: () => []
    },
    mostLikedMusics: {
        type: Array,
        default: () => []
    },
    popularGenres: {
        type: Array,
        default: () => []
    },
    musicsByGenre: {
        type: Object,
        default: () => ({})
    },
})

// Emits
const emit = defineEmits(['play', 'like', 'add-to-playlist', 'notification'])

// Computed properties pour une meilleure gestion des données
const safePopularMusics = computed(() => {
    return Array.isArray(props.popularMusics) ? props.popularMusics : []
})
const safeRecentMusics = computed(() => {
    return Array.isArray(props.recentMusics) ? props.recentMusics : []
})
const safeMostLikedMusics = computed(() => {
    return Array.isArray(props.mostLikedMusics) ? props.mostLikedMusics : []
})
const safePopularGenres = computed(() => {
    return Array.isArray(props.popularGenres) ? props.popularGenres : []
})
const safeMusicsByGenre = computed(() => {
    return props.musicsByGenre || {}
})

// Méthodes
const playMusic = (track) => {
    emit('play', track)
}

const toggleLike = (track) => {
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

const navigateToCategory = (category) => {
    // Rediriger vers la page de recherche avec la catégorie pré-remplie
    router.get('/search', {
        category: category.name,
        category_id: category.id
    })
}
</script>
