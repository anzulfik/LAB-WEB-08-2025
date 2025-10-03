const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

const target = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;

console.log("Tebak angka antara 1 sampai 100!");

function tanya() {
  rl.question("Masukkan angka tebakan: ", (input) => {
    const tebakan = parseInt(input);
    if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
      console.log("Masukkan angka valid antara 1 sampai 100!");
      tanya();
      return;
    }

    percobaan++;

    if (tebakan > target) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanya();
    } else if (tebakan < target) {
      console.log("Terlalu rendah! Coba lagi.");
      tanya();
    } else {
      console.log(
        `Selamat! Kamu berhasil menebak angka ${target} dengan benar.`
      );
      console.log(`Sebanyak ${percobaan}x percobaan.`);
      rl.close();
    }
  });
}

tanya();
