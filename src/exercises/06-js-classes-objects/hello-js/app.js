console.log("Hello Galaxy");

function timesTwo(inputNumber){ //declare function
    return inputNumber * 2; //inputNumber is the parameter (input a value)
}

console.log(timesTwo(1));    // Call the function with argument 1
                            // timesTwo(1) → 1 * 2 = 2
                            // console.log prints 2 to the console

let user = {
    firstName: "Ryano",  //string
    lastName: "Whelano",
    age: "99",
    hobbies: ["Gym", "Movies"], //array
    friends: [
        {                       //index 0
            firstName: "Flabio",
            lastName: "O'sigma",
            age: 67,
        },
        {                       //index 1
            firstName: "Ben",
            lastName: "Beanflicker",
            age: 89,
        }
    ],

};

console.log(user.friends[1].lastName); 


let donuts = ["Chocolate", "Jam", "Custard"];


donuts.forEach((donut, i) => {
    console.log((i + 1) + " " + donut);
});