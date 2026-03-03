import Cat from './classes/Cat.js';
import Dog from './classes/Dog.js';
import Lion from './classes/Lion.js';
import Wolf from './classes/Wolf.js';

let cat = new Cat("Tom", 2);
let dog = new Dog("Jerry", 2);
let lion = new Lion("Sigma", 3);
let wolf = new Wolf("Finn", 4);

let animals = [cat, dog, lion, wolf];

animals.forEach((animal) => {
    animal.makeNoise();
    animal.roam();
    animal.sleep();
    console.log(typeof animal);
    console.log("---------");
});

console.log(dog instanceof Dog);