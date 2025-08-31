<template>

    <Head title="Créer - JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Section Upload -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <FolderIcon class="w-6 h-6 text-blue-400" />
                            Uploadez votre musique
                        </h2>

                        <!-- Zone de drop -->
                        <div @drop.prevent="handleFileDrop" @dragover.prevent="isDragOver = true"
                            @dragleave.prevent="isDragOver = false" @click="triggerFileInput" :class="[
                                'border-2 border-dashed rounded-xl p-8 text-center transition-colors cursor-pointer mb-8',
                                isDragOver ? 'border-purple-400 bg-purple-500/10' : 'border-white/30 hover:border-white/50'
                            ]">
                            <MusicalNoteIcon class="w-16 h-16 text-purple-400 mb-4" />
                            <h3 class="text-xl font-semibold text-white mb-2">
                                {{ selectedFile ? selectedFile.name : 'Glissez votre fichier audio' }}
                            </h3>
                            <p class="text-white/80 mb-4">
                                {{ selectedFile ? 'Fichier sélectionné' : 'ou cliquez pour sélectionner' }}
                            </p>
                            <button @click.stop="triggerFileInput"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300">
                                {{ selectedFile ? 'Changer de fichier' : 'Choisir un fichier' }}
                            </button>
                            <p class="text-white/60 text-sm mt-4">
                                Formats supportés: MP3, WAV, FLAC (max 50MB)
                            </p>

                            <!-- Input file caché -->
                            <input ref="fileInput" type="file" accept=".mp3,.wav,.flac" @change="handleFileSelect"
                                class="hidden">
                        </div>

                        <!-- Informations du fichier -->
                        <div class="bg-white/10 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                                <ClipboardDocumentIcon class="w-5 h-5 text-blue-400" />
                                Informations
                            </h3>
                            <div class="space-y-4">
                                <!-- Section image de cover et informations -->
                                <div class="flex gap-6">
                                    <!-- Aperçu de l'image à gauche -->
                                    <div class="flex-shrink-0">
                                        <label class="block text-white font-medium mb-2">Image de cover
                                            (optionnel)</label>

                                        <!-- Aperçu de l'image -->
                                        <div class="mb-4">
                                            <div v-if="coverPreview"
                                                class="w-64 h-64 rounded-lg overflow-hidden bg-white/20 flex-shrink-0 shadow-lg">
                                                <img :src="coverPreview" alt="Preview"
                                                    class="w-full h-full object-cover" />
                                            </div>
                                            <div v-else
                                                class="w-64 h-64 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 shadow-lg border-2 border-dashed border-white/30">
                                                <div class="text-center">
                                                    <span class="text-white/60 text-sm block">Aucune image</span>
                                                    <span class="text-white/40 text-xs block mt-1">Cliquez ci-dessous
                                                        pour ajouter</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bouton de sélection -->
                                        <div>
                                            <input ref="coverInput" type="file" accept="image/*"
                                                @change="handleCoverSelect" class="hidden" />
                                            <button type="button" @click="$refs.coverInput.click()"
                                                class="w-full px-4 py-3 text-sm border border-white/30 rounded-lg bg-white/90 text-gray-800 hover:bg-white/100 focus:outline-none focus:ring-2 focus:ring-purple-400 transition-colors">
                                                Choisir une image
                                            </button>
                                            <p class="text-white/60 text-xs mt-2 text-center">
                                                Formats: JPEG, PNG, GIF (max 2MB)
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Informations à droite -->
                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <label class="block text-white font-medium mb-2">Titre</label>
                                            <input v-model="formData.title" type="text"
                                                placeholder="Nom de votre musique"
                                                class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400">
                                        </div>
                                        <div>
                                            <label class="block text-white font-medium mb-2">Description</label>
                                            <textarea v-model="formData.description"
                                                placeholder="Décrivez votre musique..." rows="8"
                                                class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 resize-none"></textarea>
                                        </div>
                                        <div>
                                            <label class="flex items-center gap-3 mb-2">
                                                <input type="checkbox" v-model="formData.is_ai_generated"
                                                    class="w-4 h-4 text-purple-600 bg-white/90 border-white/30 rounded focus:ring-2 focus:ring-purple-400" />
                                                <span class="text-white font-medium">Musique générée par IA</span>
                                            </label>
                                            <p class="text-white/60 text-sm ml-7">
                                                Cochez cette case si votre musique a été créée avec l'aide de
                                                l'intelligence artificielle
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sélecteur de genres -->
                                <GenreSelector v-model="formData.genre_ids" />

                                <!-- Messages d'erreur -->
                                <div v-if="errors?.upload" class="text-red-400 text-sm mb-3">
                                    {{ errors.upload }}
                                </div>

                                <!-- Bouton d'upload -->
                                <button @click="uploadMusic" :disabled="!selectedFile || !formData.title"
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    {{ isUploading ? 'Upload en cours...' : 'Uploader la musique' }}
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Notification -->
        <div v-if="notification.show"
            class="fixed top-5 right-5 bg-gradient-to-r from-purple-600 to-cyan-500 text-white px-5 py-4 rounded-xl z-50 font-bold shadow-lg transform transition-transform duration-300"
            :class="notification.show ? 'translate-x-0' : 'translate-x-full'">
            {{ notification.message }}
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <!-- Contenu -->
                <div class="space-y-6">
                    <!-- Section Upload -->
                    <section class="glass rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <FolderIcon class="w-5 h-5 text-blue-400" />
                            Uploadez votre musique
                        </h2>

                        <!-- Zone de drop -->
                        <div @drop.prevent="handleFileDrop" @dragover.prevent="isDragOver = true"
                            @dragleave.prevent="isDragOver = false" @click="triggerFileInput" :class="[
                                'border-2 border-dashed rounded-xl p-6 text-center transition-colors cursor-pointer mb-6',
                                isDragOver ? 'border-purple-400 bg-purple-500/10' : 'border-white/30 hover:border-white/50'
                            ]">
                            <MusicalNoteIcon class="w-12 h-12 text-purple-400 mb-3" />
                            <h3 class="text-lg font-semibold text-white mb-2">
                                {{ selectedFile ? selectedFile.name : 'Glissez votre fichier audio' }}
                            </h3>
                            <p class="text-white/80 mb-3">
                                {{ selectedFile ? 'Fichier sélectionné' : 'ou cliquez pour sélectionner' }}
                            </p>
                            <button @click.stop="triggerFileInput"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm">
                                {{ selectedFile ? 'Changer de fichier' : 'Choisir un fichier' }}
                            </button>
                            <p class="text-white/60 text-xs mt-3">
                                Formats supportés: MP3, WAV, FLAC (max 50MB)
                            </p>

                            <!-- Input file caché -->
                            <input ref="fileInput" type="file" accept=".mp3,.wav,.flac" @change="handleFileSelect"
                                class="hidden">
                        </div>

                        <!-- Informations du fichier -->
                        <div class="bg-white/10 rounded-xl p-4">
                            <h3 class="text-base font-semibold text-white mb-3 flex items-center gap-2">
                                <ClipboardDocumentIcon class="w-4 h-4 text-blue-400" />
                                Informations
                            </h3>
                            <div class="space-y-4">
                                <!-- Aperçu de l'image -->
                                <div>
                                    <label class="block text-white font-medium mb-2 text-sm">Image de cover
                                        (optionnel)</label>
                                    <div class="mb-3">
                                        <div v-if="coverPreview"
                                            class="w-full h-48 rounded-lg overflow-hidden bg-white/20 flex-shrink-0 shadow-lg">
                                            <img :src="coverPreview" alt="Preview" class="w-full h-full object-cover" />
                                        </div>
                                        <div v-else
                                            class="w-full h-48 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 shadow-lg border-2 border-dashed border-white/30">
                                            <div class="text-center">
                                                <span class="text-white/60 text-sm block">Aucune image</span>
                                                <span class="text-white/40 text-xs block mt-1">Cliquez ci-dessous pour
                                                    ajouter</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de sélection -->
                                    <div>
                                        <input ref="coverInput" type="file" accept="image/*" @change="handleCoverSelect"
                                            class="hidden" />
                                        <button type="button" @click="$refs.coverInput.click()"
                                            class="w-full px-3 py-2 text-sm border border-white/30 rounded-lg bg-white/90 text-gray-800 hover:bg-white/100 focus:outline-none focus:ring-2 focus:ring-purple-400 transition-colors">
                                            Choisir une image
                                        </button>
                                        <p class="text-white/60 text-xs mt-1 text-center">
                                            Formats: JPEG, PNG, GIF (max 2MB)
                                        </p>
                                    </div>
                                </div>

                                <!-- Informations -->
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-white font-medium mb-1 text-sm">Titre</label>
                                        <input v-model="formData.title" type="text" placeholder="Nom de votre musique"
                                            class="w-full px-3 py-2 rounded-lg bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white font-medium mb-1 text-sm">Description</label>
                                        <textarea v-model="formData.description"
                                            placeholder="Description de votre musique" rows="3"
                                            class="w-full px-3 py-2 rounded-lg bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm resize-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-white font-medium mb-1 text-sm">Genres</label>
                                        <GenreSelector v-model="formData.genre_ids" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input v-model="formData.is_ai_generated" type="checkbox" id="ai-generated"
                                            class="w-4 h-4 text-purple-600 bg-white/90 border-white/30 rounded focus:ring-purple-400">
                                        <label for="ai-generated" class="text-white text-sm">
                                            Musique générée par IA
                                        </label>
                                    </div>
                                </div>

                                <!-- Bouton d'upload -->
                                <button @click="uploadMusic" :disabled="!selectedFile || isUploading" :class="[
                                    'w-full py-3 rounded-xl font-semibold transition-all duration-300 text-sm',
                                    selectedFile && !isUploading
                                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-700 hover:to-pink-700'
                                        : 'bg-gray-500 text-gray-300 cursor-not-allowed'
                                ]">
                                    <span v-if="isUploading">Upload en cours...</span>
                                    <span v-else>Uploader la musique</span>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import GenreSelector from '@/Components/GenreSelector.vue'
import {
    FolderIcon,
    MusicalNoteIcon,
    ClipboardDocumentIcon
} from '@heroicons/vue/24/outline'

// État réactif
const notification = ref({
    show: false,
    message: ''
})

const selectedFile = ref(null)
const coverFile = ref(null)
const coverPreview = ref(null)
const isDragOver = ref(false)
const isUploading = ref(false)
const fileInput = ref(null)
const coverInput = ref(null)

const formData = ref({
    title: '',
    description: '',
    genre_ids: [],
    is_ai_generated: false
})

// Méthodes
const handleLiveRadioToggle = (isPlaying) => {
    showNotification(isPlaying ? 'Connexion au Live Radio...' : 'Radio arrêtée', 'radio')
}

const showNotification = (message, type = 'info') => {
    let icon = ''
    switch (type) {
        case 'success':
            icon = '✓ '
            break
        case 'error':
            icon = '✗ '
            break
        case 'warning':
            icon = '⚠ '
            break
        case 'music':
            icon = '♪ '
            break
        case 'radio':
            icon = '📻 '
            break
        default:
            icon = 'ℹ '
    }

    notification.value = {
        show: true,
        message: icon + message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

const triggerFileInput = () => {
    fileInput.value.click()
}

const handleFileSelect = (event) => {
    const file = event.target.files[0]
    if (file) {
        validateAndSetFile(file)
    }
}

const handleFileDrop = (event) => {
    isDragOver.value = false
    const file = event.dataTransfer.files[0]
    if (file) {
        validateAndSetFile(file)
    }
}

const validateAndSetFile = (file) => {
    // Vérifier le type de fichier
    const allowedTypes = ['audio/mp3', 'audio/wav', 'audio/flac', 'audio/mpeg']
    const allowedExtensions = ['.mp3', '.wav', '.flac']

    const fileExtension = '.' + file.name.split('.').pop().toLowerCase()

    if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
        showNotification('Format de fichier non supporté. Utilisez MP3, WAV ou FLAC.', 'error')
        return
    }

    // Vérifier la taille (50MB max)
    const maxSize = 50 * 1024 * 1024 // 50MB en bytes
    if (file.size > maxSize) {
        showNotification('Fichier trop volumineux. Taille maximum: 50MB.', 'error')
        return
    }

    selectedFile.value = file
    showNotification('Fichier sélectionné: ' + file.name, 'success')
}

const handleCoverSelect = (event) => {
    const file = event.target.files[0]
    if (file) {
        // Vérifier le type de fichier
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']
        if (!allowedTypes.includes(file.type)) {
            showNotification('Format d\'image non supporté. Utilisez JPEG, PNG ou GIF.', 'error')
            return
        }

        // Vérifier la taille (2MB max)
        const maxSize = 2 * 1024 * 1024 // 2MB en bytes
        if (file.size > maxSize) {
            showNotification('Image trop volumineuse. Taille maximum: 2MB.', 'error')
            return
        }

        coverFile.value = file
        const reader = new FileReader()
        reader.onload = (e) => {
            coverPreview.value = e.target.result
        }
        reader.readAsDataURL(file)
        showNotification('Image de cover sélectionnée', 'success')
    }
}

const uploadMusic = () => {
    if (!selectedFile.value || !formData.value.title) {
        showNotification('Veuillez sélectionner un fichier et remplir le titre.', 'error')
        return
    }

    isUploading.value = true

    // Créer un FormData manuellement
    const formDataToSend = new FormData()
    formDataToSend.append('audio_file', selectedFile.value)
    formDataToSend.append('title', formData.value.title)
    formDataToSend.append('description', formData.value.description)
    formDataToSend.append('is_ai_generated', formData.value.is_ai_generated ? '1' : '0')

    // Ajouter les genres
    formData.value.genre_ids.forEach(genreId => {
        formDataToSend.append('genre_ids[]', genreId)
    })

    // Ajouter l'image de cover si elle existe
    if (coverFile.value) {
        formDataToSend.append('cover_image', coverFile.value)
    }

    // Récupérer le token CSRF
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    const inertiaVersion = document.querySelector('meta[name="inertia-version"]')?.getAttribute('content')

    // Envoyer avec fetch
    fetch('/upload-music', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token || '',
            'X-Inertia': 'true',
            'X-Inertia-Version': inertiaVersion || '',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formDataToSend
    })
        .then(response => {
            if (response.ok) {
                return response.json()
            } else {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`)
            }
        })
        .then(data => {
            showNotification('Musique uploadée avec succès !', 'success')
            // Réinitialiser le formulaire
            selectedFile.value = null
            coverFile.value = null
            coverPreview.value = null
            formData.value = {
                title: '',
                description: '',
                genre_ids: [],
                is_ai_generated: false
            }
            if (fileInput.value) {
                fileInput.value.value = ''
            }
            if (coverInput.value) {
                coverInput.value.value = ''
            }
            isUploading.value = false

            // Rediriger vers le dashboard
            window.location.href = '/dashboard'
        })
        .catch(error => {
            console.error('Upload error:', error)
            showNotification('Erreur lors de l\'upload: ' + error.message, 'error')
            isUploading.value = false
        })
}

defineProps({
    categories: Array,
    errors: Object,
    success: String,
})
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-reverse {

    0%,
    100% {
        transform: translateY(0px) rotate(45deg);
    }

    50% {
        transform: translateY(-20px) rotate(45deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}
</style>
