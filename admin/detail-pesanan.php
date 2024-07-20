<?php
$title = 'Detail Pesanan';
$page = 'pesanan';
include_once "sidebar.php";

$id = $_GET['id'];
$result1 = mysqli_query($conn, "SELECT tb_pembelian.*, tb_pembelian.tanggal_pembelian as tanggal_pembelian, tb_pelanggan.* FROM tb_pembelian 
                                      JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan  
                                      WHERE id_pembelian = $id");
$row1 = $result1->fetch_assoc();
$result2 = mysqli_query($conn, "SELECT tb_produk.*, tb_detail_pembelian.* FROM tb_detail_pembelian 
                                    JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk 
                                    WHERE tb_detail_pembelian.id_pembelian = $id ORDER BY tanggal_pembelian DESC");


if (isset($_POST['button-submit'])) {
    $status = $_POST['status'];
    $resi = $_POST['resi'];

    if (!empty($resi)) {
        mysqli_query($conn, "UPDATE tb_pembelian SET resi = '" . $resi . "', status_pembelian = '" . $status . "' WHERE id_pembelian = $id");
        $_SESSION['status-alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Berhasil memasukkan resi dan mengubah status pengiriman!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
        echo '<script>window.location="pesanan.php"</script>';
    } else {
        mysqli_query($conn, "UPDATE tb_pembelian SET status_pembelian = '" . $status . "' WHERE id_pembelian = $id");
        $_SESSION['status-alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil mengubah status pengiriman!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        echo '<script>window.location="pesanan.php"</script>';
    }
}

?>

<body>
    <div class="container">
        <div class="row mb-2">
            <div class="col-lg-4">
                <a href="pesanan.php" class="d-flex align-items-center back fs-5 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div>
            <div class="position-relative w-100 d-grid py-2 ps-4">
                <div class="shadows position-relative p-3 rounded-4 bg-body">
                    <div>
                        <h2 class="fw-semibold text-center mt-2">Detail Pesanan</h2>
                    </div>
                </div>
                <div class="shadows position-relative mt-3 d-grid p-3 rounded-4 bg-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-borderless table-hover align-middle text-nowrap border-bottom">
                            <thead>
                                <tr class="fw-semibold ">
                                    <td>Nama Produk</td>
                                    <td>Qty</td>
                                    <td>Harga</td>
                                    <td>Sub Total</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
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
                                <?php } ?>
                            </tbody>
                        </table>

                        <p class="fw-bolder text-end">TOTAL HARGA PRODUK : Rp
                            <?= number_format($row1['total_harga'], 0, ',', '.') ?>
                        <p class="fw-bolder text-end">ONGKIR : Rp <?= number_format($row1['ongkir'], 0, ',', '.') ?>
                        <p class="fw-bolder text-end">TOTAL : Rp <?= number_format($row1['total_bayar'], 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
                <div class="shadows mt-3 position-relative d-grid p-3 rounded-4 bg-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="table-responsive mt-4">
                                    <table class="table table-borderless table-hover align-middle text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td width="30px">Tanggal</td>
                                                <td width="25px">:</td>
                                                <td>
                                                    <?= date("d/m/Y", strtotime($row1['tanggal_pembelian'])) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td><?= $row1['nama_pelanggan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. HP</td>
                                                <td>:</td>
                                                <td><?= $row1['telepon_pelanggan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>:</td>
                                                <td><?= $row1['alamat'], ", ", $row1['type'], " ", $row1['distrik'], ", ", $row1['provinsi'], " ", $row1['kode_pos'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Layanan</td>
                                                <td>:</td>
                                                <td class="text-uppercase">
                                                    <?= $row1['ekspedisi'], " ", $row1['paket'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No. Resi</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="border-0 w-100" name="resi" id="resi"
                                                        value=<?= $row1['resi'] ?
                                                            $row1['resi'] : "" ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>:</td>
                                                <td> <select name="status" id="" class="border-0 w-100">
                                                        <option value="Menunggu Konfirmasi" <?php echo ($row1['status_pembelian'] == 'Menunggu Konfirmasi') ? 'selected' : ''; ?>>
                                                            Menunggu Konfirmasi</option>
                                                        <option value="Diproses" <?php echo ($row1['status_pembelian'] == 'Diproses') ? 'selected' : ''; ?>>
                                                            Diproses</option>
                                                        <option value="Dikirim" <?php echo ($row1['status_pembelian'] == 'Dikirim') ? 'selected' : ''; ?>>
                                                            Dikirim</option>
                                                        <option value="Ditolak" <?php echo ($row1['status_pembelian'] == 'Ditolak') ? 'selected' : ''; ?>>
                                                            Ditolak</option>
                                                        <option value="Selesai" <?php echo ($row1['status_pembelian'] == 'Selesai') ? 'selected' : ''; ?>>
                                                            Selesai</option>
                                                    </select></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class=" col-lg-4">
                                <h5 class="fw-semibold">Bukti Transfer :</h5>
                                <div class="bukti-tf">
                                    <?php if ($row1['bukti_transfer'] != null) { ?>
                                        <img src="images/<?= $row1['bukti_transfer'] ?>" class="w-100 h-100 object-cover" />
                                    <?php } else { ?>
                                        <div class="text-center">
                                            Belum ada bukti transfer
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="button-submit col-sm-12 col-md-6 my-3 py-2 px-3 fw-bold rounded-3"
                                type="submit" name="button-submit">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>