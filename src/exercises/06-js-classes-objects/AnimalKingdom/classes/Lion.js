import Animal from "./Animal.js"

class Lion extends Animal {

    constructor(_name, _age){
        super(_name, _age);   
    }

    makeNoise(){
        console.log("Roaring: RAAAAAAWWRRRRRR")
    }

}

export default Lion;