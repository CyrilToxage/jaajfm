<template>
    <div class="music-comments glass">
        <div class="comments-header">
            <h3 class="text-xl font-bold text-white mb-2">Commentaires</h3>
            <p class="text-white/60 text-sm">{{ comments.length }} commentaire(s)</p>
        </div>

        <!-- Formulaire d'ajout de commentaire -->
        <div class="comment-form mb-6">
            <div class="flex gap-3">
                <div class="user-avatar">
                    <img v-if="user?.profile_photo_url" :src="user.profile_photo_url" :alt="user.name"
                        class="w-10 h-10 rounded-full object-cover">
                    <div v-else
                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                        <UserIcon class="w-5 h-5 text-white" />
                    </div>
                </div>
                <div class="flex-1">
                    <textarea v-model="newComment" @keydown.ctrl.enter="submitComment"
                        placeholder="Ajouter un commentaire..." class="comment-input" rows="3"></textarea>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-white/40 text-xs">Ctrl+Entrée pour envoyer</span>
                        <button @click="submitComment" :disabled="!newComment.trim() || isSubmitting"
                            class="submit-btn">
                            <PaperAirplaneIcon v-if="!isSubmitting" class="w-4 h-4" />
                            <div v-else
                                class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin"></div>
                            Envoyer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des commentaires -->
        <div class="comments-list space-y-4">
            <div v-if="comments.length === 0" class="text-center py-8">
                <ChatBubbleLeftIcon class="w-12 h-12 text-white/40 mx-auto mb-3" />
                <p class="text-white/60">Aucun commentaire pour le moment</p>
                <p class="text-white/40 text-sm">Soyez le premier à commenter !</p>
            </div>

            <div v-for="comment in comments" :key="comment.id" class="comment-item">
                <div class="flex gap-3">
                    <div class="user-avatar">
                        <img v-if="comment.user?.profile_photo_url" :src="comment.user.profile_photo_url"
                            :alt="comment.user.name" class="w-10 h-10 rounded-full object-cover">
                        <div v-else
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <UserIcon class="w-5 h-5 text-white" />
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="comment-header">
                            <span class="comment-author">{{ comment.user?.name || 'Utilisateur' }}</span>
                            <span class="comment-date">{{ formatDate(comment.created_at) }}</span>
                        </div>

                        <div class="comment-content">
                            <p class="text-white/90">{{ comment.content }}</p>
                        </div>

                        <div class="comment-actions">
                            <button @click="likeComment(comment)" class="action-btn"
                                :class="{ 'liked': comment.is_liked }">
                                <HeartIcon v-if="!comment.is_liked" class="w-4 h-4" />
                                <HeartSolidIcon v-else class="w-4 h-4" />
                                <span>{{ comment.likes_count || 0 }}</span>
                            </button>

                            <button @click="replyToComment(comment)" class="action-btn">
                                <ChatBubbleLeftIcon class="w-4 h-4" />
                                Répondre
                            </button>

                            <button @click="reportComment(comment)" class="action-btn text-orange-400">
                                <ExclamationTriangleIcon class="w-4 h-4" />
                                Signaler
                            </button>

                            <button v-if="canDeleteComment(comment)" @click="deleteComment(comment)"
                                class="action-btn text-red-400">
                                <TrashIcon class="w-4 h-4" />
                                Supprimer
                            </button>
                        </div>

                        <!-- Réponses -->
                        <div v-if="comment.replies && comment.replies.length > 0" class="replies mt-3 ml-4 space-y-3">
                            <div v-for="reply in comment.replies" :key="reply.id" class="reply-item">
                                <div class="flex gap-2">
                                    <div class="user-avatar">
                                        <img v-if="reply.user?.profile_photo_url" :src="reply.user.profile_photo_url"
                                            :alt="reply.user.name" class="w-8 h-8 rounded-full object-cover">
                                        <div v-else
                                            class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                            <UserIcon class="w-4 h-4 text-white" />
                                        </div>
                                    </div>

                                    <div class="flex-1">
                                        <div class="comment-header">
                                            <span class="comment-author text-sm">{{ reply.user?.name || 'Utilisateur'
                                                }}</span>
                                            <span class="comment-date text-xs">{{ formatDate(reply.created_at) }}</span>
                                        </div>

                                        <div class="comment-content">
                                            <p class="text-white/80 text-sm">{{ reply.content }}</p>
                                        </div>

                                        <div class="comment-actions">
                                            <button @click="likeComment(reply)" class="action-btn"
                                                :class="{ 'liked': reply.is_liked }">
                                                <HeartIcon v-if="!reply.is_liked" class="w-3 h-3" />
                                                <HeartSolidIcon v-else class="w-3 h-3" />
                                                <span class="text-xs">{{ reply.likes_count || 0 }}</span>
                                            </button>

                                            <button @click="reportComment(reply)" class="action-btn text-orange-400">
                                                <ExclamationTriangleIcon class="w-3 h-3" />
                                            </button>

                                            <button v-if="canDeleteComment(reply)" @click="deleteComment(reply)"
                                                class="action-btn text-red-400">
                                                <TrashIcon class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire de réponse -->
                        <div v-if="replyingTo === comment.id" class="reply-form mt-3">
                            <textarea v-model="replyContent" @keydown.ctrl.enter="submitReply(comment)"
                                placeholder="Écrire une réponse..." class="comment-input text-sm" rows="2"></textarea>
                            <div class="flex justify-between items-center mt-2">
                                <button @click="cancelReply" class="cancel-btn">Annuler</button>
                                <button @click="submitReply(comment)" :disabled="!replyContent.trim() || isSubmitting"
                                    class="submit-btn">
                                    Répondre
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="hasMoreComments" class="load-more mt-6 text-center">
            <button @click="loadMoreComments" :disabled="isLoadingMore" class="load-more-btn">
                <div v-if="isLoadingMore"
                    class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin mr-2"></div>
                Charger plus de commentaires
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
    UserIcon, PaperAirplaneIcon, ChatBubbleLeftIcon,
    HeartIcon, TrashIcon, ExclamationTriangleIcon
} from '@heroicons/vue/24/outline'
import { HeartIcon as HeartSolidIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    comments: {
        type: Array,
        default: () => []
    },
    user: {
        type: Object,
        default: null
    },
    hasMoreComments: {
        type: Boolean,
        default: false
    },
    isLoadingMore: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits([
    'submit-comment', 'submit-reply', 'like-comment',
    'delete-comment', 'load-more', 'report-comment'
])

// État local
const newComment = ref('')
const replyContent = ref('')
const replyingTo = ref(null)
const isSubmitting = ref(false)

// Méthodes
const submitComment = async () => {
    if (!newComment.value.trim() || isSubmitting.value) return

    isSubmitting.value = true
    try {
        await emit('submit-comment', newComment.value.trim())
        newComment.value = ''
    } finally {
        isSubmitting.value = false
    }
}

const submitReply = async (comment) => {
    if (!replyContent.value.trim() || isSubmitting.value) return

    isSubmitting.value = true
    try {
        await emit('submit-reply', {
            commentId: comment.id,
            content: replyContent.value.trim()
        })
        replyContent.value = ''
        replyingTo.value = null
    } finally {
        isSubmitting.value = false
    }
}

const replyToComment = (comment) => {
    replyingTo.value = comment.id
    replyContent.value = ''
}

const cancelReply = () => {
    replyingTo.value = null
    replyContent.value = ''
}

const likeComment = (comment) => {
    emit('like-comment', comment.id)
}

const deleteComment = (comment) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
        emit('delete-comment', comment.id)
    }
}

const loadMoreComments = () => {
    emit('load-more')
}

const canDeleteComment = (comment) => {
    return props.user && (
        comment.user_id === props.user.id ||
        props.user.role === 'admin'
    )
}

const reportComment = (comment) => {
    emit('report-comment', comment)
}

const formatDate = (date) => {
    const now = new Date()
    const commentDate = new Date(date)
    const diffInHours = (now - commentDate) / (1000 * 60 * 60)

    if (diffInHours < 1) {
        const diffInMinutes = Math.floor((now - commentDate) / (1000 * 60))
        return `il y a ${diffInMinutes} min`
    } else if (diffInHours < 24) {
        return `il y a ${Math.floor(diffInHours)}h`
    } else if (diffInHours < 168) { // 7 jours
        return `il y a ${Math.floor(diffInHours / 24)}j`
    } else {
        return commentDate.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        })
    }
}
</script>

<style scoped>
.music-comments {
    @apply p-6 rounded-2xl border border-white/20;
}

.comments-header {
    @apply mb-6 pb-4 border-b border-white/20;
}

.comment-form {
    @apply mb-6;
}

.user-avatar {
    @apply flex-shrink-0;
}

.comment-input {
    @apply w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/50 resize-none focus:outline-none focus:border-white/40 transition-colors;
}

.submit-btn {
    @apply flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:scale-105 transition-all disabled:opacity-50 disabled:cursor-not-allowed;
}

.cancel-btn {
    @apply px-4 py-2 text-white/60 hover:text-white transition-colors;
}

.comment-item {
    @apply pb-4 border-b border-white/10 last:border-b-0;
}

.comment-header {
    @apply flex items-center gap-2 mb-2;
}

.comment-author {
    @apply text-white font-medium text-sm;
}

.comment-date {
    @apply text-white/40 text-xs;
}

.comment-content {
    @apply mb-3;
}

.comment-actions {
    @apply flex items-center gap-4;
}

.action-btn {
    @apply flex items-center gap-1 text-white/60 hover:text-white transition-colors text-sm;
}

.action-btn.liked {
    @apply text-pink-500;
}

.replies {
    @apply border-l-2 border-white/10 pl-4;
}

.reply-item {
    @apply pb-3 border-b border-white/5 last:border-b-0;
}

.reply-form {
    @apply ml-4;
}

.load-more-btn {
    @apply flex items-center justify-center w-full px-6 py-3 bg-white/10 border border-white/20 rounded-xl text-white hover:bg-white/20 transition-colors disabled:opacity-50;
}

/* Responsive */
@media (max-width: 640px) {
    .music-comments {
        @apply p-4;
    }

    .comment-actions {
        @apply gap-2;
    }

    .action-btn {
        @apply text-xs;
    }
}
</style>
