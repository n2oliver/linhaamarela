class Counter {
    attributes;
    constructor(attributes){
        if(attributes){
            this.attributes = attributes;

            const styles = {
                color: "yellow",
                fontSize: "24px",
                '-webkit-text-stroke': ".3px black"
            }
            Object.assign(document.getElementById(attributes.id).style, styles);
        }
    }
}