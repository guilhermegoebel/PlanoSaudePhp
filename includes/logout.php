<?php
session_start();

session_unset();
session_destroy();

header("Location: ../pages/client_list.php");
exit;
?>