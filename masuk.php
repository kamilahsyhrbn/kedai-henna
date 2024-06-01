<?php
$title = 'Masuk';
$page = 'masuk';
include_once ("navbar.php");

if (isset($_GET['alert'])) {
    $_SESSION['alert'] = urldecode($_GET['alert']);
}


if (isUserLoggedIn()) {
    $_SESSION['login-alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Anda sudah masuk!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    echo "<script>window.location='index.php'</script>";
}

if (isset($_POST['button-submit'])) {
    $email = $_POST['email_pelanggan'];
    $password = $_POST['password_pelanggan'];

    $cek = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE email_pelanggan = '" . $email . "' AND password_pelanggan = '" . md5($password) . "'");

    if (mysqli_num_rows($cek) > 0) {
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id_pelanggan'] = $d->id_pelanggan;
        $_SESSION['login-alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil masuk!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        echo "<script>window.location='index.php'</script>";
    } else {
        echo '<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email atau password salah!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div></div>';
    }

}
?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <?php if (isset($_SESSION['alert'])):
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            endif; ?>
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="mt-4">Masuk</h2>
                <p>Silakan masukkan email dan password Anda untuk masuk ke akun Anda. </p>
            </div>
            <div class="container-fluid">
                <form method="POST">
                    <div class="input-margin">
                        <div class="input-container">
                            <input type="text" id="email_pelanggan" name="email_pelanggan" required>
                            <label for="email_pelanggan" class="label">Email</label>
                            <div class="underline"></div>
                        </div>
                        <div class="input-container">
                            <span id="togglePassword" class="toggle-password position-absolute ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </span>

                            <input type="password" id="password_pelanggan" name="password_pelanggan" required>
                            <label for="password_pelanggan" class="label">Password</label>
                            <div class="underline"></div>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button class="button-submit mb-2 fw-bold" name="button-submit" type="submit"
                            onclick="login()">MASUK</button>
                        <p>Belum punya akun? <a href="daftar.php" class="accent fw-semibold">DAFTAR</a></p>
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
        function login() {
            var email = document.getElementById('email_pengguna').value;
            var password = document.getElementById('password_pengguna').value;

            if (!email || !password) {
                displayModal('Masukkan email dan password!');
                return false;
            }

            displayModal('Login Berhasil');
            return displayModal;
        }

        function displayModal(message) {
            var modal = document.getElementById('myModal');
            var alertMessage = document.getElementById('alertMessage');
            alertMessage.textContent = message;
            modal.style.display = 'block';

            if (message === 'Login Berhasil') {
                setTimeout(function () {
                    closeModal();
                    window.location = 'index.php';
                }, 2000);
            }
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password_pelanggan');
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
</body>