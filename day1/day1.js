

const test_input = 
`1000
2000
3000

4000

5000
6000

7000
8000
9000

10000`;


var getListOfElfCalories = input => {
    return input
        .split("\n\n")
        .map((elf)=>{
            return elf.split("\n")
                   .map(cal => parseInt(cal))
                   .reduce((calories, acc)=> acc + calories ,0);
        })
}
var findMaxElfCalories = list => {
    var value = Math.max(...list);
    list.splice(list.indexOf(value), 1);
    return value
}

var getTop3Elf = list => {
    return list
        .slice(0,3)
        //.reduce((calories, acc)=> acc + calories ,0);
}

const fs = require('fs');

var contents = fs.readFileSync('day1.txt').toString();
const list = getListOfElfCalories(contents)
//console.log(list.sort().reverse(), list.length)
var max  = findMaxElfCalories(list)
console.log(list.length)
max  += findMaxElfCalories(list)
console.log(list.length)
max  += findMaxElfCalories(list)
console.log(list.length, max)
//console.log("real", findMaxElfCalories(list));
//console.log("top3", getTop3Elf(list));



