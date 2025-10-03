const { exit } = require('process')
const readline = require('readline')

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
})

rl.question('Masukkan hari: ', (hari) => {
    hari = hari.toLowerCase()
    if (hari!="senin" && hari!="selasa" && hari!="rabu" && hari!="kamis" && hari!="jumat" && hari!="sabtu" && hari!="minggu") {
        console.log("Invalid input")
        exit()
    }
  rl.question('Masukkan hari yang akan datang: ', (jumlahHari) => {
    if (isNaN(jumlahHari) || jumlahHari<0) {
        console.log("Invalid input")
        exit()
    }
    sisaHari = parseInt(jumlahHari) % 7
    let semuaHari = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"]
    let indexHari = semuaHari.indexOf(hari)
    let indexHariBaru = (indexHari + sisaHari) % 7
    console.log(jumlahHari + " hari setelah " + hari + " adalah " + semuaHari[indexHariBaru])
    rl.close()
  })
})