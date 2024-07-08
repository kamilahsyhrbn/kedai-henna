<?php
session_start();
unset($_SESSION['status_login_user']);
unset($_SESSION['id_pelanggan']);
header("Location: index.php");
exit();
?>