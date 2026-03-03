import Car from './classes/Car.js'

let bmw = new Car('BMW', '5 series', 2026, 'Green', ['HUD', 'Keyless']);
let bmw2 = new Car('BMW', '5 series', 2026, 'Blue', {});
let audi = new Car('Audi', 'A6', 2026, 'Yellow');

let myCars = [bmw, bmw2, audi];

myCars.forEach((car) => {
    console.log(`${car}`);
    // console.log(car.year);
});
