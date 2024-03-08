<?php 
session_start();
if( !isset($_SESSION['token']) && !isset($_SESSION['username'])) {
    header('Location: login.php');
}else{
    $_SESSION['page'] = 'product';
    header('Location: index.php');
}
?>