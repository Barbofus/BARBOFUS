const slider = document.querySelector('.slider');
const slidingCards = document.getElementsByClassName('slidingCard');
const fullWidth = (slider.getBoundingClientRect().width - slider.parentElement.getBoundingClientRect().width) * -1;
let slideSpeed = 0.8;
let isDown = false;
let done = false;
let walk = 0;
let startX;

slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.getBoundingClientRect().left;
});

window.addEventListener('mouseup', () => {

    for (let i =0; i< slidingCards.length; i++)
        slidingCards[i].style.pointerEvents = '';

    if(isDown) window.requestAnimationFrame(slide);

    isDown = false;
    done = false;
});

window.addEventListener('mousemove', (e) => {
    if(!isDown) return;

    if(!done) {
        for (let i = 0; i < slidingCards.length; i++)
            slidingCards[i].style.pointerEvents = 'none';

        done = true;
    }

    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    walk = x - startX;

    // Si on arrive à la limite gauche
    if(walk > 0) {
        walk = (slider.getBoundingClientRect().width / 2)* -1;
        startX = e.pageX - slider.getBoundingClientRect().left;
    }

    // Si on arrive à la limite droite
    if(walk < fullWidth){
        walk = ((slider.getBoundingClientRect().width /2) - slider.parentElement.getBoundingClientRect().width) * -1;
        startX = e.pageX - slider.getBoundingClientRect().left;
    }

    slider.style.transform = 'translate(' + walk +  'px)';
});

window.requestAnimationFrame(slide);


function slide()
{
    if(isDown) return;

    walk -= slideSpeed;

    console.log(walk);

    // Si on arrive à la limite gauche
    if(walk > 0) {
        walk = (slider.getBoundingClientRect().width / 2)* -1;
    }

    // Si on arrive à la limite droite
    if(walk < fullWidth){
        walk = ((slider.getBoundingClientRect().width /2) - slider.parentElement.getBoundingClientRect().width) * -1;
    }

    slider.style.transform = 'translate(' + walk +  'px)';
    window.requestAnimationFrame(slide);
}

