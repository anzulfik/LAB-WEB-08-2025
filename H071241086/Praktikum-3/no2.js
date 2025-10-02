const readline = require("readline");

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

function hitungDiskon(harga, jenis) {
    let diskon = 0;
    const lowerJenis = jenis.toLowerCase();

    if (lowerJenis === "elektronik") {
        diskon = 0.10;
    } else if (lowerJenis === "pakaian") {
        diskon = 0.20;
    } else if (lowerJenis === "makanan") {
        diskon = 0.05;
    } else {
        diskon = 0;
    }

    const potongan = harga * diskon;
    const total = harga - potongan;

    console.log(`Harga awal: Rp ${harga}`);
    console.log(`Diskon: ${diskon * 100}%`);
    console.log(`Harga setelah diskon: Rp ${total}`);
}

function programDiskon() {
    rl.question("Masukkan harga barang: ", (hargaInput) => {
        const harga = parseFloat(hargaInput);
        if (isNaN(harga) || harga <= 0) {
            console.log("Input harga tidak valid. Harus angka positif.");
            rl.close();
            return;
        }

        rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenis) => {
            hitungDiskon(harga, jenis);
            rl.close();
        });
    });
}

programDiskon();
