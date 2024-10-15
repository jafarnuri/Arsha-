<?php
session_start();

if (isset($_POST['admin_register'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Cookie-də məlumatları saxla
        setcookie('email', $email, time() + (86400 * 10), "/"); // 10 gün müddətinə
        setcookie('password', $password, time() + (86400 * 10), "/");
        header("location:../profil/login.php");

    }
}


if (isset($_POST['admin_login'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login_email = $_POST['email'];
        $login_password = $_POST['password'];

        if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
            if (($_COOKIE['email'] === $login_email) && ($_COOKIE['password'] === $login_password)) {
                $_SESSION['email'] = $login_email;
                header("Location: ../admin/admin.php");
            } else {
                echo "istifadeci adi yanlisdi";
            }
        } else {
            echo "Istifadeci tapilmadi";
        }


    }
}


if (isset($_POST['admin_logout'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        session_destroy();
        header("location:../profil/login.php");

    }
}
