<?php
$title = 'Buat Akun';
$page = 'daftar';
include_once ("navbar.php");

date_default_timezone_set('Asia/Jakarta');
if (isset($_POST['button-submit'])) {
    $nama_pelanggan = ucwords($_POST['nama_pelanggan']);
    $telepon_pelanggan = $_POST['telepon_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];
    $email_pelanggan = $_POST['email_pelanggan'];
    $password_pelanggan = md5($_POST['password_pelanggan']);
    $currentTimestamp = time();
    $tanggal_bergabung = date('Y-m-d H:i:s', $currentTimestamp);

    // Query untuk mengecek apakah email sudah ada di tabel users
    $query = "SELECT * FROM tb_pelanggan WHERE email_pelanggan = '$email_pelanggan'";
    $result = mysqli_query($conn, $query);

    // Jika hasil query lebih dari 0, maka email sudah ada di database
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email yang Anda masukkan sudah terdaftar!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div></div>';
        // echo "<script>window.location='daftar.php'</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO tb_pelanggan VALUES (
                                null,
                                '" . $nama_pelanggan . "',
                                '" . $telepon_pelanggan . "',
                                '" . $alamat_pelanggan . "',
                                '" . $email_pelanggan . "',
                                '" . $password_pelanggan . "',
                                '" . $tanggal_bergabung . "'
                                )");

        if ($insert) {
            $alert = urlencode('<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil membuat akun! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            echo "<script>window.location='masuk.php?alert=$alert'</script>";
        } else {
            echo "<script>displayModal('Registration Failed: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="my-4">Buat Akun</h2>
                <p>Silakan masukkan email, password dan data diri Anda untuk membuat akun. </p>
            </div>
            <div>
                <form method="POST" onsubmit="return register();">
                    <div class="input-margin">
                        <div class="input-container">
                            <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>
                            <label for="nama_pelanggan" class="label">Nama Lengkap<span
                                    class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <input type="text" id="telepon_pelanggan" name="telepon_pelanggan" required>
                            <label for="telepon_pelanggan" class="label">No. HP<span
                                    class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <input type="text" id="alamat_pelanggan" name="alamat_pelanggan" required>
                            <label for="alamat_pelanggan" class="label">Alamat<span class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <input type="text" id="email_pelanggan" name="email_pelanggan" required>
                            <label for="email_pelanggan" class="label">Email<span class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <input type="password" id="password_pelanggan" name="password_pelanggan" required>
                            <label for="password_pelanggan" class="label">Password<span
                                    class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <input type="password" id="confirm-password" name="confirm-password" required>
                            <label for="confirm-password" class="label">Konfirmasi Password<span
                                    class="text-danger">*</span></label>
                            <div class="underline"></div>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button class="button-submit mb-2 fw-bold" type="submit" onclick="register()"
                            name="button-submit">REGISTER</button>
                        <p class="p">Sudah punya akun? <a href="masuk.php" class="accent fw-semibold">MASUK</a></p>
                    </div>
                </form>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <p id="alertMessage"></p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once ("footer.php") ?>
    <script>
        function register() {
            var nama_pelanggan = document.getElementById('nama_pelanggan').value;
            var telepon = document.getElementById('telepon_pelanggan').value;
            var alamat_pelanggan = document.getElementById('alamat_pelanggan').value;
            var email_pelanggan = document.getElementById('email_pelanggan').value;
            var password_pelanggan = document.getElementById('password_pelanggan').value;
            var confirmPassword = document.getElementById('confirm-password').value;

            if (!nama_pelanggan || !telepon || !alamat_pelanggan || !email_pelanggan || !password_pelanggan || !confirmPassword) {
                displayModal('Harap isi semua atribut!');
                return false;
            }

            if (password_pelanggan !== confirmPassword) {
                displayModal('Password yang Anda masukkan tidak sama!');
                return false;
            }
            return displayModal;
        }

        function displayModal(message) {
            var modal = document.getElementById('myModal');
            var alertMessage = document.getElementById('alertMessage');
            alertMessage.textContent = message;
            modal.style.display = 'block';
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }
    </script>
</body>