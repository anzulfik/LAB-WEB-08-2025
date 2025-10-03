function countEvenNumbers(start, end) {
    if (isNaN(start) || isNaN(end) || start<0 || end<0 || start>end) {
        return console.log("Invalid input")
    }
    if (start %2 != 0) {
        start += 1
    }
    let a = []
    for (let i = start; i<end+1; i+=2) {
        a.push(i)
    }
    console.log(a.length + "[" + a + "]")
}

countEvenNumbers(15,50)