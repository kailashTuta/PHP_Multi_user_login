<?php
session_start();
include "DBConnect.php";
$msg = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = sha1($password);
    $userType = $_POST['userType'];

    $sql = "SELECT * FROM USERS WHERE username=? AND password=? AND user_type=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $password, $userType);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    session_regenerate_id();
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['user_type'];
    session_write_close();

    if ($result->num_rows == 1 && $_SESSION['role'] == "student") {
        header("location:student.php");
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "teacher") {
        header("location:teacher.php");
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "admin") {
        header("location:admin.php");
    } else {
        $msg = "Username or Password is incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi User Login System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-light mt-5 px-0">
                <h3 class="text-center text-light bg-danger p-3">Multi User Role Login System</h3>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="p-4">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="form-group lead">
                        <label for="userType">I'm a :</label>
                        <input type="radio" name="userType" value="student" class="custom-radio" required>&nbsp; Student |
                        <input type="radio" name="userType" value="Teacher" class="custom-radio" required>&nbsp; Teacher |
                        <input type="radio" name="userType" value="admin" class="custom-radio" required>&nbsp; admin
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-danger btn-block">
                    </div>
                    <h5 class="text-danger text-center"><?= $msg; ?></h5>
                </form>
            </div>
        </div>
    </div>
</body>

</html>