function countEvenNumbers(start, end) {
    if (typeof start !== 'number' || typeof end !== 'number' || start > end) {
    return "Input tidak valid. Pastikan start dan end adalah angka, dan start tidak lebih besar dari end.";
}
    let evenNumbers = [];
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) evenNumbers.push(i);
    }
    return(`Jumlah bilangan genap: ${evenNumbers.length} [${evenNumbers.join(", ")}]`);
}  
console.log(countEvenNumbers(10,20));