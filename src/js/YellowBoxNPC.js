class YellowBoxNPC extends GameObject {
    constructor(attributes){
        super(attributes);

        this.positionY = 120;
        Object.assign(document.getElementById(attributes.id).style, { 
            transform: "translateX(-16px)",
            position: "fixed",
            border: "#000 solid 2px",
            "border-radius": "6px"
        });
        this.updatePosition = function(gameObject = this) {
            const styles = {
                bottom: (window.outerHeight - gameObject.attributes.positionY) + "px",
                left: document.getElementById(window.ball.attributes.id).offsetLeft + "px",
            }
            Object.assign(document.getElementById(gameObject.attributes.id).style, styles);
        }
    }
}