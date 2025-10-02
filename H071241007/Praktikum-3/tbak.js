const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;

let jumlahTebakan = 0;

console.log("Selamat datang di permainan Tebak Angka!");
console.log("Saya telah memilih sebuah angka antara 1 dan 100. Coba tebak!");

function tebakAngka() {
  rl.question('Masukkan salah satu dari angka 1 sampai 100: ', (inputPemain) => {
    jumlahTebakan++;
    
    const tebakan = parseInt(inputPemain);

    if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
      console.log('Input tidak valid. Harap masukkan angka antara 1 dan 100.');
      tebakAngka();
      return;
    }

    if (tebakan < angkaRahasia) {
      console.log('Terlalu rendah! Coba lagi.');
      tebakAngka();
    } else if (tebakan > angkaRahasia) {
      console.log('Terlalu tinggi! Coba lagi.');
      tebakAngka();
    } else {
      console.log(`\nSe lamat! Anda berhasil menebak angkanya.`);
      console.log(`Angka yang benar adalah ${angkaRahasia}.`);
      console.log(`Anda memerlukan ${jumlahTebakan} tebakan untuk menang.`);
      rl.close();
    }
  });
}

tebakAngka();