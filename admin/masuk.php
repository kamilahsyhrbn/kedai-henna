<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "config/koneksi.php";

session_start();


if ($_SESSION['status_login_admin'] === true) {
    $_SESSION['login'] = '<div class="alert alert-danger" role="alert">Anda sudah masuk!</div>';
    echo "<script>window.location='dashboard.php'</script>";
    exit();
}


if (isset($_POST['button'])) {

    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (empty($user) || empty($pass)) {
        $_SESSION['login-alert'] = '<div class="alert alert-danger" role="alert">
    Harap isi semua atribut!
</div>';
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '" . $user . "' AND password = '" . MD5($pass) .
            "'");
        if (mysqli_num_rows($cek) > 0) {
            $d = mysqli_fetch_object($cek);
            $_SESSION['status_login_admin'] = true;
            $_SESSION['a_global'] = $d;
            $_SESSION['id_admin'] = $d->id_admin;
            echo "<script>window.location = 'dashboard.php'</script>";
            $_SESSION['login'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Berhasil Masuk!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        } else {
            $_SESSION['login-alert'] = '<div class="alert alert-danger" role="alert">Username atau password salah</div>';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Admin Kedai Henna</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Font: DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,200;0,9..40,300;0,9..40,600;0,9..40,700;1,9..40,200;1,9..40,300&display=swap"
        rel="stylesheet">
    <!-- Google Font : Great Vibes -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
</head>


<body class="my-auto d-flex">
    <div class="container d-flex align-items-center">
        <div class="m-auto p-5 border bg-body-secondary rounded-5 shadows login">
            <form action="" method="POST">
                <h1 class="text-center mb-1 fw-normal brand-name">Kedai Henna</h1>
                <h4 class="text-center mb-3">Masuk Admin</h4>
                <?php
                if (isset($_SESSION['login-alert'])) {
                    echo $_SESSION['login-alert'];
                    unset($_SESSION['login-alert']);
                } ?>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                        name="password">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="button-submit w-100 my-3 py-2 fw-bold rounded-3" type="submit"
                        name="button">MASUK</button>
                </div>
                <p class="text-secondary text-center">&copy;Kedai Henna 2024</p>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script>
    </script>
</body>

</html>