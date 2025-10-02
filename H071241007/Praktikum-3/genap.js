function countEvenNumbers(start, end) {
    if (!Number.isInteger(start) || !Number.isInteger(end)) {
        throw new Error("Input tidak valid: 'start' dan 'end' harus berupa bilangan bulat (integer).");
    }

    if (start > end) {
        throw new Error("Input nguawur: start tidak boleh lebih besar dari end.");
    }

    let count = 0;
    let evenNumbers = [];

    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
        count++;
        evenNumbers.push(i);
        }
    }

    return `${count} [${evenNumbers.join(', ')}]`;
}

console.log(countEvenNumbers(15, 50));