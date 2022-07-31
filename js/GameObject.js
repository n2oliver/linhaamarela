class GameObject {
    attributes;
    constructor(attributes){
        this.attributes = attributes;

        const styles = {
            width: attributes.width + "px",
            height: attributes.height + "px",
            backgroundColor: attributes.color,
            border: attributes.strokeColor + " " + attributes.strokeStyle + " " + attributes.strokeDepth,
            position: attributes.position,
            top: (window.innerHeight - attributes.positionY) + "px",
            left: attributes.positionX
        }
        Object.assign(document.getElementById(attributes.id).style, styles);
    }
}