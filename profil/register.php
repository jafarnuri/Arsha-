<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container">
    <link rel="stylesheet" href="../assets/css/main.css">
    <form action="" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <button type="submit" class="btn btn-primary"> <a class="color_a" href="./login.php">Login</a> </button>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cookie-də məlumatları saxla
    setcookie('email', $email, time() + (86400 * 10), "/"); // 10 gün müddətinə
    setcookie('password', $password, time() + (86400 * 10), "/");

    header("Location: ./login.php"); // Yönləndirmə
    exit();
}
?>