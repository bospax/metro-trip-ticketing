<?php
session_start();
if (isset($_SESSION['user_fm'])) {
    unset($_SESSION['user_fm']);
    header('location: login.php');
}
?>