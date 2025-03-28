<?php
if (session_status() === PHP_SESSION_NONE) {

    session_start();
    ini_set('session.gc_maxlifetime', 1800); // Session hết hạn sau 30 phút
    session_set_cookie_params(1800);
}

include("../php/connect.php");
?>