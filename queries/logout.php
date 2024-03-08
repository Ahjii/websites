<?php

session_start();

$_SESSION['success'] = "";
unset($_SESSION['token']);
unset($_SESSION['username']);
header('Location: ../index.php');