class Platform extends GameObject {
    constructor(attributes){
        super(attributes);

        Object.assign(document.getElementById(attributes.id).style, { 
            position: "fixed",
            ...attributes,
            "background-image": "url(/jogos/linhaamarela/img/trail.png)",
            "background-size": "auto 100%", 
        });
    }
}