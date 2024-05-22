<?php
require 'function.php';
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
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
                    <h1 class="mt-4">Kelola Pelanggan</h1>
                    <ol class="breadcrumb mb-4"></ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Pelanggan</div>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Pelanggan</button>
                            <div class="container mt-3"></div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pelanggan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No. Telepon</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pelanggan as $plg) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $plg['nama_pelanggan']; ?></td>
                                        <td><?= $plg['notelp']; ?></td>
                                        <td><?= $plg['alamat']; ?></td>
                                        <td>
                                            <a href="view.php?idp=<?= $plg['id_pelanggan']; ?>" class="btn btn-primary" target="_blank">TAMPILKAN</a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $plg['id_pelanggan']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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

    <!-- The Modal for Adding Customers -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Data Tambah Pelanggan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="add_pelanggan.php">
              <!-- Modal body -->
              <div class="modal-body">
                  <input type="text" name="nama_pelanggan" class="form-control mt-3" placeholder="Nama Pelanggan" required>
                  <input type="text" name="notelp" class="form-control mt-3" placeholder="No. Telepon" required>
                  <input type="text" name="alamat" class="form-control mt-3" placeholder="Alamat" required>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="submit" class="btn btn-success" name="tambahpelanggan">Simpan</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <?php foreach ($pelanggan as $plg) : ?>
    <!-- The Modal for Deleting Customers -->
    <div class="modal fade" id="deleteModal<?= $plg['id_pelanggan']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="deleteModalLabel">Hapus Pelanggan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="delete_pelanggan.php">
              <!-- Modal body -->
              <div class="modal-body">
                  Apakah Anda yakin ingin menghapus pelanggan <b><?= $plg['nama_pelanggan']; ?></b>?
                  <input type="hidden" name="id_pelanggan" value="<?= $plg['id_pelanggan']; ?>">
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="submit" class="btn btn-danger" name="hapuspelanggan">Hapus</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
