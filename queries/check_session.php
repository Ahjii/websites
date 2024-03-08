<?php
session_start();
if($_SESSION['username'] != 'admin'){
    header('Location: ./link/login.php');
}
