const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const days = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];

rl.question("Masukkan hari: ", (hariInput) => {
  rl.question("Masukkan jumlah hari yang akan datang: ", (jumlahInput) => {
    const startDay = hariInput.trim().toLowerCase();
    const jumlahHari = parseInt(jumlahInput);

    if (isNaN(jumlahHari) || jumlahHari < 0) {
      console.log(" Jumlah hari harus berupa angka positif!");
      rl.close();
      return;
    }

    const startIndex = days.indexOf(startDay);

    if (startIndex === -1) {
      console.log(" Nama hari tidak valid. Gunakan: minggu, senin, selasa, rabu, kamis, jumat, sabtu");
      rl.close();
      return;
    }

    const targetIndex = (startIndex + jumlahHari) % 7;
    const targetDay = days[targetIndex];

    console.log(`${jumlahHari} hari setelah ${startDay} adalah ${targetDay}`);

    rl.close();
  });
});
