<!-- Bouton d'installation PWA -->
<div id="pwa-install-container" class="hidden fixed bottom-4 right-4 z-50">
    <button 
        id="pwa-install-button" 
        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 min-h-[44px] min-w-[44px]"
        aria-label="Installer l'application Tikehub"
    >
        <i class="fas fa-download text-lg"></i>
        <span class="hidden sm:inline">Installer l'app</span>
    </button>
</div>

<script>
(function() {
    let deferredPrompt;
    const installContainer = document.getElementById('pwa-install-container');
    const installButton = document.getElementById('pwa-install-button');
    
    // Vérifier si l'app est déjà installée
    if (window.matchMedia('(display-mode: standalone)').matches || 
        window.navigator.standalone === true) {
        // L'app est déjà installée, ne pas afficher le bouton
        return;
    }
    
    // Écouter l'événement beforeinstallprompt
    window.addEventListener('beforeinstallprompt', (e) => {
        // Empêcher l'affichage automatique de la bannière
        e.preventDefault();
        deferredPrompt = e;
        
        // Afficher le bouton d'installation
        if (installContainer) {
            installContainer.classList.remove('hidden');
        }
    });
    
    // Gérer le clic sur le bouton d'installation
    if (installButton) {
        installButton.addEventListener('click', async () => {
            if (!deferredPrompt) {
                return;
            }
            
            // Afficher la boîte de dialogue d'installation
            deferredPrompt.prompt();
            
            // Attendre la réponse de l'utilisateur
            const { outcome } = await deferredPrompt.userChoice;
            
            if (outcome === 'accepted') {
                console.log('L\'utilisateur a accepté l\'installation de l\'app');
                // Masquer le bouton après installation
                if (installContainer) {
                    installContainer.classList.add('hidden');
                }
            } else {
                console.log('L\'utilisateur a refusé l\'installation de l\'app');
            }
            
            // Réinitialiser la variable
            deferredPrompt = null;
        });
    }
    
    // Masquer le bouton si l'app est installée
    window.addEventListener('appinstalled', () => {
        console.log('L\'application a été installée avec succès');
        deferredPrompt = null;
        if (installContainer) {
            installContainer.classList.add('hidden');
        }
    });
})();
</script>

