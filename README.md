# RUNNING APPS (SIMKES)

## REQUIREMENTS

Sebelum menjalankan aplikasi ini dari server lokal, terdapat beberapa prasyarat yang harus terpenuhi:
- Install XAMPP atau LARAGON dengan PHP minimum versi 8.1 sebagai local web server
- Enable extensions `intl` dan `mbstring` dari PHP
- Install composer

## ENABLING PHP EXTENSIONS

Jika anda menggunakan XAMPP, pada menu untuk 'Apache' silahkan pilih menu `Config` kemudian pilih `PHP (php.ini)`.
Jika anda menggunakan LARAGON, klik kanan dibagian mana saja dalam aplikasi, arahkan cursor anda pada menu `PHP` kemudian pilih `php.ini`.
Setelah file `PHP.ini` terbuka kemudian cari `;extension=intl` dan `;extension=mbstring`. Setelah ditemukan, hapus titik koma `;` di depan kedua fungsi tersebut untuk mengaktifkan ekstensi. Simpan file tersebut, kemudian restart XAMPP atau LARAGON

## CLONING APPS FROM GITHUB

Untuk cloning aplikasi dari github, silahkan ikuti langkah berikut:
1. **Buka Folder**
    pilih folder tujuan tempat projek SIMKES diletakkan

2. **Cloning Github**
    buka terminal dari folder tersebut. kemudian pastekan perintah berikut:
    ```sh
        https://github.com/khoican/simkes.git
    ```
    tunggu hingga proses cloning selesai

## RUNNING PROJECT

1. **Buka Projek**
    buka projek yang sudah diclone kedalam VS Code atau code editor lainnya.

2. **Install Dependency**
    sebelum menginstall dependency yang dibutuhkan, pastika composer sudah terinstall kedalam komputer lokal anda. periksa dengan mengetikkan: 
    ```sh
        composer -v
    ```
    apabila composer sudah terinstall, bisa jalankan perintah berikut:
    ```sh
        composer install
    ```
    tunggu hingga proses instalasi selesai

3. **Konfigurasi ENV**
    sebelum menjalankan projek, silahkan rename terlebih dahulu file `.env.example` menjadi `.env`

4. **Migrasi Database**
    buat terlebih dahulu database dengan nama `simkes_db`, dapat menggunakan metode manual atau menggunakan perintah berikut:
    ```sh
        php spark db:create simkes_db
    ```
    setelah database berhasil terbuat, selanjutnya proses migrasi tabel menggunakan perintah berikut:
    ```sh
        php spark migrate
    ```

5. **Running Website**
    untuk menjalankan website pada komputer loka, dapat menggunakan perintah berikut:
    ```sh
        php spark serve
    ```
    aplikasi siap untuk digunakan

## Notes

- Usahakan untuk mengisi data `Poli`, `Diagnosa`, `Tindakan`, dan `Obat` terlebih dahulu sebelum mengisi data pasien baru, menu tersebut terdapat pada menu dropdown `User`. 
- Penamaan poli cukup nama poli saja. Apabila `Poli Umum` cukup menggunakan `Umum` saja
