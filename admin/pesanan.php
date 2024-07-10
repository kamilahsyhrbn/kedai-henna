<?php
$title = 'Pesanan';
$page = 'pesanan';
include_once "sidebar.php";

$result = mysqli_query($conn, "SELECT tb_pelanggan.nama_pelanggan, tb_pembelian.* FROM tb_pembelian JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan WHERE status_pembelian IS NOT NULL ORDER BY tanggal_pembelian DESC");

?>



<body>
    <div class="container">
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <?php
            if (isset($_SESSION['status-alert'])) {
                echo $_SESSION['status-alert'];
                unset($_SESSION['status-alert']);
            } ?>
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Pesanan</h2>
                </div>
            </div>
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <div class="table-responsive mt-4">
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead>
                                <tr class="fw-semibold">
                                    <td>No</td>
                                    <td>Nama Pelanggan</td>
                                    <td>Tanggal</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <?= $row['nama_pelanggan'] ?>
                                        </td>
                                        <td>
                                            <?php echo date("d-m-Y", strtotime($row['tanggal_pembelian'])) ?>
                                        </td>
                                        <td>
                                            Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?= $row['status_pembelian'] ?>
                                        </td>
                                        <td>
                                            <a href="detail-pesanan.php?id=<?= $row['id_pembelian']; ?>"
                                                class="btn btn-sm btn-secondary">Detail</a>
                                        </td>
                                    </tr>

                                <?php }
                } else { ?>
                                <div class="text-center fw-semibold">
                                    Tidak ada pesanan terbaru
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>