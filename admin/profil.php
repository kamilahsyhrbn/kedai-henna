<?php
$title = 'Profil Admin';
$page = 'profil';
include_once "sidebar.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['id_admin'])) {
    $id_admin = $_SESSION['id_admin'];
    $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE id_admin = '$id_admin'");
    $a = mysqli_fetch_object($admin);
}

if (isset($_POST['button-submit'])) {
    $nama_admin = ucwords($_POST['namaAdmin']);
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = md5($password);
        $sql = "UPDATE tb_admin SET
            nama_admin = '$nama_admin',
            email = '$email',
            password = '$hashed_password'";
    } else {
        $sql = "UPDATE tb_admin SET
            nama_admin = '$nama_admin',
            email = '$email'";
    }


    $sql .= " WHERE id_admin = " . $a->id_admin;

    if (mysqli_query($conn, $sql)) {
        $_SESSION['profile'] = '<div class="mt-2"><div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil Mengubah Profil Admin!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div></div>';
        echo '<script>window.location="profil.php"</script>';
        exit();
    } else {
        $_SESSION['profile'] = '<div class="mt-2"><div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal Mengubah Profil!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div></div>';
    }
}

?>

<body>
    <div class="container">
        <div class="position-relative w-100 d-grid py-2 ps-4">
            <?php
            if (isset($_SESSION['profile'])) {
                echo $_SESSION['profile'];
                unset($_SESSION['profile']);
            } ?>
            <div class="shadows position-relative p-3 rounded-4 bg-body mb-3">
                <div>
                    <h2 class="fw-semibold text-center mt-2">Profil Admin</h2>
                </div>
            </div>
            <div class="shadows position-relative d-grid p-3 rounded-4 bg-body">
                <form method="POST">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="namaAdmin" value="<?php echo $a->nama_admin ?>"
                            name="namaAdmin">
                        <label for="namaAdmin">Nama Admin</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                            value="<?php echo $a->username ?>" disabled>
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                            value="<?php echo $a->email ?>">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-2 position-relative d-flex align-items-center">
                        <input type="password" class="form-control" id="password" placeholder="Password"
                            name="password">
                        <label for="password">Password</label>
                        <span id="togglePassword" class="toggle-password position-absolute me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                                class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-secondary">*Biarkan kosong jika tidak ada perubahan</p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="button-submit w-50 my-3 py-2 fw-bold rounded-3"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">SIMPAN
                            PERUBAHAN</button>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Admin</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menyimpan perubahan?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary text-white"
                                        data-bs-dismiss="modal">Batal</button>
                                    <a href="profil.php" class="text-decoration-none">
                                        <button type="submit" class="btn btn-success text-white"
                                            name="button-submit">Ya</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                          </svg>`;
        const eyeSlashIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                              </svg>`;

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.innerHTML = type === 'password' ? eyeIcon : eyeSlashIcon;
        });
    </script>
    <?php include_once "footer.php" ?>
</body>