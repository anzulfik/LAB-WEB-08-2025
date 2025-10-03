const { randomInt } = require('crypto')
const { exit } = require('process')
const readline = require('readline')

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
})

let start = 1
let end = 100
let percobaan = 0
let angka = randomInt(1, 101)

function tanya() {
    rl.question(`Masukkan salah satu dari angka 1 sampai 100: `, (tebakan) => {
        if (isNaN(tebakan) || tebakan < start || tebakan > end) {
            console.log("Invalid input")
            tanya()
        } else if (parseInt(tebakan) == angka) {
            percobaan += 1
            console.log("Selamat! kamu berhasil menebak angka " + angka + " dengan benar.")
            console.log("Sebanyak " + percobaan + "x percobaan")
            rl.close()
            exit()
        } else if (parseInt(tebakan) < angka) {
            percobaan += 1
            console.log("Terlalu rendah! Coba lagi.")
            tanya()
        } else {
            percobaan += 1
            console.log("Terlalu tinggi! Coba lagi.")
            tanya()
        }
    })
}
tanya()