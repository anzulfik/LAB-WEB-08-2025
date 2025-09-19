# LAB-WEB-08-2025
# 📘 Repositori Tugas Praktikum WEB-08 2025

## ✅ Requirements
- Buat akun GitHub → [https://github.com/](https://github.com/)  
- Download Git → [https://git-scm.com/](https://git-scm.com/)

---

## 🔄 Alur Pengumpulan Tugas

### 1. Fork repositori ini

### 2. Clone repositori hasil fork
```bash
git clone https://github.com/YOUR_USERNAME/LAB-WEB-08-2025.git
```

### 3. Masuk ke folder hasil clone, lalu buat branch dengan nama **NIM** anda
```bash
cd LAB-WEB-08-2025
git branch NIM_ANDA
git checkout NIM_ANDA
git config user.name USERNAME_GITHUB
git config user.email EMAIL_GITHUB
```

### 4. Buat folder dengan nama NIM anda
```bash
mkdir NIM_ANDA
cd NIM_ANDA
```

### 5. Buat folder untuk praktikum
> **CATATAN:** `n` adalah nomor praktikum keberapa  
> **Contoh:** `Praktikum-1`

```bash
mkdir Praktikum-n
cd Praktikum-n
```

Semua file untuk tugas praktikum disimpan di folder ini.

---

## 📝 Commit Perubahan
Setiap kali membuat file atau mengubah sesuatu, lakukan commit dengan pesan yang jelas.

Tambah semua file:
```bash
git add .
```

Atau pilih file tertentu:
```bash
git add "NIM/Praktikum-n/NamaFile"
```

Cek status:
```bash
git status
```

Commit:
```bash
git commit -m "pesan mengenai perubahan"
```

---

## 📤 Push Tugas
Setelah asistensi dan tugas disetujui, lakukan push:
```bash
git push origin NIM_ANDA
```

Jika pertama kali, Git akan meminta:
- **username** → username GitHub anda  
- **password** → personal access token  

---

## 🔑 Membuat Personal Access Token
1. Klik profile (pojok kanan atas GitHub)  
2. Pilih **Settings**  
3. Scroll ke bawah → pilih **Developer settings**  
4. Pilih **Personal access tokens**  
5. Klik **Generate new token**  
6. Isi note (contoh: `Token for LAB-WEB-08-2025`)  
7. Atur waktu **expiration** sesuai kebutuhan  
8. Centang scope **repo**  
9. Klik **Generate token**  
10. **Copy & simpan token** (hanya bisa dilihat sekali, kalau hilang harus buat baru)

---

## 🔃 Pull Request
1. Masuk ke repo hasil fork di akun GitHub anda  
2. Pastikan perubahan sudah muncul  
3. Pilih menu **Pull request**  
4. Lakukan pull request untuk tugas praktikum anda
