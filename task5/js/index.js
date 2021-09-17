import {AC} from './ac.js';

class Fan extends AC {

    isOn = false;
    level = 0;

    constructor(name, color, baldeNumber, inches){
        this.name = name;
        this.color = color;
        this.baldeNumber = baldeNumber;
        this.inches  = inches;
    }


    start(level) {
        if(Number.parseFloat(level) > 0){
            this.level = level;
            this.isOn = true;
            return "Fan is On at level "+level;
        }
    }

    stop() {
            this.level = 0;
            this.isOn = false;
            return "Fan is Stopped.";
    }
}




// let ox = new Fan('ox', 'white', 3, 16);

