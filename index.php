<?php
$title = 'Beranda';
$page = 'beranda';
include_once "navbar.php";
$result = mysqli_query($conn, "SELECT * FROM tb_produk WHERE status = 'Tersedia' ORDER BY id_produk DESC LIMIT 3");
?>

<body>
    <div class="container container-fluid">
        <?php if (isset($_SESSION['login-alert'])):
            echo $_SESSION['login-alert'];
            unset($_SESSION['login-alert']);
        endif; ?>
        <div class="position-relative overflow-hidden p-3 p-md-5 rounded-4 heroes">
            <div class="col-md-6  my-5">
                <h1 class="display-3 brand-name">Kedai Henna</h1>
                <h5 class="mb-3 accent">By Ima Habsyi</h5>
                <p class="mb-3">Sentuhan seni yang menghiasi kulit dengan keindahan alami. Temukan
                    keunikan
                    dan keindahan dalam setiap gaya.</p>
                <div class="lead">
                    <a class="nav-link" aria-current="page" href="belanja.php">
                        <button type="button" class="btn btn-dark">
                            Belanja Sekarang
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-3" id="product-section">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center align-middle p-1 pb-0 background rounded-3 mb-3">
                    <h3 class="fw-semibold">Produk Terbaru</h3>
                </div>
            </div>
            <?php while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-4 mb-3">
                    <a href="detail-produk.php?id=<?= $row['id_produk']; ?>">
                        <div class="card shadow d-flex flex-column overflow-hidden">
                            <div
                                class="card-image d-flex align-items-center justify-content-center rounded-3  overflow-hidden mb-3">
                                <img src="admin/images/<?php echo $row['foto_produk'] ?>" class="object-fit-cover">
                            </div>
                            <h5 class="fw-semibold overflow-hidden mb-0"><?php echo $row['nama_produk'] ?></h5>
                            <p class="my-1 accent">Rp <?php echo $row['harga_produk'] ?></p>
                            <p class="overflow-hidden desc"><?php echo $row['deskripsi_produk'] ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>