export const showNotification = (message, type = 'info') => {
    // Créer un élément de notification
    const notification = document.createElement('div')
    notification.className = `fixed top-5 right-5 px-5 py-4 rounded-xl z-50 font-bold shadow-lg transform transition-transform duration-300`

    // Styles selon le type
    switch (type) {
        case 'success':
            notification.style.background = 'linear-gradient(to right, #10B981, #059669)'
            break
        case 'error':
            notification.style.background = 'linear-gradient(to right, #EF4444, #DC2626)'
            break
        case 'warning':
            notification.style.background = 'linear-gradient(to right, #F59E0B, #D97706)'
            break

        default:
            notification.style.background = 'linear-gradient(to right, #3B82F6, #2563EB)'
    }

    notification.style.color = 'white'
    notification.textContent = message

    // Ajouter au DOM
    document.body.appendChild(notification)

    // Animation d'entrée
    notification.style.transform = 'translateX(100%)'
    setTimeout(() => {
        notification.style.transform = 'translateX(0)'
    }, 100)

    // Supprimer après 3 secondes
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)'
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification)
            }
        }, 300)
    }, 3000)
}
