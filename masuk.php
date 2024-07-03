<?php
require 'ceklogin.php';
$barang = mysqli_query($koneksi, "SELECT * FROM masuk m, produk p WHERE m.id_produk = p.id_produk");
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
                    <h1 class="mt-4">Stok Barang Masuk</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang Masuk
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Edit|Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($barang as $brg) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $brg['nama_produk']; ?></td>
                                    <td><?= $brg['deskripsi']; ?></td>
                                    <td><?= $brg['qty']; ?></td>
                                    <td><?= $brg['tgl_masuk']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $brg['id_masuk']; ?>">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $brg['id_masuk']; ?>">Delete</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $brg['id_masuk']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_masuk" value="<?= $brg['id_masuk']; ?>">
                                                    <div class="mb-3">
                                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" id="nama_produk" value="<?= $brg['nama_produk']; ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                                        <input type="text" class="form-control" id="deskripsi" value="<?= $brg['deskripsi']; ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="qty" class="form-label">Jumlah</label>
                                                        <input type="number" name="qty" class="form-control" id="qty" value="<?= $brg['qty']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-bs-dismiss="editbarangmasuk">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="editbarangmasuk">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?= $brg['id_masuk']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Delete Barang Masuk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_masuk" value="<?= $brg['id_masuk']; ?>">
                                                    <p>Apakah Anda yakin ingin menghapus barang masuk ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-bs-dismiss="deletebarangmasuk">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="deletebarangmasuk">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Amalia Priliantini &copy; 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Data Tambah Pesanan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        Pilih Barang
                        <select name="id_produk" class="form-control">
                            <?php
                            $getproduk = mysqli_query($koneksi, "SELECT * FROM produk");
                            while ($pr = mysqli_fetch_array($getproduk)) {
                                $id_produk = $pr['id_produk'];
                                $nama_produk = $pr['nama_produk'];
                                $stok = $pr['stok'];
                                $deskripsi = $pr['deskripsi'];
                                ?>
                                <option value="<?=$id_produk; ?>"> <?= $nama_produk; ?> - <?= $deskripsi; ?> - (Stok: <?=$stok;?>)</option>
                                <?php    
                            }
                            ?>
                        </select>
                        <input type="number" name="qty" class="form-control mt-3" placeholder="quantity" min="1" required>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="barangmasuk">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
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
</html>
