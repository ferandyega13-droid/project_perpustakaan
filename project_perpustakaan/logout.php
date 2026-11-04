<?php
session_start();
session_destroy();
if (isset($_COOKIE['perpus_user'])) {
    setcookie('perpus_user', '', time() - 3600, "/");
    setcookie('perpus_role', '', time() - 3600, "/");
}
header("Location: index.php");
?>