const readline = require('readline');


const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const target = Math.floor(Math.random() * 100) + 1;
let attempts = 0;

console.log("Saya sudah memilih angka antara 1 sampai 100.");
console.log("Coba tebak!");

function tanya() {
  rl.question("Masukkan tebakanmu: ", (jawaban) => {
    try {
      const tebakan = parseInt(jawaban.trim());
      attempts++;

    
      if (isNaN(tebakan)) {
        throw new Error("Input tidak valid. Masukkan angka, bukan huruf!");
      }
      if (tebakan < 1 || tebakan > 100) {
        throw new Error("Input di luar jangkauan. Masukkan angka antara 1 sampai 100!");
      }

      if (tebakan === target) {
        console.log(`🎉 Selamat! Angkanya memang ${target}.`);
        console.log(`Kamu menebak dengan benar setelah ${attempts} kali percobaan.`);
        rl.close();
      } else if (tebakan > target) {
        console.log("Terlalu tinggi! Coba lagi.");
        tanya();
      } else {
        console.log("Terlalu rendah! Coba lagi.");
        tanya();
      }
    } catch (err) {
    
      console.log("⚠️ " + err.message);
      tanya();
    }
  });
}

tanya();
