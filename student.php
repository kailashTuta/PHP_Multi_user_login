<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != "student") {
    header("Location:index.php");
}
?>
<h1>Hello: <?= $_SESSION['username'] ?></h1>
<h2>you are a: <?= $_SESSION['role'] ?></h2>
<a href="logout.php">Logout</a>