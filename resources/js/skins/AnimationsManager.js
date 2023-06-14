
AnimateDofus();
AnimateSkinCard();

function IsInViewport(item)
{
    return  item.top >= 0 &&
        item.left >= 0 &&
        item.bottom <= (window.innerHeight || document.documentElement.clientHeight) + item.height &&
        item.right <= (window.innerWidth || document.documentElement.clientWidth) + item.width;
}

function AnimateDofus()
{
    let allDofuses = document.getElementsByClassName('dofus');
    let dofusInView = [];

    for (let i = 0; i < allDofuses.length; i++) {
        if (IsInViewport(allDofuses[i].getBoundingClientRect())) {
            dofusInView.push(allDofuses[i]);
        }
    }

    let dofus = dofusInView[Math.floor(Math.random()*dofusInView.length)];

    dofus.classList.add('animate-dofus');

    setTimeout(() => {
        dofus.classList.remove('animate-dofus')
    }, 2000);

    setTimeout(() => {
        AnimateDofus();
    }, Math.floor(Math.random()*10+5) * 1000);
}

function AnimateSkinCard()
{
    let allSkinsBG = document.getElementsByClassName('skinBackGround');
    let skinsBGInView = [];


    for (let i = 0; i < allSkinsBG.length; i++) {
        if (IsInViewport(allSkinsBG[i].getBoundingClientRect())) {
            skinsBGInView.push(allSkinsBG[i]);
        }
    }

    let skinBG = skinsBGInView[Math.floor(Math.random()*skinsBGInView.length)];

    skinBG.classList.add('animate-skinReflection');

    setTimeout(() => {
        skinBG.classList.remove('animate-skinReflection')
    }, 750);

    setTimeout(() => {
        AnimateSkinCard();
    }, Math.floor(Math.random()*10+5) * 1000);
}
