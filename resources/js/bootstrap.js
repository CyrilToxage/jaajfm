import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuration Echo pour Laravel Reverb/Pusher
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Vérifier si les clés Pusher sont configurées
const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER;

function createFakeEcho() {
    // Créer un objet Echo factice pour éviter les erreurs
    window.Echo = {
        channel: () => ({
            listen: () => ({})
        })
    };
}

if (pusherKey && pusherKey !== 'your-pusher-key' && pusherCluster) {
    try {
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: pusherKey,
            cluster: pusherCluster,
            forceTLS: true
        });
        console.log('✅ Broadcasting activé avec Pusher');
    } catch (error) {
        console.warn('⚠️ Erreur lors de l\'initialisation Pusher:', error.message);
        createFakeEcho();
    }
} else {
    console.warn('⚠️ Clés Pusher non configurées');
    console.warn('⚠️ La radio fonctionnera en mode local avec polling');
    createFakeEcho();
}
