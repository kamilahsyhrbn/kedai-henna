<?php
$title = 'Akun Saya | Detail Pesanan';
$page = 'pesanan';
include_once "navbar.php";

$id = $_GET['id'];
$result1 = mysqli_query($conn, "SELECT tb_pembelian.*, tb_pembelian.tanggal_pembelian as tanggal_pembelian, tb_pelanggan.* FROM tb_pembelian 
                                      JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan  
                                      WHERE id_pembelian = $id");
$row1 = $result1->fetch_assoc();
$result2 = mysqli_query($conn, "SELECT tb_produk.*, tb_detail_pembelian.* FROM tb_detail_pembelian 
                                    JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk 
                                    WHERE tb_detail_pembelian.id_pembelian = $id ORDER BY tanggal_pembelian DESC");

if (isset($_POST['konfirmasiPesanan'])) {
    mysqli_query($conn, "UPDATE tb_pembelian SET status_pembelian = 'Selesai' WHERE id_pembelian = $id");
    $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Konfirmasi Pesanan Berhasil, Terima Kasih!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    echo '<script>window.location="pesanan.php"</script>';
}

?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="my-4">Detail Pesanan</h2>
            </div>
            <div class="col-lg-12">
                <?php include 'menu-akun.php' ?>

                <div class="container-fluid mt-4">
                    <div class="col-lg-4 mb-3">
                        <a href="pesanan.php" class="d-flex align-items-center back fs-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-chevron-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-around">
                                <div class="col-md-6">
                                    <div class="row">
                                        <span>Layanan</span>
                                        <span
                                            class="text-secondary text-uppercase"><?= $row1['ekspedisi'], " ", $row1['paket'] ?></span>
                                    </div>
                                    <div class="row my-3">
                                        <span>Nama Penerima</span>
                                        <span class="text-secondary"><?= $row1['nama_pelanggan'] ?></span>
                                    </div>
                                    <div class="row">
                                        <span>Tanggal Pembelian</span>
                                        <span
                                            class="text-secondary"><?= date("d/m/Y", strtotime($row1['tanggal_pembelian'])) ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <span>No. Resi</span>
                                        <span
                                            class="text-secondary text-uppercase"><?= $row1['resi'] ? $row1['resi'] : "Pesanan Anda belum dikirim" ?></span>
                                    </div>
                                    <div class="row my-3">
                                        <span>Alamat</span>
                                        <span
                                            class="text-secondary"><?= $row1['alamat'], ", ", $row1['type'], " ", $row1['distrik'], ", ", $row1['provinsi'], " ", $row1['kode_pos'] ?></span>
                                    </div>
                                    <div class="row">
                                        <span>No HP</span>
                                        <span class="text-secondary"><?= $row1['telepon_pelanggan'] ?> </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-4 mt-md-0">
                            <div class="bg-body-secondary p-4">
                                <div class="d-flex justify-content-between border-bottom border-dark-subtle pb-2">
                                    <h6 class="fw-semibold">NAMA PRODUK</h6>
                                    <h6 class="fw-semibold">TOTAL</h6>
                                </div>
                                <div class="border-bottom border-dark-subtle mt-2 py-2">
                                    <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                                        <div class="d-flex justify-content-between my-1">
                                            <h6><?= $row2['nama_produk'] ?> (<?= $row2['total_jumlah'] ?>x)</h6>
                                            <h6>Rp <?= number_format($row2['harga_produk'], 0, ',', '.') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="d-flex justify-content-between border-bottom border-dark-subtle mt-2 py-2">
                                    <h6>SUBTOTAL</h6>
                                    <h6>Rp <?= number_format($row1['total_harga'], 0, ',', '.') ?></h6>
                                </div>
                                <div class="d-flex justify-content-between border-bottom border-dark-subtle mt-2 py-2">
                                    <h6>ONGKIR</h6>
                                    <h6>Rp <?= number_format($row1['ongkir'], 0, ',', '.') ?></h6>
                                </div>
                                <div class="d-flex justify-content-between border-bottom border-dark-subtle mt-2 py-2">
                                    <h6 class="fw-semibold">TOTAL</h6>
                                    <h6 class="fw-semibold">Rp <?= number_format($row1['total_bayar'], 0, ',', '.') ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <?php if ($row1['status_pembelian'] === "Dikirim"): ?>
                            <div class="col-lg-6 mt-3">
                                <form method="POST">
                                    <button type="submit" name="konfirmasiPesanan"
                                        class="button rounded text-center d-inline-flex align-items-center fw-semibold">
                                        Pesanan Diterima
                                    </button>
                                </form>
                            </div>
                        <?php endif ?>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include_once "footer.php" ?>
</body>