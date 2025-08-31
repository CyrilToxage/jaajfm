<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, KeyIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <Head title="Authentification à deux facteurs - JaaJ FM" />

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
                        <LockClosedIcon class="w-8 h-8 text-white" />
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Authentification à deux facteurs</h1>
                    <p class="text-white/80">Confirmez l'accès à votre compte.</p>
                </div>

                <!-- Carte du formulaire -->
                <div class="glass rounded-2xl p-8">
                    <div class="mb-6 text-sm text-white/80">
                        <template v-if="!recovery">
                            Veuillez confirmer l'accès à votre compte en saisissant le code d'authentification fourni par votre application d'authentification.
                        </template>

                        <template v-else>
                            Veuillez confirmer l'accès à votre compte en saisissant l'un de vos codes de récupération d'urgence.
                        </template>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div v-if="!recovery">
                            <label for="code" class="block text-white font-medium mb-2">Code d'authentification</label>
                            <input
                                id="code"
                                ref="codeInput"
                                v-model="form.code"
                                type="text"
                                inputmode="numeric"
                                autofocus
                                autocomplete="one-time-code"
                                class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400"
                                placeholder="123456"
                            />
                            <div v-if="form.errors.code" class="mt-2 text-red-400 text-sm">
                                {{ form.errors.code }}
                            </div>
                        </div>

                        <div v-else>
                            <label for="recovery_code" class="block text-white font-medium mb-2">Code de récupération</label>
                            <input
                                id="recovery_code"
                                ref="recoveryCodeInput"
                                v-model="form.recovery_code"
                                type="text"
                                autocomplete="one-time-code"
                                class="w-full px-4 py-3 rounded-xl bg-white/90 backdrop-blur-lg border border-white/30 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400"
                                placeholder="Code de récupération"
                            />
                            <div v-if="form.errors.recovery_code" class="mt-2 text-red-400 text-sm">
                                {{ form.errors.recovery_code }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                type="button"
                                @click.prevent="toggleRecovery"
                                class="text-white/80 hover:text-white transition-colors text-sm"
                            >
                                <template v-if="!recovery">
                                    Utiliser un code de récupération
                                </template>

                                <template v-else>
                                    Utiliser un code d'authentification
                                </template>
                            </button>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ form.processing ? 'Connexion...' : 'Se connecter' }}
                            </button>
                        </div>
                    </form>

                    <!-- Lien de retour -->
                    <div class="mt-6 text-center">
                        <a
                            :href="route('login')"
                            class="inline-flex items-center text-white/80 hover:text-white transition-colors"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Retour à la connexion
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
