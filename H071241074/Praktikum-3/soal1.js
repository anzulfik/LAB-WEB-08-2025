function CountEvenNumbers(start, end) {
    if (typeof start !== "number" || typeof end !== "number") {
        return "Input harus berupa angka."
    }
    
    if (start > end) {
        return "Nilai start tidak boleh lebih besar dari end."
    }

    let count = 0;
    let evenNumbers = [];

    for (let i = start; i <= end; i++) {
        if (i % 2 == 0) {
            count++;
            evenNumbers.push(i);
        }
    }
    return count + " [" + evenNumbers.join(", ") + "]";
}

console.log(CountEvenNumbers(1, 10));
console.log(CountEvenNumbers(20, 50));
console.log(CountEvenNumbers(-2, 10));


