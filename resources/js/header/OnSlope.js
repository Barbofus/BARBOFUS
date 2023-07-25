const slope = document.querySelector('.js-slope');
const subject = document.getElementsByClassName('js-subject');

new ResizeObserver(([{ contentRect: { width, height }}]) => {
    for (let i = 0; i<subject.length; i++) {
        subject[i].style.bottom = ((height * 0.8) / width) * (width - subject[i].getBoundingClientRect().right + (subject[i].getBoundingClientRect().width / 2)) + (height * 0.2)+ 'px';
    }
}).observe(slope);
