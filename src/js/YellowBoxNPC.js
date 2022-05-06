class YellowBoxNPC extends GameObject {
    constructor(attributes){
        super(attributes);

        this.positionY = 120;
        document.getElementById(attributes.id).style.transform = "translateX(-16px)";
        this.updatePosition = function(gameObject = this) {
            const styles = {
                bottom: (window.innerHeight - gameObject.attributes.positionY) + "px",
                left: document.getElementById(window.ball.attributes.id).offsetLeft + "px"
            }
            Object.assign(document.getElementById(gameObject.attributes.id).style, styles);
        }
    }
}