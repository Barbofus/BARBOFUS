
const header = document.getElementById('header');
const navbar = document.getElementById('navbar');

const leftSection = document.getElementById('left-section');
const twitchScreen = document.getElementById('twitch-screen');
const twitchContainer = document.getElementById('twitch-container');

const skinWinners = document.getElementById('rewards-section');

const footer = document.getElementById('footer');

const toRemove = navbar.getBoundingClientRect().height + footer.getBoundingClientRect().height;
let ratioWidth = true;
let previousRatioWidth = true;
let previousLeftSectionH;
let previousRewardSectionH;


// Fonction qui change la hauter de la section de gauche en fonction de l'espace libre
function ResizeSkinWinners()
{
    if(window.innerWidth < 1800 ) {
        if(skinWinners.style.height != '100%') {
            skinWinners.style.height = "100%";
        }
        return;
    }

    // Calcule la hauteur visible du header
    const headerHeight = header.getBoundingClientRect().height + header.getBoundingClientRect().top;
    let nextHeight = window.innerHeight - footer.getBoundingClientRect().height;

    // S'il est visible, on le soustrait a notre hauteur total
    if(headerHeight > 0) {
        nextHeight -= headerHeight;
    }

    // Ensuite, on envoie
    skinWinners.style.height = nextHeight + "px";
    skinWinners.style.top = (window.innerHeight - nextHeight) + "px";

    previousRewardSectionH = skinWinners.style.height;
}


// Fonction qui change la hauter de la section de gauche en fonction de l'espace libre
function ResizeLeftSection()
{
    if(window.innerWidth < 1501 ) {
        if(leftSection.style.height != '100%') {
            leftSection.style.height = "100%";
        }
        return;
    }

    // Calcule la hauteur visible du header
    const headerHeight = header.getBoundingClientRect().height + header.getBoundingClientRect().top;
    let nextHeight = window.innerHeight - toRemove;

    // S'il est visible, on le soustrait a notre hauteur total
    if(headerHeight > 0) {
        nextHeight -= headerHeight;
    }

    // Ensuite, si le nouvel height et différent de l'ancienne, on envoie
    if(previousLeftSectionH != nextHeight + "px"){

        leftSection.style.height = nextHeight + "px";

        previousLeftSectionH = leftSection.style.height;

        // Check s'il y a besoin de changer le format du live
        ResizeTwitchScreen();
    }
}


// Fonction qui actualise sur quel axe l'aspect-video du live se base (width or height)
function ResizeTwitchScreen()
{
    // Si la hauteur de la div parent est supérieur à la largeur / 16 * 9 (donc peut accueillir un format 16/9 basé sur la largeur) alors on base l'aspect-video sur le width
    ratioWidth = twitchContainer.getBoundingClientRect().width / 16 * 9 < twitchContainer.getBoundingClientRect().height;

    // S'il doit être basé sur la hauteur et ne l'es pas déjà
    if(ratioWidth != previousRatioWidth) {
        twitchScreen.classList.toggle("h-full");
        twitchScreen.classList.toggle("w-full");
        previousRatioWidth = !previousRatioWidth;
    }
}


export {ResizeSkinWinners, ResizeLeftSection};
