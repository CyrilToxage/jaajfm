<template>
    <!-- Header mobile -->
    <header
        class="md:hidden fixed top-0 left-0 right-0 z-40 bg-gradient-to-r from-purple-600 via-orange-500 to-cyan-500 border-b border-white/20 backdrop-blur-lg">
        <div class="flex items-center justify-between px-4 py-3">
            <!-- Logo JaaJ FM -->
            <div class="flex items-center cursor-pointer" @click="goHome">
                <svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 180 75"
                    style="enable-background:new 0 0 180 75;" xml:space="preserve" class="h-12 w-auto">
                    <g>
                        <defs>
                            <rect id="SVGID_1_" y="0" width="180" height="75" />
                        </defs>
                        <clipPath id="SVGID_00000059996360938322454710000015990677056596836762_">
                            <use xlink:href="#SVGID_1_" style="overflow:visible;" />
                        </clipPath>
                        <g style="clip-path:url(#SVGID_00000059996360938322454710000015990677056596836762_);">
                            <path fill="#FFFFFF" d="M115.5,27.3h14.3l0,3.5c-3.4,0.1-6.7,0.1-10.1,0l0,4.6c1.5-0.1,7.8-0.4,8.9,0.1l0.1,0.4l0,2.9c-3,0-6,0-9,0
                                l0,7.6c-1.4,0.1-2.8,0.1-4.2,0C115.4,40.2,115.4,33.7,115.5,27.3z" />
                            <path fill="#FFFFFF"
                                d="M134,27.3c1.2,0,2.4,0,3.6,0c0.8,1,1.5,2.2,2.2,3.3c1.3,2.1,2.6,4.3,3.8,6.4c2-3.1,3.9-6.3,5.7-9.6
                                c1.4,0,2.7,0,4.1,0l0,19.3c-1.4,0.1-2.8,0.1-4.1,0l0-8c0-1.5,0.1-3.1,0-4.6c-1.4,2.6-3.4,6.1-5.1,8.5c-0.4,0.2-0.8,0.2-1.3,0.2
                                c-1.9-2.8-3.5-5.8-5.3-8.7c0.2,4.2,0.1,8.4,0,12.7c-1.4,0.1-2.7,0-4.1,0c0-2.2-0.2-18.5,0.1-19.3L134,27.3z" />
                            <path fill="#FFFFFF" d="M6.7,22c1.9,0.2,3.9,0.1,5.8,0.1l10.9,0v16.8c0,3.1,0.2,6.3-0.1,9.3c-0.1,1.2-0.4,2.4-0.8,3.6
                                c-0.5,1.4-1.3,2.6-2.3,3.6c-1,1-2.2,1.8-3.5,2.4c-3.4,1.4-7.2,1.2-10.5-0.2c-2.5-1.3-4.3-3.3-6-5.5c1.6-1.6,3.4-3.1,5.1-4.6
                                c0.3,0.3,0.6,0.7,0.9,1c1.3,1.4,2.8,2.6,4.8,2.6c1.1,0,2.3-0.3,3.2-1.1c0.7-0.7,0.9-1.6,1.1-2.6c0.4-2.3,0.2-4.6,0.1-6.9l0-10.7
                                c-2.8,0.2-5.6,0.1-8.4,0L6.7,22z" />
                            <path fill="#FFFFFF" d="M91.1,22.2l18.3,0.1c0.1,5.1,0,10.3,0,15.4c0,3.3,0.2,6.7-0.1,10c-0.1,1.4-0.5,2.8-1,4.1
                                c-1.2,2.7-3.5,4.7-6.1,5.8c-3.7,1.4-7.5,1-11-0.6c-2.3-1.2-4-3-5.6-5.1c1.6-2,3.5-3.7,5.2-5.6c0.5,0.8,1.1,1.6,1.7,2.3
                                c1.2,1.4,2.8,2.3,4.7,2.3c0.9,0,1.9-0.2,2.5-0.9c0.7-0.7,0.9-1.6,1-2.5c0.3-2.1,0.1-4.4,0.1-6.6c0-3.8,0-7.5,0-11.3
                                c-3.2,0.1-6.5,0-9.7,0.1L91.1,22.2z" />
                            <path fill="#FFFFFF" d="M63.2,22c2.6,0.3,5.8,0.1,8.4,0.1c1.2,3.8,2.9,7.4,4.5,11l7.3,17.4c1.1,2.6,2.3,5.3,3.1,7.9l-7.3,0h-1.4
                                c-1.2-2.5-2.2-5.1-3.2-7.7c-4.5,0.1-9,0-13.5,0.1c-1.7-4.1-3.5-8.2-4.9-12.4C58.4,32.9,60.9,27.5,63.2,22z M67.2,32.1
                                c-1.6,3.7-3.1,7.6-4.5,11.5c1.6,0,3.1,0.1,4.7,0.1h4.3C71.1,42.1,67.7,32.6,67.2,32.1z" />
                            <path fill="#FFFFFF" d="M38.2,22c2.7,0.1,5.4,0.1,8.1,0.1c1,2.3,1.9,4.6,2.9,6.9c1.7,4.1,3.4,8.2,5.1,12.3c2.3,5.6,4.9,11.3,6.9,17
                                l-8.8,0c-1.1-2.5-2.1-5.1-3.1-7.6l-3.3,0H34.9c-0.9,2.6-2,5.1-3.1,7.6c-3,0-5.9,0-8.9,0.1c0.8-2.5,1.9-4.9,2.9-7.3
                                c1.6-3.8,3.1-7.5,4.7-11.2C33.2,33.9,35.5,27.9,38.2,22z M42,32.2c-1.3,3.8-3,7.5-4.4,11.3l4.3,0c1.5,0,3,0,4.4,0l-2.5-6.7
                                C43.3,35.3,42.8,33.6,42,32.2L42,32.2z" />
                        </g>
                    </g>
                </svg>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3">
                <!-- Recherche -->
                <button @click="openSearch" class="text-white hover:text-white/80 transition-colors">
                    <MagnifyingGlassIcon class="w-6 h-6" />
                </button>


            </div>
        </div>

        <!-- Barre de recherche (optionnelle) -->
        <div v-if="showSearch" class="px-4 pb-3">
            <div class="relative">
                <input v-model="searchQuery"
                       type="text"
                       placeholder="Rechercher des musiques, artistes..."
                       @keyup.enter="performSearch"
                       @input="onInputChange"
                       class="w-full bg-white/20 border border-white/30 rounded-lg px-4 py-2 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50" />
                <button @click="performSearch"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-white/60 hover:text-white transition-colors">
                    <MagnifyingGlassIcon class="w-5 h-5" />
                </button>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    initialQuery: {
        type: String,
        default: ''
    }
})

const showSearch = ref(false)
const searchQuery = ref(props.initialQuery || '')

const openSearch = () => {
    showSearch.value = !showSearch.value
    if (!showSearch.value) {
        searchQuery.value = ''
    }
}

let searchTimeout = null

const performSearch = () => {
    if (searchQuery.value.trim()) {
        // Si on est déjà sur la page de recherche, mettre à jour les paramètres
        if (window.location.pathname === '/search') {
            router.get('/search', { q: searchQuery.value.trim() }, {
                preserveState: true,
                replace: true
            })
        } else {
            // Sinon, naviguer vers la page de recherche
            router.visit('/search', { q: searchQuery.value.trim() })
        }
        showSearch.value = false
    }
}

const onInputChange = () => {
    // Recherche automatique après 500ms d'inactivité
    if (searchTimeout) {
        clearTimeout(searchTimeout)
    }

    if (searchQuery.value.trim()) {
        searchTimeout = setTimeout(() => {
            performSearch()
        }, 500)
    }
}

const goHome = () => {
    router.visit('/')
}
</script>
