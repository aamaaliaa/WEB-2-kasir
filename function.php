<?php
// Mulai sesi
session_start();

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'kasir');

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Proses login
if (isset($_POST['login'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna
    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    $hitung = mysqli_num_rows($check);

    // Periksa hasil query
    if ($hitung > 0) {
        // Jika data ditemukan, set session login dan arahkan ke halaman index.php
        $_SESSION['login'] = true;
        header('location: index.php');
        exit();
    } else {
        // Jika data tidak ditemukan, tampilkan pesan kesalahan
        echo '<script>alert("Username atau password salah");</script>';
    }
}

// Proses tambah produk
if (isset($_POST['tambah'])) {
    // deskripsi initial variabel 
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $insert_produk = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, deskripsi, harga, stok) VALUES ('$nama_produk', '$deskripsi', '$harga', '$stok')");

    if ($insert_produk) {
        header('location: stok.php');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan kesalahan
        echo '<script>alert("Gagal Tambah Produk");</script>';
    }
}

// Proses tambah pelanggan
if (isset($_POST['tambahpelanggan'])) {
    // deskripsi initial variabel 
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, notelp, alamat) VALUES ('$nama_pelanggan', '$notelp', '$alamat')");

    if ($insert_pelanggan) {
        header('location: pelanggan.php');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan kesalahan
        echo '<script>alert("Gagal Tambah Pelanggan");</script>';
    }
}
?>
