// On récupère tous les pseudso
const userNames = document.getElementsByClassName('slidableText');
const userNamesCopy = []; // On stockera les clones des pseudos qui sont en train de slide

const userNamesCenter = document.getElementsByClassName('slidableTextCenter');
const userNamesCenterCopy = []; // On stockera les clones des pseudos qui sont en train de slide


// Action lancez quand livewire render
window.addEventListener('user-dashboard-change', () => {
    SlideText();
})

// Fonction qui s'occupe d'ajouter ou retirer le slide
function SlideText() {

    // Pour chaque pseudo
    for(let i = 0; i<userNames.length; i++)
    {
        // Si le nom est plus grand que la div parent, alors on ajoute le slide
        if(userNames[i].getBoundingClientRect().width > userNames[i].parentElement.getBoundingClientRect().width) {

            // S'il a déjà un slide, on skip
            if(userNamesCenterCopy[i]){
                continue;
            }

            // Sinon, on clone le text, puis remove la class pour éviter un crash
            userNamesCenterCopy[i] = userNames[i].cloneNode(true);
            userNamesCenterCopy[i].classList.remove('slidableText');

            // Met le clone en tant que petit frére du pseudo originel
            userNames[i].parentNode.appendChild(userNamesCenterCopy[i]);

            // Puis ajoute l'animation aux deux
            userNames[i].classList.add('animate-textSlide');
            userNamesCenterCopy[i].classList.add('animate-textSlide');

        }
        else if(userNamesCenterCopy[i]) { // Si le texte est plus petit que la div, mais était en train de slide, on l'arrête

            // On enlève la class de slide au pseudo originel, puis supprime le clone ainsi que sa place dans l'array
            userNames[i].classList.remove('animate-textSlide');
            userNamesCenterCopy[i].remove();
            delete userNamesCenterCopy[i];
        }
    }

    // Pour chaque pseudo
    for(let i = 0; i<userNamesCenter.length; i++)
    {
        // Si le nom est plus grand que la div parent, alors on ajoute le slide
        if(userNamesCenter[i].getBoundingClientRect().width > userNamesCenter[i].parentElement.getBoundingClientRect().width) {

            // S'il a déjà un slide, on skip
            if(userNamesCopy[i]){
                continue;
            }

            // Sinon, on clone le text, puis remove la class pour éviter un crash
            userNamesCopy[i] = userNamesCenter[i].cloneNode(true);
            userNamesCopy[i].classList.remove('slidableTextCenter');

            // Met le clone en tant que petit frére du pseudo originel
            userNamesCenter[i].parentNode.appendChild(userNamesCopy[i]);

            // Puis ajoute l'animation aux deux
            userNamesCenter[i].classList.add('animate-textSlide');
            userNamesCopy[i].classList.add('animate-textSlide');

        }
        else if(userNamesCopy[i]) { // Si le texte est plus petit que la div, mais était en train de slide, on l'arrête

            // On enlève la class de slide au pseudo originel, puis supprime le clone ainsi que sa place dans l'array
            userNamesCenter[i].classList.remove('animate-textSlide');
            userNamesCenter[i].parentNode.classList.add('justify-center');
            userNamesCopy[i].remove();
            delete userNamesCopy[i];
        }
        else
        {
            userNamesCenter[i].parentNode.classList.add('justify-center');
        }
    }
}

export default SlideText;
