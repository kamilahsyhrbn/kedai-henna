<?php
$title = 'Produk';
$page = 'produk';
include_once "sidebar.php";
$result = mysqli_query($conn, "SELECT * FROM tb_produk");
?>


<body>
    <div class="container py-3">
        <div class="d-flex justify-content-end pb-2">
            <a href="tambah-produk.php"
                class="button text-decoration-none position-relative py-2 px-3 text-white fw-semibold rounded">TAMBAH
                PRODUK</a>
        </div>
        <?php
        if (isset($_SESSION['produk'])) {
            echo $_SESSION['produk'];
            unset($_SESSION['produk']);
        } ?>
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Produk</h2>
                </div>
            </div>
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-hover align-middle">
                        <thead>
                            <tr class="fw-semibold ">
                                <td>Nama Produk</td>
                                <td>Harga</td>
                                <td>Status</td>
                                <td>Stok</td>
                                <td class="description">Deskripsi</td>
                                <td>Foto Produk</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td> <?php echo $row['nama_produk'] ?></td>
                                    <td>Rp <?php echo $row['harga_produk'] ?></td>
                                    <td> <?php echo $row['status'] ?></td>
                                    <td> <?php echo $row['stok'] ?></td>
                                    <td class="description"> <?php echo $row['deskripsi_produk'] ?></td>
                                    <td class="photo">
                                        <div class='frame position-relative rounded overflow-hidden'> <img
                                                src="images/<?php echo $row['foto_produk'] ?>" alt=""
                                                class="position-absolute top-0 left-0 w-100 h-100 object-cover">
                                        </div>
                                    </td>
                                    <td class="action">
                                        <a href="ubah-produk.php?id=<?php echo $row['id_produk']; ?>"
                                            class="text-decoration-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path
                                                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                        </svg>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-id="<?php echo $row['id_produk']; ?>">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                        </svg>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Produk</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin produk ini?
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
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('exampleModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Tombol yang diklik untuk membuka modal
                const idProduk = button.getAttribute('data-id'); // Ambil id_produk dari atribut data-id
                const confirmDelete = document.getElementById('confirm-delete');
                confirmDelete.href = `../admin/hapus.php?idproduk=${idProduk}`; // Set href dengan id_produk yang benar
            });
        });

    </script>
    <?php include_once "footer.php" ?>
</body>