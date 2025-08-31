<template>
    <div class="px-4 py-6 space-y-6">
        <!-- Section Profil -->
        <section class="text-center space-y-4">
            <!-- Photo de profil -->
            <div class="flex justify-center">
                <img v-if="user.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                    class="w-32 h-32 rounded-full object-cover border-4 border-white/30" />
                <div v-else
                    class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                    <UserIcon class="w-16 h-16 text-white/80" />
                </div>
            </div>

            <!-- Nom d'utilisateur -->
            <h1 class="text-3xl font-bold text-white">{{ user.name || 'Pseudo' }}</h1>

            <!-- Statistiques -->
            <div class="flex justify-center space-x-4">
                <div class="bg-teal-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                    <HeartIcon class="w-5 h-5 text-white" />
                    <span class="text-white font-semibold text-sm">{{ userLikesCount }} Likes</span>
                </div>
                <div class="bg-teal-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                    <UserGroupIcon class="w-5 h-5 text-white" />
                    <span class="text-white font-semibold text-sm">{{ followersCount }} Subscribers</span>
                </div>
                <div class="bg-teal-500/20 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center space-x-2">
                    <MusicalNoteIcon class="w-5 h-5 text-white" />
                    <span class="text-white font-semibold text-sm">{{ formatNumber(userPlaysCount) }} Plays</span>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-center space-x-3">
                <button v-if="!isOwnProfile" @click="$emit('toggle-follow')" :class="[
                    'px-6 py-2 rounded-lg font-semibold transition-all duration-300',
                    isFollowing
                        ? 'bg-gray-600 text-white hover:bg-gray-700'
                        : 'bg-gradient-to-r from-purple-600 to-pink-500 text-white hover:from-purple-700 hover:to-pink-600'
                ]">
                    {{ isFollowing ? 'Se désabonner' : 'S\'abonner' }}
                </button>
                <button v-if="isOwnProfile" @click="$emit('edit-profile')"
                    class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-2 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-600 transition-all duration-300">
                    Modifier le profil
                </button>
            </div>
        </section>

        <!-- Onglets -->
        <section class="space-y-4">
            <div class="flex border-b border-white/20">
                <button @click="activeTab = 'sounds'" :class="[
                    'flex-1 text-center py-3 font-semibold transition-all duration-300',
                    activeTab === 'sounds'
                        ? 'text-white border-b-2 border-white'
                        : 'text-white/60 hover:text-white'
                ]">
                    Sons
                </button>
                <button @click="activeTab = 'playlists'" :class="[
                    'flex-1 text-center py-3 font-semibold transition-all duration-300',
                    activeTab === 'playlists'
                        ? 'text-white border-b-2 border-white'
                        : 'text-white/60 hover:text-white'
                ]">
                    Playlists
                </button>
                <button @click="activeTab = 'community'" :class="[
                    'flex-1 text-center py-3 font-semibold transition-all duration-300',
                    activeTab === 'community'
                        ? 'text-white border-b-2 border-white'
                        : 'text-white/60 hover:text-white'
                ]">
                    Communauté
                </button>
            </div>

            <!-- Contenu des onglets -->
            <div class="space-y-4">
                <!-- Onglet Sons -->
                <div v-if="activeTab === 'sounds'" class="space-y-4">
                    <div v-if="userTracks && userTracks.length > 0" class="grid grid-cols-1 gap-4">
                        <MusicCard v-for="track in userTracks" :key="track.id" :track="track" @play="$emit('play', track)" @like="$emit('like', track)" />
                    </div>
                    <div v-else class="text-center py-12">
                        <MusicalNoteIcon class="w-16 h-16 text-white/60 mx-auto mb-4" />
                        <h3 class="text-xl font-semibold text-white mb-2">Aucune musique</h3>
                        <p class="text-white/60">Les musiques de cet utilisateur apparaîtront ici</p>
                    </div>
                </div>

                <!-- Onglet Playlists -->
                <div v-if="activeTab === 'playlists'" class="space-y-4">
                    <div v-if="publicPlaylists && publicPlaylists.length > 0" class="grid grid-cols-2 gap-4">
                        <div v-for="playlist in publicPlaylists" :key="playlist.id" class="space-y-2">
                            <!-- Cover -->
                            <div class="relative w-full aspect-square rounded-lg overflow-hidden">
                                <div v-if="playlist.cover_image_url" class="w-full h-full bg-cover bg-center"
                                    :style="{ backgroundImage: `url(${playlist.cover_image_url})` }"></div>
                                <div v-else
                                    class="w-full h-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 flex items-center justify-center">
                                    <MusicalNoteIcon class="w-12 h-12 text-white opacity-90" />
                                </div>
                            </div>

                            <!-- Info Card -->
                            <div class="bg-orange-100/90 backdrop-blur-sm rounded-lg p-3 space-y-2">
                                <h3 class="font-bold text-gray-800 text-sm truncate">{{ playlist.name }}</h3>
                                <p class="text-xs text-gray-600">{{ playlist.musics_count || 0 }} musiques</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-gray-800 rounded-full"></div>
                                        <span class="text-xs text-gray-700 truncate">{{ playlist.user?.name || 'pseudo'
                                        }}</span>
                                    </div>
                                    <button class="text-gray-600 hover:text-gray-800">
                                        <EllipsisVerticalIcon class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-12">
                        <MusicalNoteIcon class="w-16 h-16 text-white/60 mx-auto mb-4" />
                        <h3 class="text-xl font-semibold text-white mb-2">Aucune playlist</h3>
                        <p class="text-white/60">Les playlists de cet utilisateur apparaîtront ici</p>
                    </div>
                </div>

                <!-- Onglet Communauté -->
                <div v-if="activeTab === 'community'" class="space-y-4">
                    <!-- Instructions et bouton pour créer un nouveau post -->
                    <div v-if="isOwnProfile" class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
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
                    <div v-if="publicPosts && publicPosts.length > 0" class="space-y-4">
                        <div v-for="post in publicPosts" :key="post.id"
                            class="bg-white/10 backdrop-blur-sm rounded-xl p-4 space-y-3">
                            <!-- En-tête du post -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img v-if="post.user?.profile_photo_url" :src="post.user.profile_photo_url"
                                        :alt="post.user.name" class="w-10 h-10 rounded-full object-cover" />
                                    <div v-else
                                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                        <UserIcon class="w-5 h-5 text-white" />
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold">{{ post.user?.name || 'Utilisateur' }}</h4>
                                        <p class="text-white/60 text-sm">{{ formatDate(post.created_at) }}</p>
                                    </div>
                                </div>
                                <!-- Menu d'options pour les posts de l'utilisateur connecté -->
                                <div v-if="auth.user && auth.user.id === post.user_id" class="relative">
                                    <button @click="togglePostMenu(post.id)"
                                        class="text-white/60 hover:text-white transition-colors duration-300 p-2 rounded-lg hover:bg-white/10">
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
                            <div class="space-y-3">
                                <p class="text-white leading-relaxed">{{ post.content }}</p>
                                <img v-if="post.image_path" :src="post.image_path" :alt="'Image du post'"
                                    class="rounded-lg max-w-full">
                            </div>

                            <!-- Commentaires -->
                            <div class="space-y-3">
                                <div v-if="post.comments && post.comments.length > 0">
                                    <h5 class="text-white/80 font-semibold text-sm">{{ post.comments.length }} commentaire(s)</h5>
                                    <div class="space-y-3">
                                        <div v-for="comment in post.comments" :key="comment.id"
                                            class="bg-white/5 rounded-lg p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-2">
                                                    <img v-if="comment.user?.profile_photo_url"
                                                        :src="comment.user.profile_photo_url" :alt="comment.user.name"
                                                        class="w-6 h-6 rounded-full object-cover">
                                                    <div v-else
                                                        class="w-6 h-6 bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">{{ comment.user.name.charAt(0) }}</span>
                                                    </div>
                                                    <span class="text-white font-semibold text-sm">{{ comment.user.name }}</span>
                                                    <span class="text-white/60 text-xs">{{ formatDate(comment.created_at) }}</span>
                                                </div>
                                                <!-- Menu d'options pour les commentaires de l'utilisateur connecté -->
                                                <div v-if="auth.user && auth.user.id === comment.user_id" class="relative">
                                                    <button @click="toggleCommentMenu(comment.id)"
                                                        class="text-white/60 hover:text-white transition-colors duration-300 p-1 rounded">
                                                        <EllipsisVerticalIcon class="w-4 h-4" />
                                                    </button>
                                                    <!-- Menu déroulant -->
                                                    <div v-if="activeCommentMenu === comment.id"
                                                        class="absolute right-0 top-full mt-1 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg border border-white/20 z-10 min-w-[120px]">
                                                        <button @click="deleteComment(comment.id)"
                                                            class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300 flex items-center space-x-2 text-sm">
                                                            <TrashIcon class="w-3 h-3" />
                                                            <span>Supprimer</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-white/90 text-sm">{{ comment.content }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Formulaire d'ajout de commentaire -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                                        <img v-if="auth.user?.profile_photo_url" :src="auth.user.profile_photo_url"
                                            :alt="auth.user.name" class="w-full h-full object-cover">
                                        <div v-else
                                            class="w-full h-full bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ auth.user?.name?.charAt(0) || 'U' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex items-center space-x-2">
                                        <input v-model="newComments[post.id]" type="text"
                                            :placeholder="auth.user ? 'Ajouter un commentaire...' : 'Connectez-vous pour commenter'"
                                            :disabled="!auth.user"
                                            class="flex-1 bg-white/20 text-white placeholder-white/60 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 disabled:opacity-50">
                                        <button @click="addComment(post.id)" :disabled="!auth.user || !newComments[post.id]?.trim()"
                                            class="bg-purple-600 hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-3 py-2 rounded-lg text-sm transition-all duration-300">
                                            Publier
                                        </button>
                                    </div>
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
        </section>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
    UserIcon,
    HeartIcon,
    UserGroupIcon,
    MusicalNoteIcon,
    PlayIcon,
    EllipsisVerticalIcon,
    ChatBubbleLeftIcon
} from '@heroicons/vue/24/outline'

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

const activeTab = ref('sounds')

// Variables réactives pour les posts et commentaires
const showCreatePost = ref(false)
const newPostContent = ref('')
const newComments = ref({})
const activePostMenu = ref(null)
const activeCommentMenu = ref(null)

// Computed properties
const userLikesCount = computed(() => {
    return props.userTracks.reduce((total, track) => total + (track.likes_count || 0), 0)
})

const userPlaysCount = computed(() => {
    return props.userTracks.reduce((total, track) => total + (track.views || 0), 0)
})

const isOwnProfile = computed(() => {
    return props.auth.user && props.auth.user.id === props.user.id
})

// Méthodes
const formatDate = (dateString) => {
    if (!dateString) return 'Date inconnue'
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const formatNumber = (num) => {
    if (!num || isNaN(num)) return '0'
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M'
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
}

// Fonctions pour les posts et commentaires
const createPost = async () => {
    if (!newPostContent.value.trim()) return

    try {
        const response = await fetch('/posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                content: newPostContent.value
            })
        })

        if (response.ok) {
            newPostContent.value = ''
            showCreatePost.value = false
            // Émettre un événement pour recharger les posts
            emit('post-created')
        }
    } catch (error) {
        console.error('Erreur lors de la création du post:', error)
    }
}

const addComment = async (postId) => {
    const content = newComments.value[postId]
    if (!content || !content.trim()) return

    try {
        const response = await fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                content: content
            })
        })

        if (response.ok) {
            newComments.value[postId] = ''
            // Émettre un événement pour recharger les posts
            emit('comment-added')
        }
    } catch (error) {
        console.error('Erreur lors de l\'ajout du commentaire:', error)
    }
}

const deletePost = async (postId) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce post ?')) return

    try {
        const response = await fetch(`/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            // Émettre un événement pour recharger les posts
            emit('post-deleted')
        }
    } catch (error) {
        console.error('Erreur lors de la suppression du post:', error)
    }
}

const deleteComment = async (commentId) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) return

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        if (response.ok) {
            // Émettre un événement pour recharger les posts
            emit('comment-deleted')
        }
    } catch (error) {
        console.error('Erreur lors de la suppression du commentaire:', error)
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

const emit = defineEmits(['play', 'like', 'add-to-playlist', 'toggle-follow', 'edit-profile', 'post-created', 'comment-added', 'post-deleted', 'comment-deleted'])
</script>

<style scoped>
/* Scrollbar personnalisée pour mobile */
.overflow-x-auto::-webkit-scrollbar {
    height: 4px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>
