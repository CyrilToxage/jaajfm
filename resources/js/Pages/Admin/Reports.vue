<template>

    <Head title="Signalements - Admin JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-8">
                        <h1 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
                            <ExclamationTriangleIcon class="w-10 h-10 text-red-400" />
                            Gestion des signalements
                        </h1>
                        <p class="text-white/90 text-lg">Gérez tous les signalements de la plateforme</p>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActions />

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Statistiques</h2>
                        <div class="grid grid-cols-3 gap-6">
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <ExclamationTriangleIcon class="w-8 h-8 text-yellow-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.pending }}</div>
                                <div class="text-white/70 text-sm">En attente</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <CheckIcon class="w-8 h-8 text-green-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.resolved }}</div>
                                <div class="text-white/70 text-sm">Résolus</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-6 text-center">
                                <XMarkIcon class="w-8 h-8 text-red-400 mx-auto mb-3" />
                                <div class="text-2xl font-bold text-white">{{ stats.dismissed }}</div>
                                <div class="text-white/70 text-sm">Rejetés</div>
                            </div>
                        </div>
                    </section>

                    <!-- Filtres -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Filtres</h2>
                        <div class="flex gap-4">
                            <select v-model="filterStatus"
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-400">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="resolved">Résolus</option>
                                <option value="dismissed">Rejetés</option>
                            </select>
                            <select v-model="filterType"
                                class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-400">
                                <option value="">Tous les types</option>
                                <option value="App\Models\Music">Musiques</option>
                                <option value="App\Models\User">Utilisateurs</option>
                                <option value="App\Models\MusicComment">Commentaires</option>
                            </select>
                        </div>
                    </section>

                    <!-- Liste des signalements -->
                    <section class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Liste des signalements</h2>

                        <div v-if="filteredReports.length === 0" class="text-center py-8">
                            <ExclamationTriangleIcon class="w-16 h-16 text-white/50 mx-auto mb-4" />
                            <p class="text-white/70">Aucun signalement trouvé</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="report in filteredReports" :key="report.id"
                                class="bg-white/5 rounded-xl p-6 border border-white/10">
                                <!-- En-tête du signalement -->
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-white font-semibold">Signalement #{{ report.id }}</span>
                                            <span :class="getStatusBadgeClass(report.status)"
                                                class="px-2 py-1 rounded-full text-xs font-medium">
                                                {{ getStatusText(report.status) }}
                                            </span>
                                        </div>
                                        <div class="text-white/70 text-sm">
                                            Signalé par {{ report.reporter?.name }} le {{ formatDate(report.created_at)
                                            }}
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button v-if="report.status === 'pending'"
                                            @click="resolveReport(report.id, 'resolve')"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm transition-all">
                                            Résoudre
                                        </button>
                                        <button v-if="report.status === 'pending'"
                                            @click="resolveReport(report.id, 'dismiss')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition-all">
                                            Rejeter
                                        </button>
                                    </div>
                                </div>

                                <!-- Contenu du signalement -->
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-white/70 text-sm">Type:</span>
                                        <span class="text-white ml-2">{{ getTypeText(report.reportable_type) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-white/70 text-sm">Raison:</span>
                                        <span class="text-white ml-2">{{ getReasonText(report.reason) }}</span>
                                    </div>
                                    <div v-if="report.description">
                                        <span class="text-white/70 text-sm">Description:</span>
                                        <p class="text-white mt-1">{{ report.description }}</p>
                                    </div>
                                    <div v-if="report.reportable">
                                        <span class="text-white/70 text-sm">Élément signalé:</span>
                                        <div class="text-white mt-1">
                                            <div v-if="report.reportable_type === 'App\\Models\\Music'">
                                                <button @click="goToMusic(report.reportable)"
                                                    class="flex items-center gap-3 hover:bg-white/5 p-2 rounded-lg transition-all w-full text-left">
                                                    <div v-if="report.reportable.cover_image_url"
                                                        class="w-12 h-12 rounded-lg overflow-hidden">
                                                        <img :src="report.reportable.cover_image_url"
                                                            :alt="report.reportable.title"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="font-semibold">{{ report.reportable.title }}</div>
                                                        <div class="text-white/70 text-sm">{{
                                                            report.reportable.user?.name }}</div>
                                                    </div>
                                                    <div class="text-white/50">
                                                        <ArrowTopRightOnSquareIcon class="w-4 h-4" />
                                                    </div>
                                                </button>
                                            </div>
                                            <div v-else-if="report.reportable_type === 'App\\Models\\User'">
                                                <div class="font-semibold">{{ report.reportable.name }}</div>
                                                <div class="text-white/70 text-sm">{{ report.reportable.email }}</div>
                                            </div>
                                            <div v-else-if="report.reportable_type === 'App\\Models\\MusicComment'">
                                                <div class="font-semibold">Commentaire de {{
                                                    report.reportable.user?.name }}</div>
                                                <div class="text-white/70 text-sm">{{ report.reportable.content }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Résolution -->
                                <div v-if="report.status !== 'pending'" class="mt-4 pt-4 border-t border-white/10">
                                    <div class="text-white/70 text-sm">
                                        {{ report.status === 'resolved' ? 'Résolu' : 'Rejeté' }} par {{
                                            report.resolved_by_user?.name }}
                                        le {{ formatDate(report.resolved_at) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-24 px-4">
                <div class="space-y-6">
                    <!-- Titre -->
                    <section class="glass rounded-2xl p-4">
                        <h1 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                            <ExclamationTriangleIcon class="w-6 h-6 text-red-400" />
                            Signalements
                        </h1>
                        <p class="text-white/90 text-sm">Gérez tous les signalements</p>
                    </section>

                    <!-- Statistiques -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Statistiques</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <ExclamationTriangleIcon class="w-6 h-6 text-yellow-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.pending }}</div>
                                <div class="text-white/70 text-xs">En attente</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <CheckIcon class="w-6 h-6 text-green-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.resolved }}</div>
                                <div class="text-white/70 text-xs">Résolus</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center">
                                <XMarkIcon class="w-6 h-6 text-red-400 mx-auto mb-2" />
                                <div class="text-xl font-bold text-white">{{ stats.dismissed }}</div>
                                <div class="text-white/70 text-xs">Rejetés</div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions rapides -->
                    <AdminQuickActionsMobile />

                    <!-- Filtres -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Filtres</h2>
                        <div class="space-y-3">
                            <select v-model="filterStatus"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-400">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="resolved">Résolus</option>
                                <option value="dismissed">Rejetés</option>
                            </select>
                            <select v-model="filterType"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-400">
                                <option value="">Tous les types</option>
                                <option value="App\Models\Music">Musiques</option>
                                <option value="App\Models\User">Utilisateurs</option>
                                <option value="App\Models\MusicComment">Commentaires</option>
                            </select>
                        </div>
                    </section>

                    <!-- Liste des signalements -->
                    <section class="glass rounded-2xl p-4">
                        <h2 class="text-lg font-bold text-white mb-4">Signalements</h2>

                        <div v-if="filteredReports.length === 0" class="text-center py-8">
                            <ExclamationTriangleIcon class="w-12 h-12 text-white/50 mx-auto mb-3" />
                            <p class="text-white/70 text-sm">Aucun signalement trouvé</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="report in filteredReports" :key="report.id"
                                class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-white font-semibold text-sm">#{{ report.id }}</span>
                                            <span :class="getStatusBadgeClass(report.status)"
                                                class="px-2 py-1 rounded-full text-xs font-medium">
                                                {{ getStatusText(report.status) }}
                                            </span>
                                        </div>
                                        <div class="text-white/70 text-xs">
                                            {{ report.reporter?.name }} - {{ formatDate(report.created_at) }}
                                        </div>
                                    </div>
                                    <div v-if="report.status === 'pending'" class="flex gap-1">
                                        <button @click="resolveReport(report.id, 'resolve')"
                                            class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-all">
                                            ✓
                                        </button>
                                        <button @click="resolveReport(report.id, 'dismiss')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-all">
                                            ✕
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="text-white/70 text-xs">
                                        {{ getTypeText(report.reportable_type) }} - {{ getReasonText(report.reason) }}
                                    </div>
                                    <div v-if="report.description" class="text-white text-sm">
                                        {{ report.description }}
                                    </div>
                                    <!-- Lien vers la musique pour la version mobile -->
                                    <div v-if="report.reportable_type === 'App\\Models\\Music' && report.reportable"
                                        class="pt-2">
                                        <button @click="goToMusic(report.reportable)"
                                            class="flex items-center gap-2 text-blue-400 hover:text-blue-300 text-xs transition-colors">
                                            <ArrowTopRightOnSquareIcon class="w-3 h-3" />
                                            Voir la musique
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import AdminQuickActions from '@/Components/AdminQuickActions.vue'
import AdminQuickActionsMobile from '@/Components/AdminQuickActionsMobile.vue'
import {
    ExclamationTriangleIcon,
    CheckIcon,
    XMarkIcon,
    ArrowTopRightOnSquareIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    reports: Object,
    stats: Object
})

const filterStatus = ref('')
const filterType = ref('')

const filteredReports = computed(() => {
    let filtered = props.reports.data

    if (filterStatus.value) {
        filtered = filtered.filter(report => report.status === filterStatus.value)
    }

    if (filterType.value) {
        filtered = filtered.filter(report => report.reportable_type === filterType.value)
    }

    return filtered
})

const getStatusBadgeClass = (status) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30'
        case 'resolved':
            return 'bg-green-500/20 text-green-400 border border-green-500/30'
        case 'dismissed':
            return 'bg-red-500/20 text-red-400 border border-red-500/30'
        default:
            return 'bg-gray-500/20 text-gray-400 border border-gray-500/30'
    }
}

const getStatusText = (status) => {
    switch (status) {
        case 'pending':
            return 'En attente'
        case 'resolved':
            return 'Résolu'
        case 'dismissed':
            return 'Rejeté'
        default:
            return status
    }
}

const getTypeText = (type) => {
    switch (type) {
        case 'App\\Models\\Music':
            return 'Musique'
        case 'App\\Models\\User':
            return 'Utilisateur'
        case 'App\\Models\\MusicComment':
            return 'Commentaire'
        default:
            return type
    }
}

const getReasonText = (reason) => {
    switch (reason) {
        case 'inappropriate_content':
            return 'Contenu inapproprié'
        case 'copyright_violation':
            return 'Violation de droits d\'auteur'
        case 'spam':
            return 'Spam'
        case 'harassment':
            return 'Harcèlement'
        case 'fake_information':
            return 'Fausses informations'
        case 'other':
            return 'Autre'
        default:
            return reason
    }
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const resolveReport = async (reportId, action) => {
    try {
        const response = await fetch(`/admin/reports/${reportId}/resolve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action })
        })

        if (response.ok) {
            // Recharger la page pour mettre à jour les données
            window.location.reload()
        } else {
            const error = await response.json()
            alert(error.error || 'Erreur lors de la résolution du signalement')
        }
    } catch (error) {
        console.error('Erreur lors de la résolution du signalement:', error)
        alert('Erreur lors de la résolution du signalement')
    }
}

const goToMusic = (music) => {
    // Naviguer vers la page de la musique
    if (music.slug) {
        window.open(`/music/${music.slug}`, '_blank')
    } else {
        window.open(`/music/${music.id}`, '_blank')
    }
}
</script>

<style scoped>
.glass {
    @apply bg-white/10 backdrop-blur-lg border border-white/20;
}
</style>
