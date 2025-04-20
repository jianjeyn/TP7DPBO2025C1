# TP7DPBO2025C1

## Janji
Saya Jihan Aqilah Hartono dengan NIM 2306827 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Desain
![image](https://github.com/user-attachments/assets/2d55d941-b443-4412-9717-d74dafa885bf)

## Penjelasan Alur
Baik! Berikut adalah penjelasan alur sistem dan penjelasan struktur database dalam bahasa Indonesia:

### **Penjelasan Alur Sistem**

1. **Tabel `users`**:
   - Tabel ini menyimpan data pengguna seperti `id`, `username`, `email`, dan foto-foto terkait pakaian, celana, dan sepatu (misalnya `photo_clothes`, `photo_bottoms`, `photo_shoes`).
   - **Primary Key**: `id` (ID unik untuk setiap pengguna).

2. **Tabel `clothes`, `bottoms`, `shoes`**:
   - Setiap tabel ini menyimpan data tentang pakaian, celana, dan sepatu yang dimiliki oleh pengguna.
   - Setiap item di tabel ini terkait dengan `user_id`, yang merupakan **foreign key** yang merujuk ke `id` pada tabel `users`.
   - Setiap tabel memiliki kolom-kolom:
     - `item_name`: Nama item (misalnya "Kaos Biru", "Jeans Hitam").
     - `color`: Warna dari item tersebut.
     - `image_url`: Lokasi file gambar yang menunjukkan item tersebut.

### **Hubungan Antar Tabel:**
- Setiap **pengguna** bisa memiliki banyak **item pakaian**, **celana**, dan **sepatu**. Ini diatur melalui relasi **foreign key** pada kolom `user_id` di tabel `clothes`, `bottoms`, dan `shoes` yang merujuk ke `id` pengguna di tabel `users`.

### **Alur Kerja:**

1. **Menambahkan Item (Pakaian, Celana, Sepatu)**:
   - Pengguna dapat menambahkan item ke dalam lemari mereka dengan menentukan nama item, warna, dan gambar. Setiap item dimasukkan ke dalam tabel yang sesuai (`clothes`, `bottoms`, atau `shoes`) dengan menyertakan `user_id` yang merujuk ke pengguna yang menambahkannya.

2. **Melihat Item**:
   - Pengguna dapat melihat semua item yang telah mereka tambahkan. Data item ditampilkan berdasarkan `user_id`.

3. **Mengedit Item**:
   - Pengguna dapat mengedit item yang sudah ada. Mereka dapat mengganti nama item, warna, dan mengupload gambar baru. `user_id` tetap dipertahankan untuk memastikan pengeditan dilakukan pada item yang benar.

4. **Menghapus Item**:
   - Pengguna dapat menghapus item yang sudah tidak diperlukan lagi. Item akan dihapus dari tabel berdasarkan `user_id` dan `item_id`.

### **Penjelasan Struktur Tabel:**

1. **Tabel `users`**:
   - **`id`**: ID unik untuk setiap pengguna.
   - **`username`**: Nama pengguna.
   - **`email`**: Alamat email pengguna.
   - **`photo_clothes`**: Foto pakaian pengguna.
   - **`photo_bottoms`**: Foto celana pengguna.
   - **`photo_shoes`**: Foto sepatu pengguna.

2. **Tabel `clothes`**:
   - **`id`**: ID item pakaian.
   - **`user_id`**: ID pengguna yang memiliki item pakaian ini (merujuk ke `users.id`).
   - **`item_name`**: Nama item pakaian.
   - **`color`**: Warna pakaian.
   - **`image_url`**: Lokasi file gambar pakaian.

3. **Tabel `bottoms`**:
   - Struktur dan fungsinya sama dengan tabel `clothes`, tetapi untuk item celana.

4. **Tabel `shoes`**:
   - Struktur dan fungsinya sama dengan tabel `clothes`, tetapi untuk item sepatu.

### **Kesimpulan:**
- Sistem ini memungkinkan pengguna untuk mengelola lemari pakaian mereka dengan menambahkan, melihat, mengedit, dan menghapus item.
- Hubungan antara pengguna dan item dikelola menggunakan `user_id` sebagai **foreign key** di setiap tabel item (`clothes`, `bottoms`, dan `shoes`).
- File gambar disimpan di server dan hanya nama file yang disimpan di database.

## Dokumentasi
https://drive.google.com/file/d/1iXLtX_Q_vUxjCGVcwpCAHWHObc_ROzLb/view?usp=sharing
