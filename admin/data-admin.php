<?php
$title = 'Data Admin';
$page = 'admin';
include_once "sidebar.php";
$admin = mysqli_query($conn, "SELECT * FROM tb_admin");
?>


<body>
    <div class="container py-3">
        <div class="d-flex justify-content-end pb-2">
            <a href="tambah-admin.php"
                class="button text-decoration-none position-relative py-2 px-3 text-white fw-semibold rounded">TAMBAH
                ADMIN</a>
        </div>
        <?php
        if (isset($_SESSION['admin'])) {
            echo $_SESSION['admin'];
            unset($_SESSION['admin']);
        } ?>
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Data Admin</h2>
                </div>
            </div>
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-hover align-middle text-nowrap">
                        <thead>
                            <tr class="fw-semibold">
                                <td>No</td>
                                <td>Nama Admin</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_assoc($admin)) {
                                $i++ ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['nama_admin'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-id="<?php echo $row['id_admin']; ?>">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Admin
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus admin ini?
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
                const idAdmin = button.getAttribute('data-id'); // Ambil id_produk dari atribut data-id
                const confirmDelete = document.getElementById('confirm-delete');
                confirmDelete.href = `../admin/hapus.php?idAdmin=${idAdmin}`; // Set href dengan id_produk yang benar
            });
        });

    </script>
    <?php include_once "footer.php" ?>
</body>