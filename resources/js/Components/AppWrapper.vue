<template>
    <div>
        <slot />
        <CookieConsent />
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import CookieConsent from './CookieConsent.vue'
import cookieService from '@/Services/CookieService'

// Initialiser le service de cookies
onMounted(() => {
    // Écouter les événements de mise à jour des préférences
    window.addEventListener('preferences-updated', (event) => {
        console.log('Préférences mises à jour:', event.detail)
    })

    // Écouter les événements de consentement des cookies
    window.addEventListener('cookie-consent-updated', (event) => {
        console.log('Consentement cookies mis à jour:', event.detail)
        // Réinitialiser le service avec les nouvelles préférences
        cookieService.consent = event.detail
    })

    // Tracker la vue de page si les analytics sont autorisés
    if (cookieService.canUseAnalytics()) {
        cookieService.trackEvent('page_view', {
            page: window.location.pathname,
            title: document.title
        })
    }
})
</script>
