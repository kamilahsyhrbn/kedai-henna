<?php
$title = 'Keranjang Belanja';
$page = 'keranjang';
include_once ("navbar.php");

$result1 = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE id_pelanggan = '" . $_SESSION['id_pelanggan'] . "' AND status_pembelian IS NULL ORDER BY tanggal_pembelian DESC LIMIT 1");
$order = $result1->fetch_assoc();

if ($result1->num_rows > 0) {
    $result2 = mysqli_query($conn, "SELECT tb_detail_pembelian.*, tb_produk.* FROM tb_detail_pembelian
                                      JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk
                                       WHERE id_pembelian = '" . $order['id_pembelian'] . "' ORDER BY tanggal_pembelian DESC");
}

if (isset($_POST['deleteCart'])) {
    $id_produk = $_POST['id_produk'];
    $id_detail_pembelian = $_POST['id_detail_pembelian'];
    $id_pembelian = $_POST['id_pembelian'];
    $jumlah_order = $_POST['order_qty'];
    $total_harga_order = $_POST['order_price'];

    $total_order_detail = mysqli_query($conn, "SELECT COUNT(*) as count FROM tb_detail_pembelian WHERE id_pembelian = '" . $id_pembelian . "' ");
    $count_order_detail = $total_order_detail->fetch_assoc();

    if ($count_order_detail['count'] == 1) {
        mysqli_query($conn, "DELETE FROM tb_pembelian WHERE id_pembelian = '" . $id_pembelian . "'");
        mysqli_query($conn, "DELETE FROM tb_detail_pembelian WHERE id = '" . $id_detail_pembelian . "' AND id_produk = '" . $id_produk . "'");
    } else {
        mysqli_query($conn, "UPDATE tb_pembelian SET total_jumlah = total_jumlah - '" . $jumlah_order . "', total_harga = total_harga - '" . $total_harga_order . "' WHERE id_pembelian = '" . $id_pembelian . "' ");
        mysqli_query($conn, "DELETE FROM tb_detail_pembelian WHERE id = '" . $id_detail_pembelian . "' AND id_produk = '" . $id_produk . "'");
    }
    echo '<script>window.location="keranjang.php"</script>';
}

if (isset($_POST['deleteAllCart'])) {
    $id_pembelian = $_POST['id_pembelian'];
    mysqli_query($conn, "DELETE FROM tb_pembelian WHERE id_pembelian = '" . $id_pembelian . "' ");
    mysqli_query($conn, "DELETE FROM tb_detail_pembelian WHERE id_pembelian = '" . $id_pembelian . "' ");
    echo '<script>window.location="keranjang.php"</script>';
}

?>

<body>
    <div class="container py-2 h-100 ">
        <div class="row justify-content-center align-items-center">
            <main>
                <h2 class="mb-5 text-center">Keranjang Belanja</h2>
                <div class="row">
                    <div class="col-6">
                        <?php if ($result1->num_rows > 0) { ?>
                            <div class="list-group">
                                <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                                    <div class="border-bottom d-flex gap-3 py-3" aria-current="true">
                                        <img src="admin/images/<?= $row['foto_produk'] ?>" width="100" height="100"
                                            class="rounded-3 flex-shrink-0" />
                                        <div class="d-flex gap-2 w-100 justify-content-between">
                                            <div>
                                                <h6 class="mb-0"><?= $row['nama_produk'] ?></h6>
                                                <small class="mb-0 opacity-75 price">Rp <?= $row['harga_produk'] ?></small>
                                                <p class="mb-0 opacity-75">Jumlah : <?= $row['total_jumlah'] ?></p>
                                            </div>
                                            <div>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                                                    <input type="hidden" name="id_detail_pembelian" value="<?= $row['id'] ?>">
                                                    <input type="hidden" name="id_pembelian"
                                                        value="<?= $row['id_pembelian'] ?>">
                                                    <input type="hidden" name="order_qty" value="<?= $row['total_jumlah'] ?>">
                                                    <input type="hidden" name="order_price" value="<?= $row['total_harga'] ?>">
                                                    <button type="submit" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                                        aria-label="Close" name="deleteCart"></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <form action="" method="POST">
                                    <input type="hidden" name="id_pembelian" value="<?= $order['id_pembelian'] ?>">
                                    <button href="" class="btn p-2 keranjang text-white fw-bold" type="submit"
                                        style="width: 150px" name="deleteAllCart">
                                        HAPUS SEMUA
                                    </button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <div class="text-center fw-semibold">
                                <p>Anda belum belanja apapun.</p>
                                <a href="belanja.php">
                                    <span class="accent">Mulai belanja</span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class=" col-lg-1">
                    </div>
                    <div class="col-5">
                        <div class="border-bottom">
                            <h3 class="mb-3 fw-semibold">Total Keranjang</h3>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <p class="fw-bold">TOTAL</p>
                            <?php if ($result1->num_rows > 0) { ?>
                                <p id="total_price" class="fw-bold">Rp <?= $order['total_harga'] ?> </p>
                            <?php } else { ?>
                                <p id="total_price" class="fw-bold">Rp 0</p>
                            <?php } ?>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <?php if ($result1->num_rows > 0) { ?>
                                <a href="checkout.php?id_pembelian=<?= $order['id_pembelian'] ?>">
                                    <button class="btn p-2 px-3 keranjang text-white fw-bold" type="button">
                                        LANJUTKAN KE PEMBAYARAN
                                    </button>
                                </a>
                            <?php } else { ?>
                                <button class="btn p-2 px-3 keranjang text-white fw-bold" type="button" disabled>
                                    LANJUTKAN KE PEMBAYARAN
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>


    </div>
    <?php include_once ("footer.php") ?>
</body>