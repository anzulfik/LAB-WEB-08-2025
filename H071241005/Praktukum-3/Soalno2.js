const { exit } = require('process')
const readline = require('readline')

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
})

rl.question('Masukkan harga barang: ', (hargaInput) => {
  if (isNaN(hargaInput) || hargaInput < 0) {
    console.log("Invalid input")
    exit()
  }
  const hargaAwal = parseInt(hargaInput);
  rl.question('Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ', (jenisBarang) => {
    let diskon = 0
    switch (jenisBarang.toLowerCase()) {
      case 'elektronik':
        diskon = 10
      case 'pakaian':
        diskon = 20
      case 'makanan':
        diskon = 5
      default:
    }
    
    console.log('Harga awal: Rp ' + hargaAwal)
    console.log('Diskon: ' + diskon + '%')
    console.log('Harga setelah diskon: Rp ' + hargaAwal*(100-diskon)/100)
    rl.close()
  })
})