class SpaceInvader {
    init = function (level) {
        const spaceInvaders = ['spaceinvaders-red','spaceinvaders-green', 'spaceinvaders-yellow', 'spaceinvaders-blue'];
        for(let i = 100/level; i < 100; i += (100/level)) {
            let invader = document.createElement('div');
            invader.classList.add("invader");
            invader.style.left = i + "%";
            invader.style.backgroundImage = "url(../img/" + spaceInvaders[Math.floor(Math.random() * spaceInvaders.length)] + ".png)";
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
                    Array.from(document.body.children).filter((elem) => {
                        if (elem.nodeType == Node.ELEMENT_NODE && elem.classList.contains("capsule")
                        && (elem.offsetLeft < invader.offsetLeft + invader.clientWidth) &&
                        (elem.offsetLeft + elem.clientWidth > invader.offsetLeft) 
                            &&
                            (elem.offsetTop < invader.offsetTop + invader.clientHeight) &&
                        (elem.offsetTop + elem.clientHeight > invader.offsetTop) 
                    ) {
                        invader.remove()
                        }
                    });
                }
            }
        }, 100);
    }
    destroy = function () {
        for(let invader of Object.assign([], document.getElementsByClassName("invader"))) {
            invader.remove()
        }
    }        
}