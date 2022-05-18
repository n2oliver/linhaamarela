class YellowBox extends GameObject {
    constructor(attributes){
        super(attributes);

        this.positionY = 120;
        Object.assign(document.getElementById(attributes.id).style, { 
            transform: "translateX(-16px)",
            position: "fixed",
            border: "#000 solid 2px",
            "border-radius": "20px"
        });
        this.updatePosition = function(event, gameObject = this) {
            const xOffset = (event.pageX - 30);
            let positionX = xOffset < window.innerWidth - 60 ? xOffset : window.innerWidth - 60;
            positionX = xOffset > 8 ? positionX : 8;
            
            const styles = {
                top: (window.outerHeight - gameObject.attributes.positionY) + "px",
                left: positionX + "px",
                border: "#000 solid 2px"
            }
            Object.assign(document.getElementById(gameObject.attributes.id).style, styles);
        }
        
        this.mouseMove = (e) => {
            if(!window.pause) {  
                this.updatePosition(e, this);
            }
        }
        this.shot = (e) => {
            
            if(!window.pause) { 
                let capsule = document.createElement("DIV");
                capsule.id = "capsule";
                capsule.classList.add("capsule");
                Object.assign(capsule.style, {
                    width: "8px",
                    height: "20px",
                    "background-color": "purple",
                    position: "fixed",
                    left: document.getElementById("yellow-box").offsetLeft + 24 + "px",
                    top: document.getElementById("yellow-box").offsetTop + "px"
                });
                document.body.appendChild(capsule);
                let shoting = setInterval(()=>{
                    if(!window.pause) { 
                        if(document.getElementById("capsule").offsetTop < 200) {
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
    }
}