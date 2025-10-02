const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const hariDalamSeminggu = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

function tanyaHari() {
  rl.question('Masukkan hari saat ini: ', (hariIniInput) => {
    const hariIni = hariIniInput.trim().toLowerCase(); 
    const indeksHariIni = hariDalamSeminggu.indexOf(hariIni);//mencari hari ada di index keberapa

    if (indeksHariIni === -1) {
      console.log('Nama hari tidak valid. Harap masukkan nama hari dalam bahasa Indonesia (contoh: senin).');
      tanyaHari();
      return;
    }

    tanyaJumlahHari(hariIni, indeksHariIni);
  });
}

function tanyaJumlahHari(hariIni, indeksHariIni) {
  rl.question('Masukkan jumlah hari yang akan datang: ', (jumlahHariInput) => {
    const jumlahHari = parseInt(jumlahHariInput.trim(), 10); //persent Int diubah menjadi angka bulat

    if (isNaN(jumlahHari) || jumlahHari < 0) {
      console.log('Jumlah hari tidak valid. Harap masukkan angka positif.');
      tanyaJumlahHari(hariIni, indeksHariIni); 
      return;
    }

    const indeksHariNanti = (indeksHariIni + jumlahHari) % 7;
    const namaHariNanti = hariDalamSeminggu[indeksHariNanti];

    const outputHariIni = hariIni.charAt(0).toUpperCase() + hariIni.slice(1);
    const outputHariNanti = namaHariNanti.charAt(0).toUpperCase() + namaHariNanti.slice(1);

    console.log(`${jumlahHari} hari setelah hari ${outputHariIni} adalah hari ${outputHariNanti}.`);
    
    rl.close();
  });
}

console.log('--- Kalkulator Hari ---');
tanyaHari();