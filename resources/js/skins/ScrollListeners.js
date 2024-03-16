import SlideText from "./NameScroll";
import {ResizeSkinWinners, ResizeLeftSection} from "./ResizeIndexComponent";

// Attendre que tous les élements du DOM soit chargés pour modifier du CSS
window.addEventListener('DOMContentLoaded', () => {

    ResizeLeftSection();
    ResizeSkinWinners();
    SlideText();
});

// Action lancez quand livewire render
window.addEventListener('skin-index-render', () => {

    ResizeLeftSection(false);
    ResizeSkinWinners();
    SlideText();
})

// Actualise la taille du live au scroll et au resize de la fenêtre
window.onscroll = function () {

    ResizeLeftSection();
    ResizeSkinWinners();
    SlideText();
};

window.onresize = function () {

    ResizeLeftSection();
    ResizeSkinWinners();
    SlideText();
};
