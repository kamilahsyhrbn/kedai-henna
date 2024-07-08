<?php
session_start();
include 'config/koneksi.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


if ($_SESSION['status_login'] != true) {
    $_SESSION['login-alert'] = '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu!</div>';
    echo "<script>window.location='masuk.php'</script>";
    exit();
}

$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$status = $_GET['status'];

$query = "SELECT tb_pelanggan.nama_pelanggan, tb_pembelian.* FROM tb_pembelian JOIN tb_pelanggan 
ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan WHERE tanggal_pembelian BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";

if ($status != "Semua") {
    $query .= " AND status_pembelian = '$status'";
} else {
    $query .= " AND status_pembelian IS NOT NULL";
}

$result = mysqli_query($conn, $query);
$total_pemasukan = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan | Admin Kedai Henna</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/style.css">
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
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>

<body class="p-3">
    <div class="container">
        <div class="d-flex align-items-center border-bottom p-3">
            <div class="logo overflow-hidden rounded-3">
                <img src="images/logo.png" alt="">
            </div>
            <div class="ps-3">
                <h1 class="brand-name">Kedai Henna</h1>
                <small class="fst-italic">By Ima Habsyi</small>
            </div>
        </div>
        <div>
            <h3 class="text-center my-3 fw-semibold">Laporan tanggal <?= $tanggal_mulai ?> sampai <?= $tanggal_akhir ?>
            </h3>
        </div>
        <div class="table-responsive py-4">
            <table class="table table-borderless align-middle">
                <thead class="fw-bold">
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>Nama Pelanggan</td>
                        <td>Jumlah</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0;
                    while ($data = mysqli_fetch_array($result)) {
                        $i++ ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $data['tanggal_pembelian'] ?></td>
                            <td><?= $data['nama_pelanggan'] ?></td>
                            <td>Rp <?= $data['total_harga'] ?></td>
                            <td><?= $data['status_pembelian'] ?></td>
                        </tr>
                        <?php
                        $total_pemasukan += $data['total_harga'];
                    } ?>
                    <tr class="fw-semibold">
                        <td colspan="3">TOTAL</td>
                        <td colspan="2">Rp <?= $total_pemasukan ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
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
        'Laporan ' . $tanggal_mulai . " sampai " . $tanggal_akhir . '.pdf';
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