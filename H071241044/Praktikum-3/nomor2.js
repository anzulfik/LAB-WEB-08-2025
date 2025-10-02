const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function hitungDiskon(harga, jenis) {
  jenis = jenis.toLowerCase();
  let diskon = 0;

  if (jenis === "elektronik") diskon = 10;
  else if (jenis === "pakaian") diskon = 20;
  else if (jenis === "makanan") diskon = 5;

  let potongan = harga * (diskon / 100);
  let hargaAkhir = harga - potongan;

  console.log(`Harga awal: Rp ${harga}`);
  console.log(`Diskon: ${diskon}%`);
  console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);
}

rl.question("Masukkan harga barang: ", (hargaInput) => {
  const harga = parseFloat(hargaInput);
  if (isNaN(harga)) {
    console.log("Input harga tidak valid.");
    rl.close();
    return;
  }

  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
    hitungDiskon(harga, jenis);
    rl.close();
  });
});
