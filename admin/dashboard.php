<?php
$title = 'Dashboard';
$page = 'dashboard';
include_once "sidebar.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['id_admin'])) {
    $id_admin = $_SESSION['id_admin'];
    $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE id_admin = '$id_admin'");
    $a = mysqli_fetch_object($admin);
}
$pelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan ORDER BY tanggal_bergabung DESC LIMIT 3");
$pembelian = mysqli_query($conn, "SELECT tb_pelanggan.nama_pelanggan, tb_pembelian.* FROM tb_pembelian JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_pembelian.id_pelanggan WHERE status_pembelian = 'Menunggu Konfirmasi' ORDER BY tanggal_pembelian DESC LIMIT 4");

$jumlah_produk = mysqli_query($conn, "SELECT COUNT(*) as total_produk FROM tb_produk");
$jumlah_pesanan = mysqli_query($conn, "SELECT COUNT(*) as total_pesanan FROM tb_pembelian WHERE status_pembelian IS NOT NULL");
$jumlah_pelanggan = mysqli_query($conn, "SELECT COUNT(*) as total_pelanggan FROM tb_pelanggan");
$pemasukkan = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE status_pembelian = 'Selesai'");

$total_pemasukan = 0;

while ($jumlah_pemasukkan = mysqli_fetch_array($pemasukkan)) {
    $total_pemasukan += $jumlah_pemasukkan['total_harga'];
}
;

$data_produk = mysqli_fetch_assoc($jumlah_produk);
$data_pesanan = mysqli_fetch_assoc($jumlah_pesanan);
$data_pelanggan = mysqli_fetch_assoc($jumlah_pelanggan);
?>




<body>
    <div class="position-relative w-100">
        <?php include_once "sidebar.php"; ?>
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            } ?>
            <div class="position-relative d-grid p-3 rounded-4 bg-body shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="fw-bold">Selamat Datang, <?php echo $a->nama_admin ?> </h3>
                </div>
            </div>
        </div>
        <div class="upBoxes position-relative w-100 d-grid py-2 ps-4">
            <div class="position-relative d-grid p-3 rounded-4 bg-body shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold">Total Produk</h5>
                    <h3 class="fw-bold accent"><?= $data_produk['total_produk'] ?></h3>
                </div>
            </div>
            <div class="position-relative d-grid p-3 rounded-4 bg-body shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold">Total Pesanan</h5>
                    <h3 class="fw-bold accent"><?= $data_pesanan['total_pesanan'] ?></h3>
                </div>
            </div>
            <div class="position-relative d-grid p-3 rounded-4 bg-body shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold">Total Pelanggan</h5>
                    <h3 class="fw-bold accent"><?= $data_pelanggan['total_pelanggan'] ?></h3>
                </div>
            </div>
            <div class="position-relative d-grid p-3 rounded-4 bg-body shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold">Total Pemasukan</h5>
                    <h4 class="fw-bold accent"><?= $total_pemasukan ?></h4>
                </div>
            </div>
        </div>
        <div class="boxes position-relative w-100 d-grid py-2 ps-4">
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <div class="cardHeader d-flex justify-content-between align-items-start">
                    <h2 class="fw-semibold">Pesanan Terbaru</h2>
                    <a href="pesanan.php"
                        class="button position-relative py-1 px-2 text-white rounded fw-semibold text-decoration-none">LIHAT
                        SEMUA</a>
                </div>
                <div class="table-responsive mt-4">
                    <?php if (mysqli_num_rows($pembelian) > 0) { ?>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead>
                                <tr class="fw-semibold">
                                    <td>Nama Pelanggan</td>
                                    <td>Tanggal</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($pembelian)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['nama_pelanggan'] ?>
                                        </td>
                                        <td>
                                            <?php echo date("d-m-Y", strtotime($row['tanggal_pembelian'])) ?>
                                        </td>
                                        <td>
                                            Rp <?php echo $row['total_harga'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['status_pembelian'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                    } else {
                        ?>
                                <div class="text-center fw-semibold">
                                    Tidak ada pesanan yang menunggu konfirmasi
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- pelanggan baru -->
            <div class="recentpelanggans position-relative d-grid p-3 bg-body rounded-4 shadows">
                <div class="d-flex justify-content-between align-items-start">
                    <h2 class="fw-semibold">Pelanggan Terbaru</h2>
                </div>
                <div class="table-responsive mt-4">
                    <?php if (mysqli_num_rows($pembelian) > 0) { ?>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <?php while ($row = mysqli_fetch_assoc($pelanggan)) { ?>
                                <tr>
                                    <td width="60px" class="py-3 px-1">
                                        <div class="imgBox position-relative rounded-full overflow-hidden">
                                            <img src="images/default_pfp.png"
                                                class="position-absolute top-0 left-0 w-100 h-100 object-cover">
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <p class="fw-semibold fs-6">
                                            <?php echo $row['nama_pelanggan'] ?> <br> <span class="fw-normal">
                                                <?php echo $row['telepon_pelanggan'] ?>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            <?php }
                    } else { ?>
                            <div class="text-center fw-semibold">
                                Tidak ada pelanggan terbaru
                            </div>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>

</html>

<?php include "footer.php" ?>