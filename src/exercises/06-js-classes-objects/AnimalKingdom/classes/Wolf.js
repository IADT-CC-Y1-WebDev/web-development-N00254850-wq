import Animal from "./Animal.js"

class Wolf extends Animal {

    constructor(_name, _age){
        super(_name, _age);   
    }

    makeNoise(){
        console.log("Roaring: RAAAAAAAAAAAAAAAAAAAA")
    }

}

export default Wolf;