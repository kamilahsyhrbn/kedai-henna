<?php
include 'admin/backend/koneksi.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
function isUserLoggedIn()
{
    return isset($_SESSION['id_pelanggan']);
}
if (isUserLoggedIn()) {
    $result1 = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE id_pelanggan = '" . $_SESSION['id_pelanggan'] . "' AND status_pembelian IS NULL LIMIT 1");
    $order = $result1->fetch_assoc();

    if ($result1->num_rows > 0) {
        $result2 = mysqli_query($conn, "SELECT tb_detail_pembelian.*, tb_produk.* FROM tb_detail_pembelian
                                      JOIN tb_produk ON tb_produk.id_produk = tb_detail_pembelian.id_produk
                                       WHERE id_pembelian = '" . $order['id_pembelian'] . "'");

        $keranjang = mysqli_num_rows($result2);
    } else {
        $keranjang = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?> | Kedai Henna</title>
    <link rel="icon" href="admin/images/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="javascript/script.js"></script>
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

<body>
    <header data-bs-theme="light" id="main-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" data-bs-theme="light">
            <div class="container container-fluid mb-3 border-bottom">
                <a class="navbar-brand" href="index.php">
                    <div class="text-container ml-5">
                        <h2 class="brand-name fw-medium">Kedai Henna</h2>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2">
                        <li class="nav-item d-flex align-items-center">
                            <a <?php if ($page === 'beranda') { ?> class="nav-link active" <?php } else { ?>
                                    class="nav-link" <?php } ?>href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a <?php if ($page === 'belanja') { ?> class="nav-link active" <?php } else { ?>
                                    class="nav-link" <?php } ?> href="belanja.php">Belanja</a>
                        </li>
                        <?php if (isUserLoggedIn()): ?>
                            <li class="nav-icon d-flex align-items-center">
                                <a class="nav-link" href="keranjang.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                        <?php if ($page === 'keranjang') { ?> class="bi bi-cart-fill active" <?php } else { ?>
                                        class="bi bi-cart-fill" <?php } ?> viewBox="0 0 16 16">
                                        <path
                                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                        <span class="position-absolute translate-middle badge rounded-pill bg-danger">
                                            <?php echo $keranjang; ?>
                                        </span>
                                    </svg>
                                </a>
                            </li>
                            <div class="dropdown">
                                <li class="nav-icon d-flex align-items-center" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <a class="nav-link" href="akun-saya.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                            <?php if ($page === 'akun' || $page === 'pesanan' || $page === 'detail-akun') { ?>
                                                class="bi bi-person-circle active" <?php } else { ?> class="bi bi-person-circle"
                                            <?php } ?> viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path fill-rule="evenodd"
                                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                        </svg></a>
                                </li>
                                <ul class="dropdown-menu text-small shadow">
                                    <li>
                                        <a class="dropdown-item d-flex w-100 text-decoration-none align-items-center"
                                            href="akun-saya.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                            <span class="ms-2">Profil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex w-100 text-decoration-none align-items-center"
                                            href="keluar.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
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
                        <?php else: ?>
                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link" href="masuk.php">
                                    <button type="button" class="btn btn-dark">
                                        Masuk
                                    </button>
                                </a>

                            </li>
                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link" href="daftar.php">
                                    <button type="button" class="btn btn-dark">
                                        Daftar
                                    </button>
                                </a>

                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>