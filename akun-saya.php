<?php
$title = 'Akun Saya';
$page = 'akun';
include_once ("navbar.php");

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $query = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");

    if ($query && mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
        $nama_pelanggan = $userData['nama_pelanggan'];
    }
}

?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="my-4">Akun Saya</h2>
            </div>
            <div class="col-lg-12">
                <?php include 'menu-akun.php' ?>
                <div class="container-fluid mt-4">
                    <div class="content-menu">
                        <p>Halo
                            <?php echo $nama_pelanggan ?>! (bukan
                            <?php echo $nama_pelanggan ?>? <a href="keluar.php"><span>Keluar</span></a>)
                        </p>
                        <p>Dari dasbor akun Anda, Anda dapat melihat <a href="pesanan.php"><span>pesanan Anda
                                </span></a>dan mengubah <a href="detail-akun.php"><span> password serta detail akun
                                    Anda</span></a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once ("footer.php") ?>
</body>