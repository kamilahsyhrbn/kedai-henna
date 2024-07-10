<?php
include 'admin/config/koneksi.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

function isUserLoggedIn()
{
    return isset($_SESSION['id_pelanggan']);
}

if (!isUserLoggedIn()) {
    $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Anda harus masuk terlebih dahulu!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    echo "<script>window.location='masuk.php'</script>";
}
$id_pembelian = $_GET['id_pembelian'];


$result1 = mysqli_query($conn, "SELECT tb_pembelian.*, tb_pelanggan.* FROM tb_pembelian 
                                      JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan  
                                      WHERE id_pembelian = '" . $id_pembelian . "' AND tb_pembelian.id_pelanggan = '" . $_SESSION['id_pelanggan'] . "' ");
$row1 = $result1->fetch_assoc();

$result2 = mysqli_query($conn, "SELECT tb_produk.*, tb_detail_pembelian.* FROM tb_detail_pembelian 
                                    JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk 
                                    WHERE tb_detail_pembelian.id_pembelian = '" . $id_pembelian . "'");


?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cetak Nota Pembelian | Kedai Henna</title>
<link rel="icon" href="admin/images/logo.png">
<link rel="stylesheet" href="css/style.css">
<script src="javascript/script.js"></script>
<!-- Bootstrap CSS -->
<!-- BOOTSTRAP CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Google Font: DM Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,200;0,9..40,300;0,9..40,600;0,9..40,700;1,9..40,200;1,9..40,300&display=swap"
    rel="stylesheet">
<!-- Google Font : Great Vibes -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

<!-- Download PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>

<body class="p-3">
    <div class="container">
        <div class="d-flex align-items-center border-bottom p-3">
            <div class="logo overflow-hidden rounded-3">
                <img src="admin/images/logo.png" alt="">
            </div>
            <div class="ps-3">
                <h1 class="brand-name">Kedai Henna</h1>
                <small class="fst-italic">By Ima Habsyi</small>
            </div>
        </div>
        <div class="row py-4 border-bottom">
            <div class="col-6">
                <h3>Penerima</h3>
                <div class="row">
                    <span class="fw-bold fs-5"><?= $row1['nama_pelanggan'] ?></span>
                    <span><?= $row1['alamat'], ", ", $row1['type'], " ", $row1['distrik'], ", ", $row1['provinsi'], " ", $row1['kode_pos'] ?></span>
                    <span><?= $row1['telepon_pelanggan'] ?></span>
                </div>
            </div>
            <div class="col-6">
                <h3>Pengirim</h3>
                <div class="row">
                    <span class="fw-bold fs-5">Kedai Henna</span>
                    <span>081234567890 </span>
                </div>
            </div>
        </div>

        <div class="border-bottom py-4">
            <h4>Informasi Pengiriman</h4>

            <div class="row">
                <div class="col-4">
                    <span class="fw-bold">Ekspedisi</span>
                    <span class="text-uppercase"><?= $row1['ekspedisi'] ?></span>
                </div>
                <div class="col-4">
                    <span class="fw-bold">Pengiriman</span>
                    <span><?= $row1['paket'] ?></span>
                </div>
                <div class="col-4">
                    <span class="fw-bold">No. Resi</span>
                    <span><?= $row1['resi'] ?></span>
                </div>
            </div>
        </div>

        <div class="table-responsive py-4">
            <table class="table table-border-bottom table-hover align-middle">
                <thead class="fw-bold">
                    <tr>
                        <td>Nama Produk</td>
                        <td>Qty</td>
                        <td>Harga</td>
                        <td>Sub Total</td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        ?>
                        <tr>
                            <td>
                                <p><?= $row2['nama_produk'] ?></p>
                            </td>
                            <td>
                                <p><?= $row2['total_jumlah'] ?></p>
                            </td>
                            <td>
                                <p>Rp <?= number_format($row2['harga_produk'], 0, ',', '.') ?></p>
                            </td>
                            <td>
                                <p>Rp <?= number_format($row2['total_harga'], 0, ',', '.') ?></p>
                            </td>
                        </tr>
                        <?php
                    } ?>


                </tbody>
            </table>
            <p class="fw-bolder text-end">TOTAL HARGA PRODUK : Rp
                <?= number_format($row1['total_harga'], 0, ',', '.') ?>
            </p>
            <p class="fw-bolder text-end">ONGKOS KIRIM : Rp
                <?= number_format($row1['ongkir'], 0, ',', '.') ?>
            </p>
            <p class="fw-bolder text-end">TOTAL : Rp
                <?= number_format($row1['total_bayar'], 0, ',', '.') ?>
            </p>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>

        <?php
        $fileName =
            'Nota -' . " " . $row1['nama_pelanggan'] . '.pdf';
        ?>

        <!-- Download PDF -->
        <script>
            window.onload = function () {
                var fileName = <?php echo json_encode($fileName); ?>;
                // Menggunakan html2pdf untuk mengkonversi halaman menjadi PDF
                html2pdf().from(document.body).save(fileName).then(function () {
                    // Menutup tab setelah download selesai
                    window.close();
                });
            };
        </script>
</body>

</html>