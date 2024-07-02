<?php
require 'ceklogin.php';

// Ambil data barang dan hitung jumlah barang
$barang = mysqli_query($koneksi, "SELECT * FROM produk");
$h2 = mysqli_num_rows($barang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="assets/img/start.png" rel="icon">
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Aplikasi Kasir</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Toko ATK</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="stok.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
                            Kelola Pelanggan
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-sign-out" aria-hidden="true"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Stok Barang</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-2">
                                <div class="card-body">Jumlah Barang: <?= $h2;?></div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Stok Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Edit|Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    $getbarang = mysqli_query($koneksi, "SELECT * FROM produk");
                                    while ($brg = mysqli_fetch_array($getbarang)) {
                                        $np = $brg['nama_produk'];
                                        $deskripsi = $brg['deskripsi'];
                                        $harga = $brg['harga'];
                                        $stok = $brg['stok'];
                                        $id_produk = $brg['id_produk'];
                                    ?>                            

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $np; ?></td>
                                        <td><?= $deskripsi; ?></td>
                                        <td>Rp.<?= number_format($harga); ?></td>
                                        <td><?= $stok; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editproduk<?= $id_produk; ?>">Edit</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusproduk<?= $id_produk; ?>">Delete</button>
                                        </td>
                                    </tr>
                                    <!--- Modal Edit --->
                                    <div class="modal" id="editproduk<?= $id_produk; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Data Stok</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="nama_produk" class="form-control mt-3" placeholder="Nama Produk" value="<?= $brg['nama_produk'] ?>">
                                                        <input type="text" name="deskripsi" class="form-control mt-3" placeholder="Deskripsi Produk" value="<?= $brg['deskripsi'] ?>">
                                                        <input type="number" name="harga" class="form-control mt-3" placeholder="Harga" value="<?= $brg['harga'] ?>">
                                                        <input type="hidden" name="idpr" class="form-control mt-3" value="<?= $id_produk; ?>">
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="editproduk">Simpan</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--- Modal Hapus --->
                                    <div class="modal" id="hapusproduk<?= $id_produk; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Apakah Anda Yakin Ingin Menghapus Data Ini?

                                                        <input type="hidden" name="id_produk" class="form-control mt-3" value="<?= $id_produk; ?>">
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="hapusproduk">Hapus</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    } // end while
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Amalia</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!--- Modal Tambah Barang --->
<div class="modal" id="myModal">  
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Stok</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="nama_produk" class="form-control mt-3" placeholder="Nama Produk">
                    <input type="text" name="deskripsi" class="form-control mt-3" placeholder="Deskripsi Produk">
                    <input type="number" name="harga" class="form-control mt-3" placeholder="Harga">
                    <input type="number" name="stok" class="form-control mt-3" placeholder="Stok">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="tambah">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</html>
