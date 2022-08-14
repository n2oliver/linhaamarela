class SpaceInvaderNPC {
    init = function (enemyLevel = 16) {
        const spaceInvaders = ['spaceinvaders-red','spaceinvaders-green', 'spaceinvaders-yellow', 'spaceinvaders-blue'];
        for(let i = 100/enemyLevel; i < 100; i += (100/enemyLevel)) {
            let invader = document.createElement('div');
            invader.classList.add("invader");
            invader.classList.add("unselectable");
            invader.style.left = i + "%";
            invader.style.top = "100px";
            invader.style.backgroundImage = "url(img/" + spaceInvaders[Math.floor(Math.random() * spaceInvaders.length)] + ".png)";
            document.body.append(invader);
        }
        
        let left = true;
        return setInterval(function () {
            if(!window.pause) {
                for(let invader of document.getElementsByClassName('invader')) {
                    if (invader.offsetLeft > window.innerWidth - 64) {
                        left = false;
                    }
                    if (invader.offsetLeft < 0) {
                        left = true;
                    }
                    if (left == true) {
                        invader.style.left = (invader.offsetLeft + 10) + "px"
                    } else {
                        invader.style.left = (invader.offsetLeft - 10) + "px"
                    }
                }
            }
        }, 100);
    }    
}