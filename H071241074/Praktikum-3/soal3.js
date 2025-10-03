const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

const hari = [
  "minggu",
  "senin",
  "selasa",
  "rabu",
  "kamis",
  "jumat",
  "sabtu",
];

rl.question("Masukkan hari: ", (inputHari) => {
  const indexHari = hari.indexOf(inputHari.toLowerCase());
  if (indexHari == -1) {
    console.log("Hari tidak valid!");
    rl.close();
    return;
  }

  rl.question("Masukkan jumlah hari yang akan datang: ", (inputJumlah) => {
    const jumlah = parseInt(inputJumlah);
    if (isNaN(jumlah) || jumlah < 0) {
      console.log("Jumlah hari harus berupa angka positif!");
      rl.close();
      return;
    }

    const hariBaru = hari[(indexHari + jumlah) % 7];
    console.log(`${jumlah} hari setelah ${inputHari} adalah ${hariBaru}`);
    rl.close();
  });
});
