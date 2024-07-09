<?php
session_start();
include 'config/koneksi.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


if ($_SESSION['status_login_admin'] != true) {
    $_SESSION['login-alert'] = '<div class="alert alert-danger" role="alert">Anda harus masuk terlebih dahulu!</div>';
    echo "<script>window.location='masuk.php'</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?> | Admin Kedai Henna</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
</head>

<body class="overflow-x-hidden m-0">
    <div class="navigation position-fixed h-100 overflow-hidden top-0 left-0">
        <ul class="mt-4 position-absolute top-0 left-0 w-100 px-3">
            <li class="mb-3 pe-none">
                <a href="dashboard.php" class="position-relative d-flex text-decoration-none align-items-center">
                    <h3 class="brand-name text-white ps-4 fs-2">Kedai Henna</h3>
                </a>
                <hr class="text-white border-2" />
            </li>


            <li <?php if ($page === 'dashboard') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="dashboard.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-house-fill" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                        <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z" />
                    </svg>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>

            <li <?php if ($page === 'admin') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="data-admin.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    </svg>
                    <span class="ms-2">Data Admin</span>
                </a>
            </li>

            <li <?php if ($page === 'produk') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="produk.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-basket3-fill" viewBox="0 0 16 16">
                        <path
                            d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.468 15.426.943 9h14.114l-1.525 6.426a.75.75 0 0 1-.729.574H3.197a.75.75 0 0 1-.73-.574z" />
                    </svg>
                    <span class="ms-2">Produk</span>
                </a>
            </li>

            <li <?php if ($page === 'pesanan') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="pesanan.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-box2-heart-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4zM8.5 4h6l.5.667V5H1v-.333L1.5 4h6V1h1zM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                    </svg>
                    <span class="ms-2">Pesanan</span>
                </a>
            </li>

            <li <?php if ($page === 'pelanggan') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="pelanggan.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    </svg>
                    <span class="ms-2">Pelanggan</span>
                </a>
            </li>
            <li <?php if ($page === 'laporan') { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 fw-semibold mb-2 active" <?php } else { ?>
                    class="position-relative w-100 rounded-2 p-2 fs-5 mb-2" <?php } ?>>
                <a href="laporan.php"
                    class="position-relative d-flex w-100 text-decoration-none align-items-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-archive-fill" viewBox="0 0 16 16">
                        <path
                            d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z" />
                    </svg>
                    <span class="ms-2">Laporan</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main position-absolute">
        <div class="topbar d-flex justify-content-between align-items-center w-100 pt-2">
            <div class="toggle position-relative d-flex justify-content-center align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </div>
            <div class="dropdown">
                <a href="#"
                    class="d-flex align-items-center justify-content-center link-body-emphasis text-decoration-none dropdown-toggle me-2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <li><a class="dropdown-item d-flex w-100 text-decoration-none align-items-center" href="profil.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                            <span class="ms-2">Profil</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex w-100 text-decoration-none align-items-center" href="keluar.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                            <span class="ms-2">
                                Keluar
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            let list = document.querySelectorAll(".navigation li");

            document.addEventListener("DOMContentLoaded", function () {
                let toggle = document.querySelector(".toggle");
                let navigation = document.querySelector(".navigation");
                let main = document.querySelector(".main");

                toggle.onclick = function () {
                    navigation.classList.toggle("active");
                    main.classList.toggle("active");
                };
            });
        </script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</body>

</html>