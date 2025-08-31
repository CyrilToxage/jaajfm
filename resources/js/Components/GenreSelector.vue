<template>
    <div class="space-y-6">
        <div>
            <label class="block text-white font-medium mb-3">Genres musicaux</label>
            <p class="text-white/60 text-sm mb-4">Sélectionnez un ou plusieurs genres pour votre musique</p>
        </div>

        <!-- Version Desktop - Grille en colonnes -->
        <div class="hidden md:block">
            <div class="columns-4 gap-4">
                <div v-for="genre in mainGenres" :key="genre.id" class="genre-card mb-4 break-inside-avoid"
                    :class="{ 'selected': selectedGenres.includes(genre.id) }" @click="toggleGenreSelection(genre.id)">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-5 h-5 rounded-full" :style="{ backgroundColor: genre.color }"></div>
                            <span class="text-white font-medium">{{ genre.name }}</span>
                        </div>

                        <!-- Indicateur de sélection -->
                        <div v-if="selectedGenres.includes(genre.id)"
                            class="w-5 h-5 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Sous-genres -->
                    <div v-if="genre.children && genre.children.length > 0" class="space-y-2">
                        <div v-for="subGenre in genre.children" :key="subGenre.id" class="sub-genre-card"
                            :class="{ 'selected': selectedGenres.includes(subGenre.id) }"
                            @click.stop="toggleGenreSelection(subGenre.id)">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full" :style="{ backgroundColor: subGenre.color }">
                                    </div>
                                    <span class="text-white/80 text-sm">{{ subGenre.name }}</span>
                                </div>

                                <!-- Indicateur de sélection pour sous-genre -->
                                <div v-if="selectedGenres.includes(subGenre.id)"
                                    class="w-4 h-4 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Sous-sous-genres -->
                            <div v-if="subGenre.children && subGenre.children.length > 0" class="mt-2 ml-4 space-y-1">
                                <div v-for="subSubGenre in subGenre.children" :key="subSubGenre.id"
                                    class="sub-sub-genre-card"
                                    :class="{ 'selected': selectedGenres.includes(subSubGenre.id) }"
                                    @click.stop="toggleGenreSelection(subSubGenre.id)">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 rounded-full"
                                                :style="{ backgroundColor: subSubGenre.color }"></div>
                                            <span class="text-white/70 text-xs">{{ subSubGenre.name }}</span>
                                        </div>

                                        <!-- Indicateur de sélection pour sous-sous-genre -->
                                        <div v-if="selectedGenres.includes(subSubGenre.id)"
                                            class="w-3 h-3 bg-purple-500 rounded-full flex items-center justify-center">
                                            <svg class="w-1.5 h-1.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version Mobile - Grille responsive -->
        <div class="md:hidden">
            <div class="grid grid-cols-2 gap-3">
                <div v-for="genre in mainGenres" :key="genre.id" class="mobile-genre-card"
                    :class="{ 'selected': selectedGenres.includes(genre.id) }" @click="toggleGenreSelection(genre.id)">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: genre.color }"></div>
                            <span class="text-white font-medium text-sm">{{ genre.name }}</span>
                        </div>

                        <!-- Indicateur de sélection -->
                        <div v-if="selectedGenres.includes(genre.id)"
                            class="w-4 h-4 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Sous-genres (version mobile compacte) -->
                    <div v-if="genre.children && genre.children.length > 0" class="space-y-1">
                        <div v-for="subGenre in genre.children" :key="subGenre.id" class="mobile-sub-genre-card"
                            :class="{ 'selected': selectedGenres.includes(subGenre.id) }"
                            @click.stop="toggleGenreSelection(subGenre.id)">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-1.5">
                                    <div class="w-2.5 h-2.5 rounded-full" :style="{ backgroundColor: subGenre.color }">
                                    </div>
                                    <span class="text-white/80 text-xs">{{ subGenre.name }}</span>
                                </div>

                                <!-- Indicateur de sélection pour sous-genre -->
                                <div v-if="selectedGenres.includes(subGenre.id)"
                                    class="w-3 h-3 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-1.5 h-1.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genres sélectionnés -->
        <div v-if="selectedGenres.length > 0" class="mt-6">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-white font-medium text-sm md:text-base">Genres sélectionnés ({{ selectedGenres.length
                }})</h4>
                <button @click="clearSelection"
                    class="text-white/60 hover:text-white text-xs md:text-sm transition-colors">
                    Tout effacer
                </button>
            </div>
            <div class="flex flex-wrap gap-2">
                <div v-for="genreId in selectedGenres" :key="genreId" class="selected-genre-tag" :style="{
                    backgroundColor: getGenreById(genreId)?.color + '20',
                    borderColor: getGenreById(genreId)?.color + '40'
                }">
                    <div class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full mr-1.5 md:mr-2"
                        :style="{ backgroundColor: getGenreById(genreId)?.color }"></div>
                    <span class="text-xs md:text-sm font-medium" :style="{ color: getGenreById(genreId)?.color }">
                        {{ getGenreById(genreId)?.name }}
                    </span>
                    <button @click="removeGenre(genreId)"
                        class="ml-1.5 md:ml-2 hover:bg-white/20 rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center transition-colors"
                        :style="{ color: getGenreById(genreId)?.color }">
                        ×
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['update:modelValue'])

const mainGenres = ref([])
const selectedGenres = ref(props.modelValue)

// Charger les genres depuis l'API
const loadGenres = async () => {
    try {
        const response = await fetch('/api/genres')
        const data = await response.json()
        if (data.success) {
            mainGenres.value = data.genres
        }
    } catch (error) {
        console.error('Erreur lors du chargement des genres:', error)
    }
}

// Trouver un genre par son ID
const getGenreById = (id) => {
    const findGenre = (genres, targetId) => {
        for (const genre of genres) {
            if (genre.id === targetId) return genre
            if (genre.children) {
                const found = findGenre(genre.children, targetId)
                if (found) return found
            }
        }
        return null
    }

    return findGenre(mainGenres.value, id)
}

// Fonction pour trouver tous les parents d'un genre
const getAllParents = (genreId) => {
    const parents = []
    const findParents = (id) => {
        const genre = getGenreById(id)
        if (genre && genre.parent_id) {
            parents.push(genre.parent_id)
            findParents(genre.parent_id)
        }
    }
    findParents(genreId)
    return parents
}

// Fonction pour trouver tous les enfants d'un genre
const getAllChildren = (genreId) => {
    const children = []
    const findChildren = (id) => {
        const genre = getGenreById(id)
        if (genre && genre.children) {
            genre.children.forEach(child => {
                children.push(child.id)
                findChildren(child.id)
            })
        }
    }
    findChildren(genreId)
    return children
}

// Basculer la sélection d'un genre
const toggleGenreSelection = (genreId) => {
    const index = selectedGenres.value.indexOf(genreId)
    if (index > -1) {
        // Désélectionner le genre
        selectedGenres.value.splice(index, 1)

        // Désélectionner aussi tous ses enfants
        const children = getAllChildren(genreId)
        children.forEach(childId => {
            const childIndex = selectedGenres.value.indexOf(childId)
            if (childIndex > -1) {
                selectedGenres.value.splice(childIndex, 1)
            }
        })
    } else {
        // Sélectionner le genre
        selectedGenres.value.push(genreId)

        // Sélectionner automatiquement tous les parents
        const parents = getAllParents(genreId)
        parents.forEach(parentId => {
            if (!selectedGenres.value.includes(parentId)) {
                selectedGenres.value.push(parentId)
            }
        })
    }
    emit('update:modelValue', selectedGenres.value)
}

// Supprimer un genre
const removeGenre = (genreId) => {
    const index = selectedGenres.value.indexOf(genreId)
    if (index > -1) {
        selectedGenres.value.splice(index, 1)
        emit('update:modelValue', selectedGenres.value)
    }
}

// Effacer toute la sélection
const clearSelection = () => {
    selectedGenres.value = []
    emit('update:modelValue', selectedGenres.value)
}

// Surveiller les changements de la prop modelValue
watch(() => props.modelValue, (newValue) => {
    selectedGenres.value = newValue
})

// Charger les genres au montage
onMounted(() => {
    loadGenres()
})
</script>

<style scoped>
.genre-card {
    @apply border border-white/10 rounded-lg p-4 transition-all duration-200 cursor-pointer;
    @apply hover:border-white/20 hover:bg-white/5;
    @apply hover:shadow-lg hover:shadow-purple-500/10;
}

.genre-card.selected {
    @apply border-purple-500/50 bg-purple-500/10;
    @apply shadow-lg shadow-purple-500/20;
}

.sub-genre-card {
    @apply border border-white/5 rounded-md p-2 transition-all duration-200 cursor-pointer;
    @apply hover:border-white/20 hover:bg-white/5;
}

.sub-genre-card.selected {
    @apply border-purple-500/30 bg-purple-500/5;
}

.sub-sub-genre-card {
    @apply border border-white/5 rounded-sm p-1.5 transition-all duration-200 cursor-pointer;
    @apply hover:border-white/20 hover:bg-white/5;
}

.sub-sub-genre-card.selected {
    @apply border-purple-500/30 bg-purple-500/5;
}

.selected-genre-tag {
    @apply inline-flex items-center px-3 py-2 rounded-full border-2;
    @apply transition-all duration-200 hover:scale-105;
}

.mobile-genre-card {
    @apply border border-white/10 rounded-lg p-3 transition-all duration-200 cursor-pointer;
    @apply hover:border-white/20 hover:bg-white/5;
    @apply hover:shadow-lg hover:shadow-purple-500/10;
}

.mobile-genre-card.selected {
    @apply border-purple-500/50 bg-purple-500/10;
    @apply shadow-lg shadow-purple-500/20;
}

.mobile-sub-genre-card {
    @apply border border-white/5 rounded-md p-1.5 transition-all duration-200 cursor-pointer;
    @apply hover:border-white/20 hover:bg-white/5;
}

.mobile-sub-genre-card.selected {
    @apply border-purple-500/30 bg-purple-500/5;
}
</style>
