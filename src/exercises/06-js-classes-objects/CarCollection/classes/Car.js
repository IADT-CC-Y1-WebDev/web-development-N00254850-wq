    class Car {
    
        constructor(_make, _model, _year, _colour, _extras){
            this.make = _make;
            this.model = _model;
            this.year = _year;
            this.colours = _colour;

            if(typeof_extras === 'object' && _extras.legnth > 0){
                this.extras = _extras
            }
            else {
                this.extras = ['Heated seats']
            }
        
    }

    getMake(){
        return this.make;
    }

    toString(){
        return `
        Make: ${this.make}
        Model: ${this.model}
        Year: ${this.year}
        Colour: ${this.colours}
        Extras: ${this.extras.join(" + ")}
        `;
        }

    }
    
    export default Car;