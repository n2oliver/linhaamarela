class Ball extends GameObject {
    constructor(attributes){
        super(attributes);
        this.build = function(attributes) {
            const styles = {
                borderRadius: attributes.width + "px",
                transform: "translateX(16px)"
            }
            Object.assign(document.getElementById(attributes.id).style, styles);
        }
        this.init = function(attributes) {
            let paraAEsquerda = true;
            let paraADireita = false;
            let paraCima = true;
            let paraBaixo = false;
            return setInterval(() => {
                const objectStyle = document.getElementById(attributes.id).style;
                const limiteHorizontalInferior = window.innerHeight - 120;
                const supportBarLeft = document.getElementById(attributes.supportBarId).offsetLeft;
                const supportBarRight = supportBarLeft + parseInt(document.getElementById(attributes.supportBarId).style.width) + 2;
                const top = parseInt(document.getElementById(attributes.id).offsetTop);
                const left = parseInt(document.getElementById(attributes.id).offsetLeft);
                const right = left + attributes.width;
                const height = parseInt(attributes.height) + 2;

                if(left <= 0) {
                    paraAEsquerda = false;
                    paraADireita = true;
                }
                if(!paraADireita){
                    paraAEsquerda = true;
                    paraADireita = false;
                }

                if(top <= 0) {
                    paraCima = false;
                    paraBaixo = true;
                }
                if(!paraBaixo){
                    paraCima = true;
                    paraBaixo = false;
                }

                if(left >= (window.innerWidth - height)) {
                    paraAEsquerda = true;
                    paraADireita = false;
                }
                if(!paraAEsquerda){
                    paraAEsquerda = false;
                    paraADireita = true;
                }

                if(top + height >= limiteHorizontalInferior && top <= limiteHorizontalInferior && right >= supportBarLeft && left <= supportBarRight) {
                    paraCima = true;
                    paraBaixo = false;
                } 
                if(!paraCima){
                    paraCima = false;
                    paraBaixo = true;
                }

                let direction = 3;
                if(paraAEsquerda) {
                    direction = -3;
                }
                
                objectStyle.left = (left + direction * attributes.velocity) + "px";
                
                if(paraCima) {
                    objectStyle.top = (top - 2 * attributes.velocity) + "px";
                } else if(paraBaixo) {
                    objectStyle.top = (top + 2 * attributes.velocity) + "px";
                }
            }, 50);
        }
    }
}