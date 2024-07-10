<?php
$title = 'Akun Saya | Pesanan';
$page = 'pesanan';
include_once "navbar.php";

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $customer = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    $a = mysqli_fetch_object($customer);
}

$result1 = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE id_pelanggan = '" . $_SESSION['id_pelanggan'] . "' AND status_pembelian IS NOT NULL ORDER BY tanggal_pembelian DESC");

?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="my-4">Pesanan Saya</h2>
                <?php
                if (isset($_SESSION['alert'])) {
                    echo $_SESSION['alert'];
                    unset($_SESSION['alert']);
                } ?>
            </div>
            <div class="col-lg-12">
                <?php include 'menu-akun.php' ?>
                <div class="container-fluid mt-4">
                    <?php if ($result1->num_rows > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-border-bottom table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="fw-bold">
                                        <td scope="col">No</td>
                                        <td scope="col">Tanggal Pembelian</td>
                                        <td scope="col">Status Pembelian</td>
                                        <td scope="col">Total</td>
                                        <td scope="col">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($result1)) {
                                        $i++;
                                        $idPembelian = $row['id_pembelian'];
                                        ?>
                                        <tr>
                                            <td scope="row"><?= $i ?></td>
                                            <td><?= date("d-m-Y", strtotime($row['tanggal_pembelian'])) ?></td>
                                            <td><?= $row['status_pembelian'] ?></td>
                                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                            <td><button class="border-0 nota px-2 py-1 text-white rounded-2 download-btn"
                                                    data-id="<?= $idPembelian ?>">Cetak Nota</button></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="text-center fw-semibold">
                                <p>Anda belum memesan apapun</p>
                                <a href="belanja.php">
                                    <span class="accent fw-semibold">Belanja sekarang</span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <button type="button"
                        class="button rounded text-center d-inline-flex align-items-center fw-semibold"
                        onclick="refresh()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path
                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z">
                            </path>
                        </svg>
                        REFRESH
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Untuk refresh -->
    <script>
        function refresh() {
            location.reload();
        }
    </script>

    <!-- Untuk download PDF -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.download-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var idPembelian = this.getAttribute('data-id');
                    window.open('cetak-nota.php?id_pembelian=' + idPembelian, '_blank');
                });
            });
        });
    </script>

    <?php include_once "footer.php" ?>
</body>