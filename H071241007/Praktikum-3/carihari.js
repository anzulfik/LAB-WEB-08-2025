const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const HARI_DALAM_SEMINGGU = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

function capitalize(s) {
  return s.charAt(0).toUpperCase() + s.slice(1);
}

rl.question('Masukkan hari saat ini: ', (inputHari) => {
  const namaHari = inputHari.toLowerCase();
  
  const indexHariIni = HARI_DALAM_SEMINGGU.indexOf(namaHari);

  if (indexHariIni === -1) {
    console.error('Error: Nama hari tidak valid. Silakan masukkan nama hari yang benar.');
    rl.close();
    return;
  }

  rl.question('Masukkan jumlah hari yang akan datang: ', (inputJumlahHari) => {
    const jumlahHari = parseInt(inputJumlahHari);

    if (isNaN(jumlahHari) || jumlahHari < 0) {
      console.error('Error: Jumlah hari harus berupa angka positif.');
      rl.close();
      return;
    }

    const indexHariNanti = (indexHariIni + jumlahHari) % 7;
    
    const namaHariNanti = HARI_DALAM_SEMINGGU[indexHariNanti];

    console.log(`\n Hasil: ${jumlahHari} hari setelah hari ${capitalize(namaHari)} adalah hari ${capitalize(namaHariNanti)}.`);
    
    rl.close();
  });
});