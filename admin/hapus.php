<?php
include 'config/koneksi.php';
session_start();

if (isset($_GET['idproduk'])) {
  $delete = mysqli_query($conn, "DELETE FROM tb_produk WHERE id_produk = '" . $_GET['idproduk'] . "' ");
  $_SESSION['produk'] = '<div class="container ms-3 mt-2"><div class="alert alert-success alert-dismissible fade show" role="alert">
    Berhasil Menghapus Produk!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div></div>';
  echo '<script>window.location="produk.php"</script>';
  exit();
}

if (isset($_GET['idpelanggan'])) {
  $delete = mysqli_query($conn, "DELETE FROM tb_pelanggan WHERE id_pelanggan = '" . $_GET['idpelanggan'] . "' ");
  $_SESSION['pelanggan'] = '<div class="container ms-2.5 mt-2"><div class="alert alert-success alert-dismissible fade show" role="alert">
    Berhasil Menghapus Pelanggan!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div></div>';
  echo '<script>window.location="pelanggan.php"</script>';
  exit();
}

if (isset($_GET['idAdmin'])) {
  $delete = mysqli_query($conn, "DELETE FROM tb_admin WHERE id_admin = '" . $_GET['idAdmin'] . "' ");
  $_SESSION['admin'] = '<div class="container ms-2.5 mt-2"><div class="alert alert-success alert-dismissible fade show" role="alert">
  Berhasil Menghapus Admin!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div></div>';
  echo '<script>window.location="data-admin.php"</script>';
  exit();
}

?>