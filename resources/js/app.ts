// Fichier TypeScript minimal pour satisfaire tsconfig.json
// Ce fichier permet d'éviter l'erreur "Aucune entrée dans le fichier config"

export {};

// Types globaux pour Alpine.js (optionnel)
declare global {
    interface Window {
        Alpine: any;
        planningComponent: () => any;
    }
}