<?php
$title = 'Ubah Data Produk';
$page = 'produk';
include_once ("sidebar.php");

$produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id_produk = '" . $_GET['id'] . "' ");

if (mysqli_num_rows($produk) == 0) {
    echo '<script>window.location="produk.php"</script>';
}
$p = mysqli_fetch_object($produk);

if (isset($_POST['button-submit'])) {
    $nama = ucwords($_POST['namaProduk']);
    $harga = $_POST['hargaProduk'];
    $status = $_POST['status'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "images/";
        $file = $_FILES['foto'];
        $fileType = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $fileName = uniqid() . '.' . $fileType;
        $targetFile = $targetDir . $fileName;

        $allowedExtensions = ["jpeg", "jpg", "png"];
        if (!in_array($fileType, $allowedExtensions)) {
            echo "<div class='container'><div class='alert alert-danger text-center' role='alert'>
                Format gambar yang diperbolehkan hanya .jpg, .jpeg dan .png
              </div></div>";
            echo '<script>alert("extension")</script>';
        } else if ($file["size"] > 2 * 1024 * 1024) {
            echo "<div class='container'><div class='alert alert-danger text-center' role='alert'>
                Ukuran gambar terlalu besar, maksimal 2mb
              </div></div>";
            echo '<script>alert("ukuran")</script>';
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                $update = mysqli_query($conn, "UPDATE tb_produk SET 
        nama_produk = '" . $nama . "',
        harga_produk = '" . $harga . "',
        status = '" . $status . "',
        stok = '" . $stok . "',
        deskripsi_produk = '" . $deskripsi . "',
        foto_produk = '" . $fileName . "'
        WHERE id_produk = " . $p->id_produk . " ");
            }
        }
    } else {
        $update = mysqli_query($conn, "UPDATE tb_produk SET 
        nama_produk = '" . $nama . "',
        harga_produk = '" . $harga . "',
        status = '" . $status . "',
        stok = '" . $stok . "',
        deskripsi_produk = '" . $deskripsi . "'
        WHERE id_produk = " . $p->id_produk . " ");
    }
    if ($update) {
        // echo '<script>alert("Berhasil mengubah produk!")</script>';
        $_SESSION['produk'] = '<div class="container ms-2 mt-2"><div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil Mengubah Produk!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div></div>';
        echo '<script>window.location="produk.php"</script>';
    } else {
        echo 'Fail' . mysqli_error($conn);
    }
}

?>

<body>
    <div class="container">
        <div class="row mb-2">
            <div class="col-lg-4">
                <a href="produk.php" class="d-flex align-items-center back fs-5 ">
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
                        <h2 class="fw-semibold text-center mt-2">Ubah Data Produk</h2>
                    </div>
                </div>
                <div class="shadows mt-3 position-relative d-grid p-3 rounded-4 bg-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class=" row">
                            <div class="col-lg-8">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="namaProduk" placeholder="Nama Produk"
                                        name="namaProduk" value="<?php echo $p->nama_produk ?>">
                                    <label for="namaProduk">Nama Produk</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="hargaProduk" placeholder="Harga"
                                        name="hargaProduk" value="<?php echo $p->harga_produk ?>">
                                    <label for="hargaProduk">Harga</label>
                                </div>

                                <select class="form-select mb-2" aria-label="Default select example" id="selectOption"
                                    name="status">
                                    <option selected disabled>Status</option>
                                    <option value="Tersedia" <?php echo ($p->status == 'Tersedia') ? 'selected' : ''; ?>>
                                        Tersedia</option>
                                    <option value="Habis" <?php echo ($p->status == 'Habis') ? 'selected' : ''; ?>>Habis
                                    </option>
                                </select>

                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" id="stokProduk" placeholder="Stok"
                                        name="stok" value="<?php echo $p->stok ?>" min="1">
                                    <label for="stokProduk">Stok</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <textarea class="form-control" placeholder="Deskripsi" name="deskripsi"
                                        id="floatingTextarea"><?php echo $p->deskripsi_produk ?></textarea>
                                    <label for="floatingTextarea">Deskripsi</label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label
                                    class="custom-file-upload d-flex flex-col align-items-between justify-content-center rounded-2 shadows align-items-center"
                                    for="file">
                                    <div class="upload-container">
                                        <div class="icon" id="upload-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                                <g stroke-linejoin="round" stroke-linecap="round"
                                                    id="SVGRepo_tracerCarrier">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path fill=""
                                                        d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="text" id="upload-text">
                                            <span>Klik untuk memasukkan foto</span>
                                        </div>
                                        <input type="file" id="file" onchange="previewImage()" name="foto">
                                        <div id="preview-container">
                                            <?php if (!empty($p->foto_produk) && file_exists("images/" . $p->foto_produk)): ?>
                                                <img id="preview-image" src="images/<?php echo $p->foto_produk; ?>" alt="">
                                            <?php else: ?>
                                                <img id="preview-image" alt="">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </label>
                                <p class="text-secondary mt-2">*Biarkan kosong jika tidak ada perubahan</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="button-submit w-50 my-3 py-2 fw-bold rounded-3" type="submit"
                                name="button-submit">UBAH DATA
                                PRODUK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage() {
            var previewContainer = document.getElementById('preview-container');
            var uploadIcon = document.getElementById('upload-icon');
            var uploadText = document.getElementById('upload-text');
            var fileInput = document.getElementById('file');
            var previewImage = document.getElementById('preview-image');

            previewImage.style.borderRadius = '10px';
            previewContainer.style.height = '200px';
            previewImage.src = URL.createObjectURL(event.target.files[0]);

            previewContainer.style.display = 'block';

            var file = fileInput.files[0];

            if (file) {
                previewContainer.style.display = 'block';
                uploadIcon.style.display = 'none';
                uploadText.style.display = 'none';

                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-image').src = e.target.result;
                }

                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                uploadIcon.style.display = 'flex';
                uploadText.style.display = 'flex';
            }
        }

        // function formatCurrency(input) {
        //     const value = input.value.replace(/[^\d]/g, '');
        //     const formattedValue = 'Rp ' + addThousandSeparator(value);
        //     input.value = formattedValue;
        // }

        // function addThousandSeparator(value) {
        //     return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        // }
    </script>
    <?php include_once ("footer.php") ?>
</body>