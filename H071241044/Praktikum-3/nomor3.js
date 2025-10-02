const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const days = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

rl.question("Masukkan hari: ", (hari) => {
  hari = hari.toLowerCase();
  const indexHari = days.indexOf(hari);

  if (indexHari === -1) {
    console.log("Hari tidak valid.");
    rl.close();
    return;
  }

  rl.question("Masukkan jumlah hari ke depan: ", (jumlahHari) => {
    const n = parseInt(jumlahHari);

    if (isNaN(n)) {
      console.log("Jumlah hari harus berupa angka.");
      rl.close();
      return;
    }

    const hariMendatang = days[(indexHari + n) % 7];
    console.log(`${n} hari setelah ${hari} adalah ${hariMendatang}`);
    rl.close();
  });
});
