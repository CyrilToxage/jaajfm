<template>
    <div v-if="show" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Signaler {{ reportableType === 'App\\Models\\Music' ? 'cette musique' : 'cet élément' }}</h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <XMarkIcon class="w-6 h-6" />
                </button>
            </div>

            <form @submit.prevent="submitReport" class="space-y-4">
                <!-- Raison du signalement -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison du signalement</label>
                    <select v-model="form.reason" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Choisir une raison</option>
                        <option value="inappropriate_content">Contenu inapproprié</option>
                        <option value="copyright_violation">Violation de droits d'auteur</option>
                        <option value="spam">Spam</option>
                        <option value="harassment">Harcèlement</option>
                        <option value="fake_information">Fausses informations</option>
                        <option value="other">Autre</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (optionnel)</label>
                    <textarea v-model="form.description" rows="4" placeholder="Décrivez le problème..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-4">
                    <button type="button" @click="closeModal"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition-all">
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ submitting ? 'Envoi...' : 'Signaler' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    reportableType: {
        type: String,
        required: true
    },
    reportableId: {
        type: Number,
        required: true
    }
})

const emit = defineEmits(['close', 'reported'])

const form = ref({
    reason: '',
    description: ''
})

const submitting = ref(false)

const closeModal = () => {
    form.value = {
        reason: '',
        description: ''
    }
    emit('close')
}

const submitReport = async () => {
    if (!form.value.reason) return

    submitting.value = true

    const reportData = {
        reportable_type: props.reportableType,
        reportable_id: props.reportableId,
        reason: form.value.reason,
        description: form.value.description
    }

    console.log('Envoi du signalement:', reportData)

    try {
        const response = await fetch('/reports', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(reportData)
        })

        console.log('Réponse du serveur:', response.status, response.statusText)

        if (response.ok) {
            const data = await response.json()
            console.log('Signalement envoyé avec succès:', data)
            emit('reported', data)
            closeModal()
        } else {
            const contentType = response.headers.get('content-type')
            console.log('Type de contenu de la réponse:', contentType)
            
            if (contentType && contentType.includes('application/json')) {
                try {
                    const error = await response.json()
                    console.error('Erreur JSON:', error)
                    if (error && Object.keys(error).length > 0) {
                        alert(error.error || error.message || 'Erreur lors de l\'envoi du signalement')
                    } else {
                        alert('Erreur: Réponse JSON vide du serveur')
                    }
                } catch (jsonError) {
                    console.error('Erreur lors du parsing JSON:', jsonError)
                    alert('Erreur: Impossible de parser la réponse JSON du serveur')
                }
            } else {
                const text = await response.text()
                console.error('Réponse HTML reçue:', text.substring(0, 200))
                alert('Erreur serveur: Le serveur a retourné une page HTML au lieu d\'une réponse JSON')
            }
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi du signalement:', error)
        alert('Erreur lors de l\'envoi du signalement')
    } finally {
        submitting.value = false
    }
}

// Réinitialiser le formulaire quand le modal s'ouvre
watch(() => props.show, (newValue) => {
    if (newValue) {
        form.value = {
            reason: '',
            description: ''
        }
    }
})
</script>
