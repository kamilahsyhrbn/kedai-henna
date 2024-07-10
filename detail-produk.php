<?php
$title = 'Detail Produk';
$page = 'belanja';
include_once "navbar.php";

$produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk = '" . $_GET['id'] . "' ");
if (mysqli_num_rows($produk) == 0) {
    echo '<script>window.location="produk.php"</script>';
}

$p = mysqli_fetch_object($produk);
if ($p->stok == 0) {
    mysqli_query($conn, "UPDATE tb_produk SET status = 'Habis' WHERE id_produk = '" . $p->id_produk . "'");
}

if (isset($_POST['btnCart'])) {
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $total_price = $qty * $p->harga_produk;

    if ($qty > $p->stok) {
        echo '<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
        Jumlah yang Anda masukkan melebihi jumlah stok yang tersedia!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></div>';
    } else {

        $last_order = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE id_pelanggan = '" . $id_pelanggan . "' AND status_pembelian IS NULL ORDER BY tanggal_pembelian DESC LIMIT 1");

        $id_pembelian = null;
        if ($last_order->num_rows > 0) {
            $order = $last_order->fetch_assoc();
            $id_pembelian = $order['id_pembelian'];
            mysqli_query($conn, "UPDATE tb_pembelian SET total_jumlah = total_jumlah + '" . $qty . "', total_harga = total_harga + '" . $total_price . "' WHERE id_pembelian = '" . $id_pembelian . "'");
            echo '<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil memasukkan produk ke keranjang!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></div>';
        } else {
            $new_order = mysqli_query($conn, "INSERT INTO tb_pembelian (id_pelanggan, total_jumlah, total_harga) VALUES ($id_pelanggan, $qty, $total_price)");
            $id_pembelian = mysqli_insert_id($conn);
            echo '<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil memasukkan produk ke keranjang!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div></div>';
        }

        $check_order_detail = mysqli_query($conn, "SELECT * FROM tb_detail_pembelian WHERE id_pembelian = '" . $id_pembelian . "' AND id_produk = '" . $id_produk . "' ORDER BY tanggal_pembelian DESC LIMIT 1");

        if ($check_order_detail->num_rows > 0) {
            $order_detail = $check_order_detail->fetch_assoc();
            $order_detail_id = $order_detail['id'];
            mysqli_query($conn, "UPDATE tb_detail_pembelian SET total_jumlah = total_jumlah + '" . $qty . "', total_harga = total_harga + '" . $total_price . "' WHERE id = '" . $order_detail_id . "' ");
        } else {
            mysqli_query($conn, "INSERT INTO tb_detail_pembelian (id_produk, id_pembelian, total_jumlah, total_harga) VALUES ($id_produk, $id_pembelian, $qty, $total_price)");
        }
    }
}

?>

<body>
    <div class="container container-fluid">
        <div class="row mb-3">
            <div class="col-lg-4 mb-3">
                <a href="belanja.php" class="d-flex align-items-center back fs-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mb-3">
                <div class="detail-card m-auto overflow-hidden rounded-3 shadow">
                    <div class="card-image-container rounded-3 overflow-hidden d-flex">
                        <img src="admin/images/<?php echo $p->foto_produk; ?>" alt="" class="card-img-top">
                    </div>
                </div>
            </div>
            <?php if (isUserLoggedIn()): ?>
                <div class="col-lg-7">
                    <h2 class="fw-semibold mt-5"><?php echo $p->nama_produk; ?></h2>
                    <span class="accent">Rp <?php echo number_format($p->harga_produk, 0, ',', '.'); ?></span>
                    <p class="mt-3"><?php echo $p->deskripsi_produk; ?></p>
                    <div class="d-flex align-items-center my-5">
                        <?php if ($p->stok == 0) { ?>
                            <div class="text-center">
                                Stok produk telah habis!
                            </div>
                        <?php } else { ?>
                            <div class="card-count rounded text-center d-flex justify-content-between align-items-center">
                                <button onclick="decrement()" class="m-2" <?php $p->stok == 0 ? 'disabled' : '' ?>>-</button>
                                <p id="counter" class="my-1">1</p>
                                <button onclick="increment()" class="m-2" <?php $p->stok == 0 ? 'disabled' : '' ?>>+</button>
                            </div>
                            <form action="" method="POST" class="me-3">
                                <input type="hidden" name="qty" id="qty">
                                <input type="hidden" value="<?php echo $p->id_produk ?>" name="id_produk">
                                <button class="button-submit w-100 ms-4 mb-1 text-white rounded-3 fw-bold"
                                    name="btnCart">MASUKKAN
                                    KERANJANG</button>
                            </form>
                        <?php } ?>
                    </div>
                    <div>
                        <span class="text-secondary">Stok : <?php echo $p->stok; ?></span>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-lg-7">
                    <h2 class="fw-semibold mt-5"><?php echo $p->nama_produk; ?></h2>
                    <span class="accent">Rp <?php echo number_format($p->harga_produk, 0, ',', '.'); ?></span>
                    <p class="mt-3"><?php echo $p->deskripsi_produk; ?></p>
                    <div class="my-5">
                        <a href="masuk.php">
                            <button class="button-submit text-white rounded-3 fw-bold">MASUK UNTUK
                                MEMBELI</button>
                        </a>
                    </div>
                    <div>
                        <span class="text-secondary">Stok : <?php echo $p->stok; ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php include_once "footer.php" ?>
        <script>
            let counterValue = 1;
            document.getElementById('qty').value = counterValue;

            function updateCounter() {
                document.getElementById('counter').innerText = counterValue;
                document.getElementById('qty').value = counterValue;
            }

            function increment() {
                counterValue++;
                updateCounter();
            }

            function decrement() {
                if (counterValue > 1) {
                    counterValue--;
                    updateCounter();
                } else {
                    alert("Angka tidak bisa dibawah 1!");
                }
            }
        </script>
</body>