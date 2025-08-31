<template>
    <section v-if="categories.length > 0">
        <h2 class="section-title flex items-center gap-3">
            <SparklesIcon class="w-8 h-8 text-purple-400" />
            Découvrir par Catégorie
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div v-for="category in categories" :key="category.id" @click="handleCategoryClick(category)"
                class="category-card" :style="{ '--category-color': category.color || '#8B5CF6' }">
                <div class="category-icon">
                    <MusicalNoteIcon class="w-8 h-8 mx-auto" />
                </div>
                <div class="category-name">{{ category.name }}</div>
                <div class="category-count">{{ category.musics_count || 0 }} musiques</div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { SparklesIcon, MusicalNoteIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['category-click'])

const handleCategoryClick = (category) => {
    emit('category-click', category)
}
</script>

<style scoped>
.section-title {
    @apply text-3xl font-bold text-white mb-5 drop-shadow-lg;
}

.category-card {
    @apply bg-white/15 backdrop-blur-lg rounded-2xl p-4 cursor-pointer transition-all duration-300 border border-white/20;
    background: linear-gradient(135deg, var(--category-color, #8B5CF6)20, rgba(255, 255, 255, 0.1));
}

.category-card:hover {
    @apply transform -translate-y-1 bg-white/25;
}

.category-icon {
    @apply text-4xl text-white mb-2 text-center;
}

.category-name {
    @apply text-white font-bold text-center mb-1;
}

.category-count {
    @apply text-white/80 text-sm text-center;
}
</style>
