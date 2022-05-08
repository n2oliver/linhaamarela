class BallBase extends GameObject {
    constructor(attributes){
        super(attributes);
        this.build = function(attributes) {
            const styles = {
                borderRadius: attributes.width + "px",
                transform: "translateX(16px)",
                position: attributes.position,
            }
            Object.assign(document.getElementById(attributes.id).style, styles);
        }
    }
}