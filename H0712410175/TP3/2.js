const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});


function tanyaHarga() {
  rl.question("Masukkan harga barang: ", (hargaInput) => {
    const harga = parseFloat(hargaInput);

    if (isNaN(harga) || harga <= 0) {
      console.log(" Harga harus berupa angka lebih dari 0.\n");
      return tanyaHarga(); 
    }

    
    tanyaJenis(harga);
  });
}


function tanyaJenis(harga) {
  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenisInput) => {
    const jenis = jenisInput.trim().toLowerCase();
    let diskon = 0;

    switch (jenis) {
      case "elektronik":
        diskon = 0.10;
        break;
      case "pakaian":
        diskon = 0.20;
        break;
      case "makanan":
        diskon = 0.05;
        break;
      case "lainnya":
        diskon = 0;
        break;
      default:
        console.log("Jenis barang tidak valid. Pilih Elektronik, Pakaian, Makanan, atau Lainnya.\n");
        return tanyaJenis(harga); 
    }

    const hargaAkhir = harga - (harga * diskon);

    console.log(`\n=== Hasil Perhitungan ===`);
    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);

    rl.close();
  });
}


tanyaHarga();
