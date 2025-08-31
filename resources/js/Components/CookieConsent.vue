<template>
    <div v-if="showConsent" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-lg flex items-center justify-center">
                        <ShieldCheckIcon class="w-6 h-6 text-white" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Gestion des cookies</h2>
                </div>
                <p class="text-gray-600">
                    Nous utilisons des cookies pour améliorer votre expérience sur JaaJ FM
                </p>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Cookie Categories -->
                <div class="space-y-4">
                    <!-- Essential Cookies -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <CheckIcon class="w-5 h-5 text-green-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Cookies essentiels</h3>
                                    <p class="text-sm text-gray-600">Toujours actifs</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Toujours actifs</span>
                                <div class="w-12 h-6 bg-green-500 rounded-full flex items-center justify-end px-1">
                                    <div class="w-4 h-4 bg-white rounded-full"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 ml-11">
                            Ces cookies sont nécessaires au fonctionnement du site (authentification, sécurité, préférences de base).
                        </p>
                    </div>

                    <!-- Analytics Cookies -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <ChartBarIcon class="w-5 h-5 text-blue-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Cookies d'analyse</h3>
                                    <p class="text-sm text-gray-600">Améliorent nos services</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Recommandés</span>
                                <button
                                    @click="toggleAnalytics"
                                    class="w-12 h-6 rounded-full flex items-center transition-colors"
                                    :class="analyticsEnabled ? 'bg-blue-500 justify-end' : 'bg-gray-300 justify-start'"
                                >
                                    <div class="w-4 h-4 bg-white rounded-full mx-1"></div>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 ml-11">
                            Ces cookies nous aident à comprendre comment vous utilisez le site pour l'améliorer.
                        </p>
                    </div>

                    <!-- Personalization Cookies -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <UserIcon class="w-5 h-5 text-purple-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Cookies de personnalisation</h3>
                                    <p class="text-sm text-gray-600">Personnalisent votre expérience</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Recommandés</span>
                                <button
                                    @click="togglePersonalization"
                                    class="w-12 h-6 rounded-full flex items-center transition-colors"
                                    :class="personalizationEnabled ? 'bg-purple-500 justify-end' : 'bg-gray-300 justify-start'"
                                >
                                    <div class="w-4 h-4 bg-white rounded-full mx-1"></div>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 ml-11">
                            Ces cookies mémorisent vos préférences (thème, langue, playlists favorites).
                        </p>
                    </div>
                </div>

                <!-- Learn More Link -->
                <div class="text-center">
                    <Link href="/privacy" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        En savoir plus sur notre politique de confidentialité
                    </Link>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        @click="acceptAll"
                        class="flex-1 bg-gradient-to-r from-purple-600 to-cyan-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-cyan-600 transition-all"
                    >
                        Accepter tous les cookies
                    </button>
                    <button
                        @click="acceptSelected"
                        class="flex-1 bg-white border-2 border-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
                    >
                        Accepter la sélection
                    </button>
                    <button
                        @click="rejectAll"
                        class="flex-1 bg-gray-100 text-gray-600 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-colors"
                    >
                        Refuser tout
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import {
    ShieldCheckIcon,
    CheckIcon,
    ChartBarIcon,
    UserIcon
} from '@heroicons/vue/24/outline'

// État réactif
const showConsent = ref(false)
const analyticsEnabled = ref(true)
const personalizationEnabled = ref(true)

// Méthodes
const checkCookieConsent = () => {
    const consent = localStorage.getItem('cookie-consent')
    if (!consent) {
        showConsent.value = true
    }
}

const saveConsent = (analytics, personalization) => {
    const consent = {
        analytics,
        personalization,
        timestamp: new Date().toISOString()
    }
    localStorage.setItem('cookie-consent', JSON.stringify(consent))
    showConsent.value = false

    // Émettre un événement pour informer l'application
    window.dispatchEvent(new CustomEvent('cookie-consent-updated', { detail: consent }))
}

const acceptAll = () => {
    saveConsent(true, true)
}

const acceptSelected = () => {
    saveConsent(analyticsEnabled.value, personalizationEnabled.value)
}

const rejectAll = () => {
    saveConsent(false, false)
}

const toggleAnalytics = () => {
    analyticsEnabled.value = !analyticsEnabled.value
}

const togglePersonalization = () => {
    personalizationEnabled.value = !personalizationEnabled.value
}

// Initialisation
onMounted(() => {
    checkCookieConsent()
})
</script>
