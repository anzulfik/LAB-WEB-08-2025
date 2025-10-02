const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function tanyaHarga() {
  rl.question('Masukkan harga barang: ', (hargaInput) => {
    const harga = parseFloat(hargaInput);

    // Validasi harga
    if (isNaN(harga)) {
      console.log('Input tidak valid. Harap masukkan angka.');
      return tanyaHarga();
    } else if (harga <= 0) {
      console.log('Harga harus lebih besar dari 0.');
      return tanyaHarga();
    }

    tanyaJenis(harga);
  });
}

function tanyaJenis(harga) {
  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenis) => {
    const jenisTrim = jenis.trim();

    // Validasi jenis barang
    if (!jenisTrim) {
      console.log('Jenis barang tidak boleh kosong.');
      return tanyaJenis(harga);
    } else if (!isNaN(parseFloat(jenisTrim))) {
      console.log('Jenis barang tidak boleh berupa angka.');
      return tanyaJenis(harga);
    }

    let diskonPersen = 0;
    const jenisLower = jenisTrim.toLowerCase();

    switch (jenisLower) {
      case 'elektronik':
        diskonPersen = 10;
        break;
      case 'pakaian':
        diskonPersen = 20;
        break;
      case 'makanan':
        diskonPersen = 5;
        break;
      default:
        diskonPersen = 0;
        break;
    }

    const diskonJumlah = (harga * diskonPersen) / 100;
    const hargaAkhir = harga - diskonJumlah;

    console.log('\n--- Rincian Harga ---');
    //console.log(`Harga awal: Rp ${harga.toLocaleString('id-ID')}`);

    if (diskonPersen > 0) {
      console.log(`Diskon: ${diskonPersen}%`);
      console.log(`Potongan harga: Rp ${diskonJumlah.toLocaleString('id-ID')}`);
      console.log(`Harga setelah diskon: Rp ${hargaAkhir.toLocaleString('id-ID')}`);
    } else {
      console.log("Tidak ada diskon untuk barang ini.");
      console.log(`Harga akhir: Rp ${harga.toLocaleString('id-ID')}`);
    }

    rl.close();
  });
}

console.log('--- Kalkulator Diskon Sederhana ---');
tanyaHarga();
