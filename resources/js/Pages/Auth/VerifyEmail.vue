<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, EnvelopeIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Vérification d'email - JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse"></div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <div class="flex min-h-screen items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo et titre -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                        <EnvelopeIcon class="w-8 h-8 text-white" />
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Vérification d'email</h1>
                    <p class="text-white/80">Vérifiez votre adresse email pour continuer.</p>
                </div>

                <!-- Carte du formulaire -->
                <div class="glass rounded-2xl p-8">
                    <div class="mb-6 text-sm text-white/80">
                        Avant de continuer, vérifiez votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, nous vous en enverrons un autre.
                    </div>

                    <div v-if="verificationLinkSent" class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                        <p class="text-green-400 text-sm">Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie dans vos paramètres de profil.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ form.processing ? 'Envoi en cours...' : 'Renvoyer l\'email de vérification' }}
                        </button>
                    </form>

                    <!-- Liens de navigation -->
                    <div class="mt-6 flex items-center justify-between">
                        <Link
                            :href="route('profile.show')"
                            class="inline-flex items-center text-white/80 hover:text-white transition-colors"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Modifier le profil
                        </Link>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="text-white/80 hover:text-white transition-colors"
                        >
                            Se déconnecter
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes float-reverse {
    0%, 100% { transform: translateY(0px) rotate(45deg); }
    50% { transform: translateY(20px) rotate(45deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}

.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>
