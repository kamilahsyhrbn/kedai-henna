<?php
$title = 'Checkout';
$page = 'keranjang';
include_once "navbar.php";

if (!isUserLoggedIn()) {
    $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Anda harus masuk terlebih dahulu!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    echo "<script>window.location='masuk.php'</script>";
}

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $pelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");

    $a = mysqli_fetch_object($pelanggan);
}

$id_pembelian = $_GET['id_pembelian'];

$result1 = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE id_pelanggan = '" . $_SESSION['id_pelanggan'] . "' AND status_pembelian IS NULL AND id_pembelian = '" . $id_pembelian . "' ORDER BY tanggal_pembelian DESC LIMIT 1");
$order = $result1->fetch_assoc();

$result2 = mysqli_query($conn, "SELECT tb_detail_pembelian.*, tb_produk.* FROM tb_detail_pembelian
JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk
 WHERE id_pembelian = '" . $order['id_pembelian'] . "' ORDER BY tanggal_pembelian DESC");

if ($result1->num_rows > 0) {
    $result3 = mysqli_query($conn, "SELECT tb_detail_pembelian.*, tb_produk.* FROM tb_detail_pembelian
                                      JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk
                                       WHERE id_pembelian = '" . $order['id_pembelian'] . "' ORDER BY tanggal_pembelian DESC");

} else {
    echo '<script>window.location="keranjang.php"</script>';
}

if (isset($_POST['checkout'])) {
    $targetDir = "admin/images/";
    $file = $_FILES['bukti_tf'];
    $id_pembelian = $_POST['id_pembelian'];
    $fileType = strtolower(pathinfo($_FILES['bukti_tf']['name'], PATHINFO_EXTENSION));
    $fileName = uniqid() . '.' . $fileType;
    $targetFile = $targetDir . $fileName;

    $allowedExtensions = ["jpeg", "jpg", "png"];
    if (!in_array($fileType, $allowedExtensions)) {
        echo "<div class='container'><div class='alert alert-danger text-center' role='alert'>
                Format gambar yang diperbolehkan hanya .jpg, .jpeg dan .png
              </div></div>";
    } else if ($file["size"] > 2 * 1024 * 1024) {
        echo "<div class='container'><div class='alert alert-danger text-center' role='alert'>
                Ukuran gambar terlalu besar, maksimal 2MB
              </div></div>";
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            mysqli_query($conn, "UPDATE tb_pembelian SET status_pembelian = 'Menunggu Konfirmasi', bukti_transfer = '" . $fileName . "' WHERE id_pembelian = '" . $id_pembelian . "' ");
            $result4 = mysqli_query($conn, "SELECT * FROM tb_detail_pembelian WHERE id_pembelian = '" . $id_pembelian . "' ");

            while ($row = $result4->fetch_assoc()) {
                var_dump($row['total_jumlah']);
                mysqli_query($conn, "UPDATE tb_produk SET stok = stok - '" . $row['total_jumlah'] . "' WHERE id_produk = '" . $row['id_produk'] . "'");
            }
            $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Checkout berhasil!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            echo '<script>window.location="pesanan.php"</script>';
        } else {
            echo "<div class='container'><div class='alert alert-danger text-center' role='alert'>
                Gagal melakukan checkout!
              </div></div>";
        }
    }

}

?>

<body>
    <div class="container py-2 h-100 ">
        <div class="row justify-content-center align-items-center">
            <div>
                <div class="col-lg-4 mb-3">
                    <a href="keranjang.php" class="d-flex align-items-center back fs-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                        </svg>
                        Kembali
                    </a>
                </div>
                <h2 class="mb-3 text-center">Check Out</h2>
                <div class="row">
                    <?php if ($result1->num_rows > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-border-bottom align-middle text-nowrap">
                                <thead class="fw-bold">
                                    <tr>
                                        <td>Nama Produk</td>
                                        <td>Qty</td>
                                        <td>Harga</td>
                                        <td>Sub Total</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                                        <tr>
                                            <td>
                                                <p><?= $row['nama_produk'] ?></p>
                                            </td>
                                            <td>
                                                <p><?= $row['total_jumlah'] ?></p>
                                            </td>
                                            <td>
                                                <p>Rp <?= $row['harga_produk'] ?></p>
                                            </td>
                                            <td>
                                                <p>Rp <?= $row['total_harga'] ?></p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <p class="fw-bolder text-end">TOTAL : Rp <?= $order['total_harga'] ?></p>
                        </div>
                        <div>
                            <div class="container">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nama" class="font-weight-bold text-sm text-gray-600 mb-1">Nama</label>
                                        <input type="text" class="form-control" id="nama"
                                            value="<?php echo $a->nama_pelanggan ?>" disabled>
                                    </div>

                                    <div class=" form-group my-3">
                                        <label for="hp" class="font-weight-bold text-sm text-gray-600 mb-1">No. HP</label>
                                        <input type="number" class="form-control" id="hp"
                                            value="<?php echo $a->telepon_pelanggan ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat"
                                            class="font-weight-bold text-sm text-gray-600 mb-1">Alamat</label>
                                        <textarea class="form-control" id="alamat"
                                            disabled><?php echo $a->alamat_pelanggan ?></textarea>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="login"
                                            class="font-weight-bold text-sm text-gray-600 mb-1">Pembayaran</label>
                                        <select class="form-control" id="login">
                                            <option value="bca">BANK BCA - XXXXXXXXXXXXXXXX - John</option>
                                            <option value="mandiri">BANK MANDIRI - XXXXXXXXXXXXXX - Jane</option>
                                        </select>
                                    </div>

                                    <div class="form-group d-flex flex-column">
                                        <label for="bukti" class="font-weight-bold text-sm text-gray-600 mb-1 mb-1">Bukti
                                            Transfer</label>
                                        <input type="file" class="form-control-file" id="bukti" name="bukti_tf" required>
                                    </div>
                                    <div class="text-body-secondary mt-3">
                                        <p>*Untuk mengubah data Anda, silahkan ubah melalui menu <a href="detail-akun.php"
                                                class="text-decoration-none" style="color: var(--accent)">Akun Saya</a>
                                        </p>
                                    </div>
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="hidden" name="id_pembelian" value="<?= $order['id_pembelian'] ?>">
                                        <button type="submit" class="btn keranjang text-white py-2 fw-bold "
                                            name="checkout">CHECKOUT</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
    <?php include_once "footer.php" ?>
</body>