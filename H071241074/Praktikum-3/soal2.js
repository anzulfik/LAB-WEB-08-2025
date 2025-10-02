const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

function hitungDiskon(harga, jenis) {
  let diskon = 0;

  if (jenis.toLowerCase() == "elektronik") {
    diskon = 10;
  } else if (jenis.toLowerCase() == "pakaian") {
    diskon = 20;
  } else if (jenis.toLowerCase() == "makanan") {
    diskon = 5;
  } else {
    diskon = 0;
  }

  const potongan = (harga * diskon) / 100;
  const hargaAkhir = harga - potongan;
  return { diskon, hargaAkhir };
}

rl.question("Masukkan harga barang: ", (inputHarga) => {
  const harga = parseFloat(inputHarga);
  if (isNaN(harga) || harga <= 0) {
    console.log("Harga harus berupa angka positif!");
    rl.close();
    return;
  }

  rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
      const { diskon, hargaAkhir } = hitungDiskon(harga, jenis);
      console.log(`Harga awal: Rp ${harga}`);
      console.log(`Diskon: ${diskon}%`);
      console.log(`Harga setelah diskon: Rp ${hargaAkhir}`);
      rl.close();
    }
  );
});
