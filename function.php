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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna
    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    $hitung = mysqli_num_rows($check);

    if ($hitung > 0) {
        $_SESSION['login'] = true;
        header('Location: index.php');
        exit();
    } else {
        echo '<script>alert("Username atau password salah");</script>';
    }
}

// Proses tambah produk
if (isset($_POST['tambah'])) {
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $insert_produk = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, deskripsi, harga, stok) VALUES ('$nama_produk', '$deskripsi', '$harga', '$stok')");

    if ($insert_produk) {
        header('Location: stok.php');
    } else {
        echo '<script>alert("Gagal Tambah Produk");</script>';
    }
}

// Proses tambah pelanggan
if (isset($_POST['tambahpelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, notelp, alamat) VALUES ('$nama_pelanggan', '$notelp', '$alamat')");

    if ($insert_pelanggan) {
        header('Location: pelanggan.php');
    } else {
        echo '<script>alert("Gagal Tambah Pelanggan");</script>';
    }
}

// Proses hapus pelanggan
if (isset($_POST['deletepelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $delete_pelanggan = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");

    if ($delete_pelanggan) {
        header('Location: pelanggan.php');
    } else {
        echo '<script>alert("Gagal Hapus Pelanggan");</script>';
    }
}

// Proses tambah pesanan
if (isset($_POST['tambahpesanan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (id_pelanggan) VALUES ('$id_pelanggan')");

    if ($insert_pesanan) {
        header('Location: index.php');
    } else {
        echo '<script>alert("Gagal tambah pesanan");</script>';
    }
}

// Proses tambah produk ke pesanan
if (isset($_POST['addproduk'])) {
    $id_produk = $_POST['id_produk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];

    // Hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($koneksi, "SELECT stok FROM produk WHERE id_produk='$id_produk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok']; // stok barang saat ini

    if ($stoksekarang >= $qty) {
        // Kurangi stoknya dengan jumlah yang akan dikeluarkan
        $selisih = $stoksekarang - $qty;

        // Stoknya cukup
        $insert = mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_produk, qty) VALUES ('$idp','$id_produk','$qty')"); 
        $update = mysqli_query($koneksi, "UPDATE produk SET stok='$selisih' WHERE id_produk='$id_produk'");

        if ($insert && $update) {
            header('Location: view.php?idp='.$idp);
        } else {
            echo '<script>alert("Gagal tambah produk");</script>';
        }
    } else {
        // Stok tidak cukup
        echo '<script>alert("Stok tidak cukup");</script>';
    }
}

// Proses tambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];

    $insertbar = mysqli_query($koneksi, "INSERT INTO masuk (id_produk, qty) VALUES ('$id_produk', '$qty')");

    if ($insertbar) {
        header('Location: masuk.php');
    } else {
        echo '<script>alert("Gagal");</script>';
    }
}

// Proses hapus produk pesanan
if (isset($_POST['hapusprodukpesanan'])) {
    $iddetail = $_POST['iddetail']; // detail pesanan
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    // Cek qty sekarang
    $cek1 = mysqli_query($koneksi, "SELECT qty FROM detail_pesanan WHERE id_detailpesanan='$iddetail'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    // Cek stok sekarang
    $cek3 = mysqli_query($koneksi, "SELECT stok FROM produk WHERE id_produk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang + $qtysekarang;

    $update = mysqli_query($koneksi, "UPDATE produk SET stok='$hitung' WHERE id_produk='$idpr'"); // untuk update stok
    $hapus = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE id_produk='$idpr' AND id_detailpesanan='$iddetail'");

    if ($update && $hapus) {
        header('Location: view.php?idp='.$idp);
    } else {
        echo '<script>alert("Gagal hapus produk pesanan");</script>';
    }
}

// Update produk jika tombol edit ditekan
if (isset($_POST['editproduk'])) {
    $np = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idpr = $_POST['idpr'];

    // Konversi harga menjadi integer
    $harga = intval($harga);

    // Update produk
    $edit_barang = mysqli_query($koneksi, 
        "UPDATE produk 
        SET 
        nama_produk='$np', 
        deskripsi='$deskripsi', 
        harga=$harga
        WHERE id_produk='$idpr'");

    if ($edit_barang) {
        header('location:stok.php');
    } else {
        echo '
        <script>
        alert("Gagal Edit");
        window.location.href="stok.php";
        </script>';
    }
}

// Proses hapus produk
if (isset($_POST['hapusproduk'])) {
    $idpr = $_POST['id_produk'];

    $hapusbarang = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$idpr'");

    if ($hapusbarang) {
        header('location:stok.php');
    } else {
        echo '
        <script>
        alert("Gagal Hapus");
        window.location.href="stok.php";
        </script>';
    }
}

// Proses hapus pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $hapuspelanggan = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

    if ($hapuspelanggan) {
        header('location:stok.php');
    } else {
        echo '
        <script>
        alert("Gagal Hapus");
        window.location.href="stok.php";
        </script>';
    }
}
// Update pelanggan jika tombol edit ditekan
if (isset($_POST['editpelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $id_pelanggan = $_POST['id_pelanggan'];

    // Update pelanggan
    $edit_pelanggan = mysqli_query($koneksi, 
        "UPDATE pelanggan 
        SET 
        nama_pelanggan='$nama_pelanggan', 
        notelp='$notelp', 
        alamat='$alamat' 
        WHERE id_pelanggan='$id_pelanggan'");

    if ($edit_pelanggan) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
        alert("Gagal Edit");
        window.location.href="pelanggan.php";
        </script>';
    }
}
if (isset($_POST['editbarangmasuk'])) {
    $id_masuk = $_POST['id_masuk'];
    $qty = $_POST['qty'];
    
    $update = mysqli_query($koneksi, "UPDATE masuk SET qty='$qty' WHERE id_masuk='$id_masuk'");
    if ($update) {
        echo "<script>alert('Data berhasil diubah');window.location='masuk.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data');</script>";
    }
}

if (isset($_POST['deletebarangmasuk'])) {
    $id_masuk = $_POST['id_masuk'];
    
    $delete = mysqli_query($koneksi, "DELETE FROM masuk WHERE id_masuk='$id_masuk'");
    if ($delete) {
        echo "<script>alert('Data berhasil dihapus');window.location='masuk.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
}

?>
