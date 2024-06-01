<?php
$title = 'Laporan';
$page = 'laporan';
include_once ("sidebar.php");

if (isset($_POST['button-submit'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $status = $_POST['status'];

    $tanggal_mulai_formatted = date("Y-m-d", strtotime($tanggal_mulai));
    $tanggal_akhir_formatted = date("Y-m-d", strtotime($tanggal_akhir));

    $query = "SELECT tb_pelanggan.nama_pelanggan, tb_pembelian.* FROM tb_pembelian JOIN tb_pelanggan 
    ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan WHERE tanggal_pembelian BETWEEN '$tanggal_mulai_formatted' AND '$tanggal_akhir_formatted'";

    if ($status != "Semua") {
        $query .= " AND status_pembelian = '$status'";
    } else {
        $query .= " AND status_pembelian IS NOT NULL";
    }

    $result = mysqli_query($conn, $query);
    $total_pemasukan = 0;

}
?>


<body>
    <div class="container py-3">
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Laporan</h2>
                </div>
            </div>
            <form action="" method="POST">
                <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1">Tanggal Mulai : </p>
                            <input id="datepicker1" width="276" name="tanggal_mulai"
                                value="<?= $tanggal_mulai_formatted ?>" required />
                            <script>
                                $('#datepicker1').datepicker({
                                    uiLibrary: 'bootstrap5'
                                });
                            </script>
                        </div>

                        <div>
                            <p class="mb-1">Tanggal Akhir : </p>
                            <input id="datepicker2" width="276" name="tanggal_akhir"
                                value="<?= $tanggal_akhir_formatted ?>" required />
                            <script>
                                $('#datepicker2').datepicker({

                                    uiLibrary: 'bootstrap5'
                                });
                            </script>
                        </div>
                        <div>
                            <select name="status" id="" class="border w-100 py-1 px-3 rounded-3" required>
                                <option value="Semua">Semua</option>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div>
                            <a href="" class="text-decoration-none me-5">
                                <button class="button py-2 px-4 text-white fw-semibold rounded border-0"
                                    name="button-submit">
                                    LIHAT
                                </button>
                            </a>
                        </div>
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <div>
                                <form method="POST">
                                    <button type="submit" class="button py-2 px-4 text-white fw-semibold rounded border-0"
                                        name="cetak">
                                        CETAK
                                    </button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <div>
                                <button class="button py-2 px-4 text-white fw-semibold rounded border-0 bg-secondary"
                                    disabled>
                                    CETAK
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                    <?php if (mysqli_num_rows($result) > 0) { ?>
                        <h4 class="fw-semibold text-center">Laporan transaksi dari <?php echo $tanggal_mulai_formatted ?>
                            sampai <?php echo $tanggal_akhir_formatted ?></h4>
                        <div class="table-responsive mt-4">
                            <table class="table table-borderless table-hover align-middle">
                                <thead>
                                    <tr class="fw-semibold ">
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
                                        <td colspan="2">Rp <?php echo $total_pemasukan ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="text-center fw-semibold">
                            Belum ada laporan dengan status <?= $status ?> pada tanggal <?= $tanggal_mulai_formatted ?>
                            hingga
                            <?= $tanggal_akhir_formatted ?>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <?php include_once ("footer.php") ?>
</body>