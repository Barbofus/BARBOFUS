const slope = document.querySelector('.js-slope');
const subject = document.getElementsByClassName('js-subject');
const subjectR = document.getElementsByClassName('js-subject-r');

init();

new ResizeObserver(([{ contentRect: { width, height }}]) => {
    reposition(width, height);
}).observe(slope);

function init()
{
    reposition(slope.getBoundingClientRect().width, slope.getBoundingClientRect().height);

    for (let i = 0; i<subject.length; i++) {
        subject[i].classList.add('animate-opacityFade', '[--custom-animation-time:0.5s]');
    }

    for (let i = 0; i<subjectR.length; i++) {
        subjectR[i].classList.add('animate-opacityFade', '[--custom-animation-time:0.5s]');
    }
}

function reposition(width, height)
{
    for (let i = 0; i<subject.length; i++) {
        subject[i].style.bottom = ((height * 0.8) / width) * (width - subject[i].getBoundingClientRect().right + (subject[i].getBoundingClientRect().width / 2)) + (height * 0.2) + 'px';
    }

    for (let i = 0; i<subjectR.length; i++) {
        subjectR[i].style.bottom = (((height * 0.8) / width) * (subjectR[i].getBoundingClientRect().left + (subjectR[i].getBoundingClientRect().width / 2)) + (height * 0.2)) - height * 0.8 + 'px';
    }
}
