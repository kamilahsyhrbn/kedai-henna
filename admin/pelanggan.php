<?php
$title = 'Pelanggan';
$page = 'pelanggan';
include_once "sidebar.php";

$pelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan");

?>

<body>
    <div class="container">
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <?php
            if (isset($_SESSION['pelanggan'])) {
                echo $_SESSION['pelanggan'];
                unset($_SESSION['pelanggan']);
            } ?>
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Pelanggan</h2>
                </div>
            </div>
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <div class="table-responsive mt-4">
                    <?php if (mysqli_num_rows($pelanggan) > 0) { ?>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead>
                                <tr class="fw-semibold">
                                    <td>No</td>
                                    <td>Nama Pelanggan</td>
                                    <td>No. HP</td>
                                    <td>Alamat</td>
                                    <td>Email</td>
                                    <td>Tanggal Bergabung</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($pelanggan)) {
                                    $i++ ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['nama_pelanggan'] ?></td>
                                        <td><?php echo $row['telepon_pelanggan'] ?></td>
                                        <td><?php echo $row['alamat_pelanggan'] ?></td>
                                        <td><?php echo $row['email_pelanggan'] ?></td>
                                        <td> <?php echo date("d-m-Y", strtotime($row['tanggal_bergabung'])) ?></td>
                                        <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-id="<?php echo $row['id_pelanggan']; ?>">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="text-center mb-3">
                            Belum ada pelanggan mendaftar
                        </div>
                    <?php } ?>
                    <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Pelanggan
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus pelanggan ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary text-white"
                                        data-bs-dismiss="modal">Batal</button>
                                    <a href="" id="confirm-delete" class="text-decoration-none">
                                        <button type="button" class="btn btn-danger text-white">Hapus</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('exampleModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Tombol yang diklik untuk membuka modal
                const idPelanggan = button.getAttribute('data-id'); // Ambil id_pelanggan dari atribut data-id
                const confirmDelete = document.getElementById('confirm-delete');
                confirmDelete.href = `../admin/hapus.php?idpelanggan=${idPelanggan}`; // Set href dengan id_pelanggan yang benar
            });
        });

    </script>
    <?php include_once "footer.php" ?>
</body>