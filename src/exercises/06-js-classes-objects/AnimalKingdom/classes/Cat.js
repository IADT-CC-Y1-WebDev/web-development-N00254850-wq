import Animal from "./Animal.js"

class Cat extends Animal {

    constructor(_name, _age){
        super(_name, _age);

    }

        makeNoise(){
        console.log("meowing: meeeeeeeeeeooooowwww")
        }
}

export default Cat;