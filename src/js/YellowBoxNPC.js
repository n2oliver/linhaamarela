class YellowBox extends GameObject {
    constructor(attributes){
        super(attributes);

        this.positionY = 120;
        document.getElementById(attributes.id).style.transform = "translateX(-16px)";
        this.updatePosition = function(event, gameObject = this) {
            const xOffset = (event.pageX - 30);
            let positionX = xOffset < window.innerWidth - 60 ? xOffset : window.innerWidth - 60;
            positionX = xOffset > 8 ? positionX : 8;
            
            const styles = {
                bottom: (window.innerHeight - gameObject.attributes.positionY) + "px",
                left: positionX + "px"
            }
            Object.assign(document.getElementById(gameObject.attributes.id).style, styles);
        }
    }
}