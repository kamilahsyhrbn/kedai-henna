<?php
$title = 'Belanja';
$page = 'belanja';
include_once "navbar.php";
$result = mysqli_query($conn, "SELECT * FROM tb_produk");
?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-12">
                <h2 class="my-4 text-center">Belanja Produk</h2>
            </div>
        </div>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-lg-4 mb-3">
                    <a href="detail-produk.php?id=<?php echo $row['id_produk'] ?>">
                        <div class="card d-flex flex-column overflow-hidden shadow">
                            <div
                                class="card-image d-flex align-items-center justify-content-center rounded-3 overflow-hidden mb-3">
                                <img src="admin/images/<?php echo $row['foto_produk'] ?>"
                                    class="object-fit-cover top-0 left-0">
                            </div>
                            <h5 class="fw-semibold overflow-hidden mb-0"><?php echo $row['nama_produk'] ?></h5>
                            <p class="my-1 accent">Rp <?php echo number_format($row['harga_produk'], 0, ',', '.') ?></p>
                            <p class="overflow-hidden desc"><?php echo $row['deskripsi_produk'] ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>