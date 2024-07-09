<?php
$title = 'Akun Saya | Detail Akun';
$page = 'detail-akun';
include_once "navbar.php";

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $pelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");

    $data = mysqli_fetch_object($pelanggan);
}


if (isset($_POST['button-submit'])) {
    $nama_pelanggan = ucwords($_POST['nama_pelanggan']);
    $telepon_pelanggan = $_POST['telepon_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];
    $email_pelanggan = $_POST['email_pelanggan'];
    $password = $_POST['password_pelanggan'];
    $confirmPassword = $_POST['confirm-password'];

    if (!empty($password)) {
        if ($password != $confirmPassword) {
            echo '<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password yang Anda masukkan tidak cocok. Perubahan tidak disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div></div>';
            return false;
        } else {
            $sql = "UPDATE tb_pelanggan SET
            nama_pelanggan = '$nama_pelanggan',
            telepon_pelanggan = '$telepon_pelanggan',
            alamat_pelanggan = '$alamat_pelanggan',
            email_pelanggan = '$email_pelanggan',
            password_pelanggan ='$password'";
        }
    } else {
        $sql = "UPDATE tb_pelanggan SET
            nama_pelanggan = '$nama_pelanggan',
            telepon_pelanggan = '$telepon_pelanggan',
            alamat_pelanggan = '$alamat_pelanggan',
            email_pelanggan = '$email_pelanggan'";
    }


    $sql .= " WHERE id_pelanggan = " . $data->id_pelanggan;

    if (mysqli_query($conn, $sql)) {
        echo '<script>window.location="detail-akun.php"</script>';
        $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil merubah data!
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>';
        exit();
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Gagal merubah data!
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>';
    }
}
?>

<body>
    <div class="container container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-1 text-center">
                <h2 class="my-4"> Detail Akun</h2>
            </div>
            <?php if (isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            } ?>
            <div class="col-lg-12">
                <?php include 'menu-akun.php' ?>
                <div class="container-fluid mt-4">
                    <div class="content-menu">
                        <form method="POST">
                            <div class="d-flex row">
                                <div class="col-lg-6">
                                    <h5><b>Ubah Data Diri</b></h5>
                                    <div class="input-container mx-0">
                                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" required
                                            autocomplete="name" value="<?php echo $data->nama_pelanggan ?>">
                                        <label for=" nama_pelanggan" class="label">Nama</label>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-container mx-0">
                                        <input type="text" id="telepon_pelanggan" name="telepon_pelanggan" required
                                            value="<?php echo $data->telepon_pelanggan ?>" autocomplete="phone">
                                        <label for="telepon_pelanggan" class="label">No. HP</label>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-container mx-0">
                                        <input type="text" id="alamat_pelanggan" name="alamat_pelanggan" required
                                            value="<?php echo $data->alamat_pelanggan ?>">
                                        <label for="alamat_pelanggan" class="label">Alamat</label>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-container mx-0">
                                        <input type="email" id="email_pelanggan" name="email_pelanggan" required
                                            value="<?php echo $data->email_pelanggan ?>" autocomplete="email">
                                        <label for="email_pelanggan" class="label">Email</label>
                                        <div class="underline"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5><b>Ubah Password</b></h5>
                                    <div class="input-container mx-0">
                                        <input type="password" id="password_pelanggan" name="password_pelanggan">
                                        <label for="password_pelanggan" class="label w-full">
                                            Kata Sandi Baru
                                            <p class="d-none d-md-inline"> (biarkan kosong jika tidak ada
                                                perubahan)</p>
                                        </label>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-container mx-0">
                                        <input type="password" id="confirm-password" name="confirm-password">
                                        <label for="confirm-password" class="label">Konfirmasi Password Baru</label>
                                        <div class="underline"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex justify-content-center">
                                <button class="button-submit fw-bold" type="submit" name="button-submit">SIMPAN
                                    PERUBAHAN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>