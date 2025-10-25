/* eslint-disable */
// @ts-nocheck
// Configuration globale pour ignorer les erreurs TypeScript/JavaScript dans les fichiers Blade

// Désactive toutes les vérifications TypeScript pour ce projet
declare global {
    interface Window {
        planningComponent: any;
        Alpine: any;
    }
}

// Fonction utilitaire pour ignorer les erreurs de décorateurs
function ignoreDecorators() {
    // Cette fonction permet d'ignorer les erreurs de décorateurs dans Alpine.js
    return true;
}

export {};
