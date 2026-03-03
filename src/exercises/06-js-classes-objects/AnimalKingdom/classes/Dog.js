import Animal from "./Animal.js"

class Dog extends Animal {

    constructor(_name, _age){
        super(_name, _age);

    }

        makeNoise(){
        console.log("Barking: RRRUUUUUUFFFF RUFFF")
    }
}

export default Dog;