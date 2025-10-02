const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});


function hitungHargaAkhir(harga, jenis) {
    let diskon = 0;
    const jenisLowerCase = jenis.toLowerCase();

    switch (jenisLowerCase) {
        case 'elektronik':
        diskon = 0.10;
        break;
        case 'pakaian':
        diskon = 0.20;
        break;
        case 'makanan':
        diskon = 0.05;
        break;
        default:
        diskon = 0;
        break;
    }

  const jumlahDiskon = harga * diskon;
  const hargaAkhir = harga - jumlahDiskon;

    console.log("\n--- Rincian Harga ---");
    console.log(`Harga Awal     : Rp${harga.toLocaleString('id-ID')}`);
    console.log(`Jenis Barang   : ${jenis}`);
    console.log(`Diskon         : ${diskon * 100}%`);
    console.log(`Potongan Harga : Rp${jumlahDiskon.toLocaleString('id-ID')}`);
    console.log("-----------------------");
    console.log(`Harga Akhir    : Rp${hargaAkhir.toLocaleString('id-ID')}`);
}

rl.question('Masukkan harga barang: ', (hargaInput) => {
    const harga = parseFloat(hargaInput);

    if (isNaN(harga) || harga <= 0) {
        console.log('Error: Harga harus berupa angka positif.');
        rl.close();
        return;
    }

    rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenisInput) => {
        hitungHargaAkhir(harga, jenisInput);

        rl.close();
    });
});