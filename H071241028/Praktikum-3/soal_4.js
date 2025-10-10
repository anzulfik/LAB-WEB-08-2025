const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const angkaRahasia = Math.round(Math.random() * 100) + 1;
let jumlahTebakan = 0;

console.log('Selamat datang di permainan Tebak Angka!');
console.log('Saya telah memilih sebuah angka antara 1 dan 100. Coba tebak!');

function tebakAngka() {
  rl.question('Masukkan tebakan Anda: ', (jawaban) => {
    const tebakanPengguna = parseInt(jawaban, 10);
    jumlahTebakan++;

    // Validasi input bukan angka
    if (isNaN(tebakanPengguna)) {
      console.log('Input tidak valid. Harap masukkan sebuah angka.');
      return tebakAngka();
    }

    // Validasi input di luar range 1–100
    if (tebakanPengguna < 1 || tebakanPengguna > 100) {
      console.log('Angka harus berada di antara 1 dan 100.');
      return tebakAngka();
    }

    // Logika permainan
    if (tebakanPengguna > angkaRahasia) {
      console.log('Terlalu tinggi! Coba lagi.');
      tebakAngka();
    } else if (tebakanPengguna < angkaRahasia) {
      console.log('Terlalu rendah! Coba lagi.');
      tebakAngka();
    } else {
      console.log(`\n Selamat! Kamu berhasil menebak angka ${angkaRahasia} dengan benar.`);
      console.log(`Kamu memerlukan ${jumlahTebakan}x percobaan.`);
      rl.close();
    }
  });
}

tebakAngka();
