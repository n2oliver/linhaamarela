class PointsCounter extends Counter {
    points = 0;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            textAlign: "left",
            textShadow: "3px 3px 3px #2e2e3e"
        }
        Object.assign(document.getElementById(attributes.id).style, styles);

        this.increaseCounter = (points) => {
            this.points += parseInt(points);
            document.getElementById(this.attributes.id).innerText = this.points + " pontos";
        }
    }
}