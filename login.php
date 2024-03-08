<?php
session_start();
if( isset($_SESSION['token']) || isset($_SESSION['username'])) {
    header('Location: index.php');
}else{
    include('link/login.php');
}

?>