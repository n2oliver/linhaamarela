class PointsCounter extends Counter {
    points = 0;
    constructor(attributes) {
        super(attributes);
        this.attributes = attributes;
        const styles = {
            top: "64px",
            left: "32px"
        }
        Object.assign(document.getElementById(attributes.id).parentElement.style, styles);

        this.increaseCounter = (points) => {
            clearTimeout(this.timer);
            this.points += parseInt(points);
            document.getElementById(this.attributes.id).innerText = this.points;

            this.timer = setTimeout(() => {
                $.ajax({
                    url: '/registrar-pontos',
                    method: 'POST',
                    type: 'json/application',
                    data: { userId: sessionStorage.userId, userPoints: this.points},
                }).done((data)=>{
                    sessionStorage.setItem('pontuacao', this.points);
                    console.log(data);
                }).fail((error)=>{
                    console.log(error.responseText);
                });
            },3000); 
        }
    }
    static getHighScores = async () => {
        return $.ajax({
            url: '/obter-pontos',
            method: 'GET',
            type: 'json/application',
            data: { userId: sessionStorage.userId },
        }).done((data)=>{
            return data;
        }).fail((error)=>{
            return error;
        });
    }
}