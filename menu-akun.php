<?php
if (!isUserLoggedIn()) {
    $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Anda harus masuk terlebih dahulu!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    echo "<script>window.location='masuk.php'</script>";
}
?>

<nav class="content-navbar border-bottom">
    <ul class="nav">
        <li class="nav-item">
            <a <?php if ($page === 'akun') { ?> class="nav-link active" <?php } else { ?> class="nav-link text-reset" <?php } ?>
                href="akun-saya.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a <?php if ($page === 'pesanan') { ?> class="nav-link active" <?php } else { ?> class="nav-link text-reset" <?php } ?> href="pesanan.php">Pesanan Saya</a>
        </li>
        <li class="nav-item">
            <a <?php if ($page === 'detail-akun') { ?> class="nav-link active" <?php } else { ?> class="nav-link text-reset" <?php } ?> href="detail-akun.php">Detail Akun</a>
        </li>
        <li class="nav-item">
            <a  class="nav-link text-reset" href="keluar.php">Keluar</a>
        </li>
    </ul>
</nav>