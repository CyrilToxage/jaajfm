class CookieService {
    constructor() {
        this.consent = this.getConsent()
        this.preferences = this.getPreferences()
    }

    // Gestion du consentement
    getConsent() {
        const stored = localStorage.getItem('cookie-consent')
        if (stored) {
            return JSON.parse(stored)
        }
        return null
    }

    hasConsent() {
        return this.consent !== null
    }

    canUseAnalytics() {
        return this.consent?.analytics === true
    }

    canUsePersonalization() {
        return this.consent?.personalization === true
    }

    // Gestion des préférences utilisateur
    getPreferences() {
        if (!this.canUsePersonalization()) {
            return this.getDefaultPreferences()
        }

        const stored = localStorage.getItem('user-preferences')
        if (stored) {
            return { ...this.getDefaultPreferences(), ...JSON.parse(stored) }
        }
        return this.getDefaultPreferences()
    }

    getDefaultPreferences() {
        return {
            theme: 'light', // 'light' | 'dark' | 'auto'
            language: 'fr',
            volume: 0.7,
            autoplay: false,
            shuffle: false,
            repeat: 'none', // 'none' | 'one' | 'all'
            quality: 'high', // 'low' | 'medium' | 'high'
            notifications: {
                newMusic: true,
                likes: true,
                comments: true,
                follows: true
            },
            recentlyPlayed: [],
            favoriteGenres: [],
            lastPlaylist: null
        }
    }

    updatePreference(key, value) {
        if (!this.canUsePersonalization()) {
            console.warn('Personalization cookies not enabled')
            return
        }

        this.preferences[key] = value
        localStorage.setItem('user-preferences', JSON.stringify(this.preferences))

        // Émettre un événement pour informer l'application
        window.dispatchEvent(new CustomEvent('preferences-updated', {
            detail: { key, value, preferences: this.preferences }
        }))
    }

    // Gestion de l'historique de lecture
    addToRecentlyPlayed(music) {
        if (!this.canUsePersonalization()) return

        const recentlyPlayed = this.preferences.recentlyPlayed || []
        const existingIndex = recentlyPlayed.findIndex(item => item.id === music.id)

        if (existingIndex > -1) {
            recentlyPlayed.splice(existingIndex, 1)
        }

        recentlyPlayed.unshift({
            id: music.id,
            title: music.title,
            artist: music.user?.name,
            cover: music.cover_image,
            playedAt: new Date().toISOString()
        })

        // Garder seulement les 20 derniers
        if (recentlyPlayed.length > 20) {
            recentlyPlayed.splice(20)
        }

        this.updatePreference('recentlyPlayed', recentlyPlayed)
    }

    // Gestion des genres favoris
    toggleFavoriteGenre(genreId) {
        if (!this.canUsePersonalization()) return

        const favoriteGenres = this.preferences.favoriteGenres || []
        const index = favoriteGenres.indexOf(genreId)

        if (index > -1) {
            favoriteGenres.splice(index, 1)
        } else {
            favoriteGenres.push(genreId)
        }

        this.updatePreference('favoriteGenres', favoriteGenres)
    }

    // Gestion des notifications
    updateNotificationSetting(type, enabled) {
        if (!this.canUsePersonalization()) return

        const notifications = { ...this.preferences.notifications }
        notifications[type] = enabled
        this.updatePreference('notifications', notifications)
    }

    // Analytics (si autorisé)
    trackEvent(eventName, data = {}) {
        if (!this.canUseAnalytics()) return

        const event = {
            name: eventName,
            data,
            timestamp: new Date().toISOString(),
            userAgent: navigator.userAgent,
            url: window.location.href
        }

        // Stocker les événements pour envoi ultérieur
        const events = JSON.parse(localStorage.getItem('analytics-events') || '[]')
        events.push(event)

        // Garder seulement les 100 derniers événements
        if (events.length > 100) {
            events.splice(0, events.length - 100)
        }

        localStorage.setItem('analytics-events', JSON.stringify(events))
    }

    // Envoi des analytics au serveur
    async sendAnalytics() {
        if (!this.canUseAnalytics()) return

        const events = JSON.parse(localStorage.getItem('analytics-events') || '[]')
        if (events.length === 0) return

        try {
            const response = await fetch('/api/analytics', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({ events })
            })

            if (response.ok) {
                localStorage.removeItem('analytics-events')
            }
        } catch (error) {
            console.warn('Failed to send analytics:', error)
        }
    }

    // Réinitialisation
    reset() {
        localStorage.removeItem('cookie-consent')
        localStorage.removeItem('user-preferences')
        localStorage.removeItem('analytics-events')
        this.consent = null
        this.preferences = this.getDefaultPreferences()
    }

    // Export des données utilisateur
    exportUserData() {
        return {
            consent: this.consent,
            preferences: this.preferences,
            analyticsEvents: JSON.parse(localStorage.getItem('analytics-events') || '[]')
        }
    }
}

// Instance singleton
const cookieService = new CookieService()

// Envoyer les analytics périodiquement
setInterval(() => {
    cookieService.sendAnalytics()
}, 60000) // Toutes les minutes

export default cookieService
