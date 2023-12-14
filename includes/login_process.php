<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "admin" && $password === "admin") {

        $_SESSION["user_logged_in"] = true;
        header("Location: ../pages/client_list.php");
        exit;
    } else {
        header("Location: ../pages/login.php?a=1");
        exit;
    }
}
?>