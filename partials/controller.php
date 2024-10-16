<?php
session_start();

//Qeydiyyat

if (isset($_POST['admin_register'])) {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Emailin mövcudluğunu yoxla
        $file = '../File/user.csv';
        $emailExists = false;

        // CSV faylını oxu
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[0] === $email) {
                    $emailExists = true; // Email artıq mövcuddur
                    break;
                }
            }
            fclose($handle);
        }

        if ($emailExists) {
            echo "Bu email ilə artıq qeydiyyatdan keçmisiniz!";
        } else {
            // Cookie-dən istifadəçi məlumatlarını al
            if (isset($_COOKIE['users'])) {
                $users = json_decode($_COOKIE['users'], true); // Cookie-dən istifadəçi məlumatlarını al
            } else {
                $users = []; // Cookie mövcud deyilsə, boş array yarad
            }

            // Yeni istifadəçi məlumatlarını array-ə əlavə et
            $users[] = ['name' => $name, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)];

            // Cookie-yə yeni istifadəçi məlumatlarını yaz
            setcookie('users', json_encode($users), time() + (86400 * 30), "/"); // 30 gün

            // CSV faylını açırıq (append rejimində)
            $fileHandle = fopen($file, 'a');


            if ($fileHandle) {
                // İstifadəçi məlumatlarını CSV formatında yazırıq
                fputcsv($fileHandle, [$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
                fclose($fileHandle);
            }
            header("Location:../profil/login.php");
            exit();
        }
    }
}

//Girish


if (isset($_POST['admin_login'])) {
    if (isset($_SESSION['email'])) {
        header("Location: ../admin/admin.php");
        exit();

    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Formdan daxil edilən məlumatları al
            $email = $_POST['email'];
            $password = $_POST['password'];

            // CSV faylını açırıq
            $file = '../File/user.csv';
            $found = false;

            if (($handle = fopen($file, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $storedEmail = $data[0];
                    $storedPassword = $data[1];

                    // Email yoxla
                    if ($email === $storedEmail) {
                        // Şifrəni yoxla
                        if (password_verify($password, $storedPassword)) {
                            $found = true;
                            break;
                        }
                    }
                }
                fclose($handle);
            }

            if ($found) {
                $_SESSION['email'] = $email;
                header("Location: ../admin/admin.php");
                exit();

            } else {
                echo "Belə bir istifadəçi yoxdur.";
            }
        }
    }
}

//Chixish
if (isset($_POST['admin_logout'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        session_destroy();
        header("location:../profil/login.php");
        exit();

    }
}
