<?php
// Mulai sesi
session_start();

// Koneksi ke database
// $host = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'kasir';
$koneksi = mysqli_connect('localhost', 'root', '', 'kasir');


// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Proses login
if(isset($_POST['login'])){
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna
    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username ='$username' AND password = '$password'");
    $hitung = mysqli_num_rows($check);

    // Periksa hasil query
    if($hitung > 0){
        // Jika data ditemukan, set session login dan arahkan ke halaman index.php
        session_start();
        $_SESSION['login'] = true;
        header('location: index.php');
        exit();
    } else {
        // Jika data tidak ditemukan, tampilkan pesan kesalahan
        echo '<script>alert("Username atau password salah");</script>';
    }
}
?>