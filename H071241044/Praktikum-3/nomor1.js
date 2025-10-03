function countEvenNumbers(start, end) {
  const evenNumbers = [];

  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      evenNumbers.push(i);
    }
  }

  console.log(`Output: ${evenNumbers.length} [${evenNumbers.join(', ')}]`);
}

countEvenNumbers(1, 10);
