<?php
session_start();
unset($_SESSION['id_admin']);
unset($_SESSION['status_login_admin']);
header("Location: index.php");
exit();
?>