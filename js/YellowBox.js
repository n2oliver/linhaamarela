class YellowBox extends GameObject {
    
    defaultShotType = {
        width: "8px",
        height: "20px",
        "background-color": "lightyellow",
        "border-radius": "100%",
        "box-shadow": "#ffffff 0px 0px 10px 10px",
        position: "fixed",
        left: document.getElementById("yellow-box").offsetLeft + 24 + "px",
        top: document.getElementById("yellow-box").offsetTop + "px",
        "background": "white"
    };
    shotType = {
        width: "8px",
        height: "20px",
        "background-color": "lightyellow",
        "border-radius": "100%",
        "box-shadow": "#ffffff 0px 0px 10px 10px",
        position: "fixed",
        left: document.getElementById("yellow-box").offsetLeft + 24 + "px",
        top: document.getElementById("yellow-box").offsetTop + "px",
        "background": "white"
    };
    greatShotType = {
        width: "50px",
        height: "50px",
        background: "radial-gradient(#fff, transparent, #fff, transparent, #fff)"
    }

    constructor(attributes){
        super(attributes);

        this.positionY = 60;
        Object.assign(document.getElementById(attributes.id).style, { 
            transform: "translateX(-40px)",
            position: "fixed",
            "background-size": "contain",
            "background-repeat": "no-repeat",
            "background-image": "url(/jogos/linhaamarela/img/linha.png)"
        });
        this.updatePosition = function(event, gameObject = this) {
            let xOffset = event.pageX;
            if(isNaN(event.pageX) && event.center) {
                xOffset = event.center.x
            }
            if(xOffset) {
                let positionX = xOffset;
                positionX = xOffset > 8 ? positionX : 8;
                
                const styles = {
                    top: (window.innerHeight - gameObject.attributes.positionY) + "px",
                    left: positionX + "px",
                }
                Object.assign(document.getElementById(gameObject.attributes.id).style, styles);
                Object.assign(this.shotType, styles);
            }
            
        }
        
        this.mouseMove = (e) => {
            if(!window.pause && !window.gameOver) {  
                this.updatePosition(e, this);
                document.getElementById('platform').style.top = parseInt(document.getElementById('yellow-box').style.top) - 24 + 'px';
            }
        }
        this.shot = (e, shotType) => {
            
            if(!window.pause && !window.gameOver) { 
                let capsule = document.createElement("DIV");
                capsule.id = "capsule";
                capsule.classList.add("capsule");
                Object.assign(capsule.style, shotType);
                document.body.appendChild(capsule);
                window.game.audioManager.playShot();
                let shoting = setInterval(()=>{
                    if(!window.pause) { 
                        if(document.getElementById("capsule") && document.getElementById("capsule").offsetTop < 20) {
                            clearInterval(shoting);
                            document.getElementById("capsule").remove()
                        }
                        for(let item of document.getElementsByClassName("capsule")) {
                            item.style.top = (item.offsetTop - 15) + "px";
                        }
                    }
                }, 100)         
            }
        }
        this.updateShot = (shotType) => {
            Object.assign(window.game.yellowBox.shotType, shotType);
        }
    }
}