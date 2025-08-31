<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MusicCard from '@/Components/MusicCard.vue'

import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'
import MobileProfileContent from '@/Components/MobileProfileContent.vue'
import {
    UserIcon,
    HeartIcon,
    UserGroupIcon,
    MusicalNoteIcon,
    PlayIcon,
    EllipsisVerticalIcon,
    TrashIcon
} from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    userTracks: {
        type: Array,
        default: () => []
    },
    publicPlaylists: {
        type: Array,
        default: () => []
    },
    publicPosts: {
        type: Array,
        default: () => []
    },
    auth: {
        type: Object,
        default: () => ({})
    },
    isFollowing: {
        type: Boolean,
        default: false
    },
    followersCount: {
        type: Number,
        default: 0
    }
})

// État réactif
const notification = ref({
    show: false,
    message: ''
})

const activeTab = ref('sounds')

// État d'abonnement
const isFollowingState = ref(props.isFollowing)
const followersCountState = ref(props.followersCount)

// État pour les posts et commentaires
const showCreatePost = ref(false)
const newPostContent = ref('')
const newComments = ref({})
const activePostMenu = ref(null)
const activeCommentMenu = ref(null)

// Convertir les props en refs réactives pour pouvoir les modifier
const publicPosts = ref(props.publicPosts || [])
const publicPlaylists = ref(props.publicPlaylists || [])

// Computed properties
const userLikesCount = computed(() => {
    return props.userTracks.reduce((total, track) => total + (track.likes_count || 0), 0)
})

const userSubscribersCount = computed(() => {
    // Pour l'instant, valeur fictive
    return 3920
})

const userPlaysCount = computed(() => {
    return props.userTracks.reduce((total, track) => total + (track.views || 0), 0)
})

// Vérifier si l'utilisateur connecté est le propriétaire du profil
const isOwnProfile = computed(() => {
    return props.auth.user && props.auth.user.id === props.user.id
})

// Méthodes
const handleSearch = (query) => {
    router.get('/search', { q: query })
}

const handleLiveRadioToggle = (isPlaying) => {
    showNotification(isPlaying ? '🔴 Connexion au Live Radio...' : '⏸️ Radio arrêtée')
}

const showNotification = (message) => {
    notification.value = {
        show: true,
        message
    }

    setTimeout(() => {
        notification.value.show = false
    }, 3000)
}

const editProfile = () => {
    router.visit('/profile/settings')
}

const toggleFollow = async () => {
    if (!props.auth.user) {
        // Rediriger vers la page de connexion si non connecté
        router.get('/login')
        return
    }

    try {
        const url = isFollowingState.value
            ? `/unfollow/${props.user.id}`
            : `/follow/${props.user.id}`

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })

        const data = await response.json()

        if (data.success) {
            isFollowingState.value = data.isFollowing
            followersCountState.value = data.followersCount
            showNotification(data.message)
        } else {
            showNotification('Erreur: ' + data.message)
        }
    } catch (error) {
        console.error('Erreur lors de l\'abonnement:', error)
        showNotification('Erreur lors de l\'abonnement')
    }
}

const navigateToMusic = (musicId) => {
    router.get(`/music/${musicId}`)
}

const playMusic = (track) => {
    showNotification(`🎵 Lecture: ${track.title} - ${track.user?.name || 'Artiste inconnu'}`)
    // Naviguer vers la page de la musique
    router.visit(`/music/${track.slug || track.id}`)
}

const toggleLike = async (track) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch(`/music/${track.id}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })

        if (response.ok) {
            const data = await response.json()
            // Mettre à jour l'état du like dans la track
            track.is_liked = !track.is_liked
            track.likes_count = data.likes_count || track.likes_count

            showNotification(`${track.is_liked ? 'Ajouté aux' : 'Retiré des'} likes: ${track.title}`)
        } else {
            showNotification('Erreur lors du like')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors du like')
    }
}

const handleAddToPlaylist = async (track) => {
    // Vérifier si l'utilisateur est connecté
    const page = usePage()
    if (!page.props.auth?.user) {
        window.location.href = '/login'
        return
    }

    try {
        const response = await fetch('/playlists', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })

        if (response.ok) {
            const playlists = await response.json()
            // Ouvrir le modal de playlist (vous devrez implémenter cette fonctionnalité)
            showNotification('🎵 Sélectionnez une playlist pour ajouter cette musique')
        } else {
            showNotification('Erreur lors du chargement des playlists')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('Erreur lors de l\'ajout à la playlist')
    }
}

const goToPlaylist = (playlist) => {
    router.get(`/playlists/${playlist.slug || playlist.id}`)
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffInHours = Math.floor((now - date) / (1000 * 60 * 60))

    if (diffInHours < 1) {
        return 'À l\'instant'
    } else if (diffInHours < 24) {
        return `Il y a ${diffInHours}h`
    } else {
        const diffInDays = Math.floor(diffInHours / 24)
        return `Il y a ${diffInDays}j`
    }
}

const addComment = async (postId) => {
    const content = newComments.value[postId]
    if (!content || !content.trim()) return

    const page = usePage()
    const csrfToken = page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    try {
        const response = await fetch('/posts/' + postId + '/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ content: content.trim() })
        })

        if (response.ok) {
            const data = await response.json()
            const newComment = data.comment

            // Trouver le post et ajouter le commentaire
            const post = publicPosts.value.find(p => p.id === postId)
            if (post) {
                if (!post.comments) {
                    post.comments = []
                }
                post.comments.unshift(newComment) // Ajouter au début
            }

            newComments.value[postId] = ''
            showNotification('💬 Commentaire ajouté avec succès')
        } else {
            showNotification('❌ Erreur lors de l\'ajout du commentaire')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('❌ Erreur lors de l\'ajout du commentaire')
    }
}

const createPost = async () => {
    if (!newPostContent.value.trim()) return

    const page = usePage()
    const csrfToken = page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    try {
        const response = await fetch('/posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ content: newPostContent.value.trim() })
        })

        if (response.ok) {
            const data = await response.json()
            const newPost = data.post

            // Ajouter le nouveau post au début de la liste
            publicPosts.value.unshift(newPost)

            newPostContent.value = ''
            showCreatePost.value = false
            showNotification('📝 Post créé avec succès')
        } else {
            showNotification('❌ Erreur lors de la création du post')
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('❌ Erreur lors de la création du post')
    }
}

const deletePost = async (postId) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce post ? Tous les commentaires associés seront également supprimés.')) {
        return
    }

    const page = usePage()
    const csrfToken = page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    try {
        const response = await fetch(`/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })

        if (response.ok) {
            // Supprimer le post de la liste
            const postIndex = publicPosts.value.findIndex(p => p.id === postId)
            if (postIndex !== -1) {
                publicPosts.value.splice(postIndex, 1)
            }

            showNotification('🗑️ Post supprimé avec succès')
        } else {
            const data = await response.json()
            showNotification(`❌ ${data.message || 'Erreur lors de la suppression du post'}`)
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('❌ Erreur lors de la suppression du post')
    }
}

const deleteComment = async (commentId) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
        return
    }

    const page = usePage()
    const csrfToken = page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })

        if (response.ok) {
            // Supprimer le commentaire de tous les posts
            publicPosts.value.forEach(post => {
                if (post.comments) {
                    const commentIndex = post.comments.findIndex(c => c.id === commentId)
                    if (commentIndex !== -1) {
                        post.comments.splice(commentIndex, 1)
                    }
                }
            })

            showNotification('🗑️ Commentaire supprimé avec succès')
        } else {
            const data = await response.json()
            showNotification(`❌ ${data.message || 'Erreur lors de la suppression du commentaire'}`)
        }
    } catch (error) {
        console.error('Erreur:', error)
        showNotification('❌ Erreur lors de la suppression du commentaire')
    }
}

const togglePostMenu = (postId) => {
    if (activePostMenu.value === postId) {
        activePostMenu.value = null
    } else {
        activePostMenu.value = postId
    }
}

const toggleCommentMenu = (commentId) => {
    if (activeCommentMenu.value === commentId) {
        activeCommentMenu.value = null
    } else {
        activeCommentMenu.value = commentId
    }
}

const formatNumber = (num) => {
    if (num === null || num === undefined || isNaN(num)) {
        return '0'
    }

    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
}

// Cycle de vie
onMounted(() => {
    showNotification('Profil chargé avec succès !')

    // Fermer les menus si on clique ailleurs
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.post-menu')) {
            activePostMenu.value = null
        }
        if (!e.target.closest('.comment-menu')) {
            activeCommentMenu.value = null
        }
    })
})
</script>

<template>
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
            <!-- Sidebar personnalisée -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @search="handleSearch" @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu du profil -->
                <div class="relative z-10 mt-8 max-w-6xl mx-auto">
                    <!-- Section profil utilisateur -->
                    <div class="bg-white/15 backdrop-blur-lg rounded-2xl p-8 mb-8">
                        <div class="flex items-start space-x-8">
                            <!-- Photo de profil -->
                            <div class="flex-shrink-0">
                                <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white/30" />
                                <div v-else
                                    class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                    <UserIcon class="w-16 h-16 text-white/80" />
                                </div>
                            </div>

                            <!-- Informations du profil -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-4">
                                    <h1 class="text-4xl font-bold text-white">{{ user.name || 'Pseudo' }}</h1>
                                    <div class="flex space-x-4">
                                        <button v-if="!isOwnProfile" @click="toggleFollow" :class="[
                                            'px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105',
                                            isFollowingState
                                                ? 'bg-gray-600 text-white hover:bg-gray-700'
                                                : 'bg-gradient-to-r from-purple-600 to-pink-500 text-white hover:from-purple-700 hover:to-pink-600'
                                        ]">
                                            {{ isFollowingState ? 'Se désabonner' : 'S\'abonner' }}
                                        </button>
                                        <button v-if="isOwnProfile" @click="editProfile"
                                            class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-600 transition-all duration-300 transform hover:scale-105">
                                            Modifier le profil
                                        </button>
                                    </div>
                                </div>

                                <!-- Statistiques -->
                                <div class="flex space-x-4">
                                    <div
                                        class="bg-green-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                                        <HeartIcon class="w-5 h-5 text-white" />
                                        <span class="text-white font-semibold">{{ userLikesCount }} Likes</span>
                                    </div>
                                    <div
                                        class="bg-green-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                                        <UserGroupIcon class="w-5 h-5 text-white" />
                                        <span class="text-white font-semibold">{{ followersCountState }} Abonnés</span>
                                    </div>
                                    <div
                                        class="bg-green-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                                        <MusicalNoteIcon class="w-5 h-5 text-white" />
                                        <span class="text-white font-semibold">{{ formatNumber(userPlaysCount) }}
                                            Écoutes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onglets -->
                    <div class="bg-white/15 backdrop-blur-lg rounded-2xl p-6 mb-8">
                        <div class="flex space-x-8 border-b border-white/20 pb-4">
                            <button @click="activeTab = 'sounds'" :class="[
                                'text-lg font-semibold transition-all duration-300',
                                activeTab === 'sounds'
                                    ? 'text-white border-b-2 border-green-400 pb-2'
                                    : 'text-white/60 hover:text-white'
                            ]">
                                Sons
                            </button>
                            <button @click="activeTab = 'playlists'" :class="[
                                'text-lg font-semibold transition-all duration-300',
                                activeTab === 'playlists'
                                    ? 'text-white border-b-2 border-green-400 pb-2'
                                    : 'text-white/60 hover:text-white'
                            ]">
                                Playlists
                            </button>
                            <button @click="activeTab = 'community'" :class="[
                                'text-lg font-semibold transition-all duration-300',
                                activeTab === 'community'
                                    ? 'text-white border-b-2 border-green-400 pb-2'
                                    : 'text-white/60 hover:text-white'
                            ]">
                                Communauté
                            </button>

                        </div>

                        <!-- Contenu des onglets -->
                        <div class="mt-6">
                            <!-- Onglet Sons -->
                            <div v-if="activeTab === 'sounds'" class="space-y-6">
                                <div v-if="userTracks && userTracks.length > 0"
                                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                                    <MusicCard v-for="track in userTracks" :key="track.id" :track="track"
                                        @add-to-playlist="handleAddToPlaylist" />
                                </div>
                                <div v-else class="text-center py-12">
                                    <MusicalNoteIcon class="w-16 h-16 text-white/60 mb-4" />
                                    <h3 class="text-xl font-semibold text-white mb-2">Aucune musique</h3>
                                    <p class="text-white/80 mb-6">
                                        Cet utilisateur n'a pas encore publié de musique.
                                    </p>
                                </div>
                            </div>

                            <!-- Onglet Playlists -->
                            <div v-if="activeTab === 'playlists'" class="space-y-6">
                                <div v-if="publicPlaylists && publicPlaylists.length > 0"
                                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                                    <div v-for="playlist in publicPlaylists" :key="playlist.id"
                                        @click="goToPlaylist(playlist)"
                                        class="bg-white/10 backdrop-blur-sm rounded-xl p-6 cursor-pointer transition-all duration-300 hover:bg-white/20 hover:transform hover:scale-105">
                                        <!-- Cover de playlist -->
                                        <div class="w-full aspect-square rounded-lg mb-4 overflow-hidden">
                                            <div v-if="playlist.cover_image_url"
                                                class="w-full h-full bg-cover bg-center rounded-lg"
                                                :style="{ backgroundImage: `url(${playlist.cover_image_url})` }"></div>
                                            <div v-else
                                                class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                                <span class="text-4xl text-white font-bold">{{
                                                    playlist.name.substring(0, 3).toUpperCase() }}</span>
                                            </div>
                                        </div>

                                        <!-- Informations de la playlist -->
                                        <div class="space-y-2">
                                            <h3 class="text-white font-semibold text-lg truncate">{{ playlist.name }}
                                            </h3>
                                            <p class="text-white/60 text-sm">{{ playlist.musics_count || 0 }} musiques
                                            </p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-white/80 text-xs">{{ playlist.is_public ? 'Publique' :
                                                    'Privée' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-12">
                                    <PlayIcon class="w-16 h-16 text-white/60 mx-auto mb-4" />
                                    <h3 class="text-xl font-semibold text-white mb-2">Aucune playlist publique</h3>
                                    <p class="text-white/60">Les playlists publiques apparaîtront ici</p>
                                </div>
                            </div>

                            <!-- Onglet Communauté -->
                            <div v-if="activeTab === 'community'" class="space-y-6">
                                <!-- Instructions et bouton pour créer un nouveau post -->
                                <div v-if="isOwnProfile" class="bg-white/10 backdrop-blur-sm rounded-xl p-6">

                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-full overflow-hidden">
                                            <img v-if="user.profile_photo_url" :src="user.profile_photo_url"
                                                :alt="user.name" class="w-full h-full object-cover">
                                            <div v-else
                                                class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                <span class="text-white font-bold">{{ user.name.charAt(0) }}</span>
                                            </div>
                                        </div>
                                        <button @click="showCreatePost = true"
                                            class="flex-1 bg-white/20 text-white/80 text-left px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300">
                                            Partagez quelque chose avec votre communauté...
                                        </button>
                                    </div>
                                </div>

                                <!-- Liste des posts -->
                                <div v-if="publicPosts && publicPosts.length > 0" class="space-y-6">
                                    <div v-for="post in publicPosts" :key="post.id"
                                        class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                                        <!-- En-tête du post -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 rounded-full overflow-hidden">
                                                    <img v-if="post.user.profile_photo_url"
                                                        :src="post.user.profile_photo_url" :alt="post.user.name"
                                                        class="w-full h-full object-cover">
                                                    <div v-else
                                                        class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                        <span class="text-white font-bold">{{ post.user.name.charAt(0)
                                                            }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-white font-semibold">{{ post.user.name }}</h3>
                                                    <p class="text-white/60 text-sm">{{ formatDate(post.created_at) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Menu d'options pour les posts de l'utilisateur connecté -->
                                            <div v-if="auth.user && auth.user.id === post.user_id"
                                                class="relative post-menu">
                                                <button @click="togglePostMenu(post.id)"
                                                    class="text-white/60 hover:text-white transition-colors duration-300 p-2 rounded-lg hover:bg-white/10"
                                                    title="Options du post">
                                                    <EllipsisVerticalIcon class="w-5 h-5" />
                                                </button>
                                                <!-- Menu déroulant -->
                                                <div v-if="activePostMenu === post.id"
                                                    class="absolute right-0 top-full mt-2 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-white/20 z-10 min-w-[150px]">
                                                    <button @click="deletePost(post.id)"
                                                        class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-300 flex items-center space-x-2">
                                                        <TrashIcon class="w-4 h-4" />
                                                        <span>Supprimer</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contenu du post -->
                                        <div class="mb-4">
                                            <p class="text-white leading-relaxed">{{ post.content }}</p>
                                            <img v-if="post.image_path" :src="post.image_path" :alt="'Image du post'"
                                                class="mt-4 rounded-lg max-w-full">
                                        </div>

                                        <!-- Commentaires -->
                                        <div class="space-y-3">
                                            <div v-if="post.comments && post.comments.length > 0">
                                                <h4 class="text-white/80 font-semibold mb-3">{{ post.comments.length }}
                                                    commentaire(s)</h4>
                                                <div class="space-y-3">
                                                    <div v-for="comment in post.comments" :key="comment.id"
                                                        class="bg-white/5 rounded-lg p-3">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="w-6 h-6 rounded-full overflow-hidden">
                                                                    <img v-if="comment.user.profile_photo_url"
                                                                        :src="comment.user.profile_photo_url"
                                                                        :alt="comment.user.name"
                                                                        class="w-full h-full object-cover">
                                                                    <div v-else
                                                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 flex items-center justify-center">
                                                                        <span class="text-white text-xs font-bold">{{
                                                                            comment.user.name.charAt(0) }}</span>
                                                                    </div>
                                                                </div>
                                                                <span class="text-white font-semibold text-sm">{{
                                                                    comment.user.name }}</span>
                                                                <span class="text-white/60 text-xs">{{
                                                                    formatDate(comment.created_at) }}</span>
                                                            </div>
                                                            <!-- Menu d'options pour les commentaires -->
                                                            <div v-if="auth.user && (auth.user.id === comment.user_id || auth.user.id === post.user_id)"
                                                                class="relative comment-menu">
                                                                <button @click="toggleCommentMenu(comment.id)"
                                                                    class="text-white/60 hover:text-white transition-colors duration-300 p-1 rounded hover:bg-white/10"
                                                                    title="Options du commentaire">
                                                                    <EllipsisVerticalIcon class="w-4 h-4" />
                                                                </button>
                                                                <!-- Menu déroulant -->
                                                                <div v-if="activeCommentMenu === comment.id"
                                                                    class="absolute right-0 top-full mt-1 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-white/20 z-10 min-w-[150px]">
                                                                    <button @click="deleteComment(comment.id)"
                                                                        class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300 flex items-center space-x-2 text-sm">
                                                                        <TrashIcon class="w-4 h-4" />
                                                                        <span>Supprimer</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="text-white/90 text-sm">{{ comment.content }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Formulaire de commentaire -->
                                            <div v-if="auth.user" class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full overflow-hidden">
                                                    <img v-if="auth.user.profile_photo_url"
                                                        :src="auth.user.profile_photo_url" :alt="auth.user.name"
                                                        class="w-full h-full object-cover">
                                                    <div v-else
                                                        class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">{{
                                                            auth.user.name.charAt(0) }}</span>
                                                    </div>
                                                </div>
                                                <input v-model="newComments[post.id]" @keyup.enter="addComment(post.id)"
                                                    type="text" placeholder="Ajouter un commentaire..."
                                                    class="flex-1 bg-white/20 text-white placeholder-white/60 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                                <button @click="addComment(post.id)"
                                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-300">
                                                    Envoyer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="text-center py-12">
                                    <UserGroupIcon class="w-16 h-16 text-white/60 mx-auto mb-4" />
                                    <h3 class="text-xl font-semibold text-white mb-2">Aucun post</h3>
                                    <p class="text-white/60">Les posts de la communauté apparaîtront ici</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Notification -->
                <div v-if="notification.show"
                    class="fixed top-5 right-5 bg-gradient-to-r from-purple-600 to-cyan-500 text-white px-5 py-4 rounded-xl z-50 font-bold shadow-lg transform transition-transform duration-300"
                    :class="notification.show ? 'translate-x-0' : 'translate-x-full'">
                    {{ notification.message }}
                </div>

                <!-- Modal de création de post -->
                <div v-if="showCreatePost"
                    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 w-full max-w-md">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-white">Créer un post</h3>
                            <button @click="showCreatePost = false" class="text-white/60 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <textarea v-model="newPostContent" placeholder="Partagez quelque chose avec votre communauté..."
                            class="w-full bg-white/20 text-white placeholder-white/60 p-4 rounded-lg resize-none h-32 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>

                        <div class="flex justify-end space-x-3 mt-4">
                            <button @click="showCreatePost = false"
                                class="px-4 py-2 text-white/60 hover:text-white transition-colors">
                                Annuler
                            </button>
                            <button @click="createPost" :disabled="!newPostContent.trim()"
                                class="bg-purple-600 hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg transition-all duration-300">
                                Publier
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader @live-radio-toggle="handleLiveRadioToggle" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-20"> <!-- pt-20 pour le header fixe, pb-20 pour la navigation mobile -->
                <MobileProfileContent :user="user" :user-tracks="userTracks" :public-playlists="publicPlaylists"
                    :public-posts="publicPosts" :auth="auth" :is-following="isFollowing"
                    :followers-count="followersCount" @play="playMusic" @like="toggleLike"
                    @add-to-playlist="handleAddToPlaylist" @toggle-follow="toggleFollow" @edit-profile="editProfile" />
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<style scoped>
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
