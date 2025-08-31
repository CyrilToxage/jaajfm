<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, ShieldCheckIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head title="Zone sécurisée - JaaJ FM" />

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
                        <ShieldCheckIcon class="w-8 h-8 text-white" />
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Zone sécurisée</h1>
                    <p class="text-white/80">Confirmez votre mot de passe pour continuer.</p>
                </div>

                <!-- Carte du formulaire -->
                <div class="glass rounded-2xl p-8">
                    <div class="mb-6 text-sm text-white/80">
                        Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label for="password" class="block text-white font-medium mb-2">Mot de passe</label>
                            <input
                                id="password"
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="current-password"
                                autofocus
                                class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400"
                                placeholder="Votre mot de passe"
                            />
                            <div v-if="form.errors.password" class="mt-2 text-red-400 text-sm">
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ form.processing ? 'Confirmation...' : 'Confirmer' }}
                        </button>
                    </form>

                    <!-- Lien de retour -->
                    <div class="mt-6 text-center">
                        <a
                            :href="route('dashboard')"
                            class="inline-flex items-center text-white/80 hover:text-white transition-colors"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Retour au tableau de bord
                        </a>
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
