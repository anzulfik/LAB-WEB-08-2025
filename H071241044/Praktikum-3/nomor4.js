const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const angkaBenar = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

console.log("Tebak angka antara 1 sampai 100");

function tanyaTebakan() {
  rl.question("Masukkan tebakanmu: ", (input) => {
    const tebakan = parseInt(input);
    if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
      console.log("Masukkan angka valid antara 1-100.");
      return tanyaTebakan();
    }

    percobaan++;

    if (tebakan < angkaBenar) {
      console.log("Terlalu rendah! Coba lagi.");
      tanyaTebakan();
    } else if (tebakan > angkaBenar) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanyaTebakan();
    } else {
      console.log(`Selamat! Kamu berhasil menebak angka ${angkaBenar} dengan benar.`);
      console.log(`Sebanyak ${percobaan}x percobaan.`);
      rl.close();
    }
  });
}

tanyaTebakan();
