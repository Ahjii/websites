<?php 
session_start();
if( !isset($_SESSION['token']) && !isset($_SESSION['username'])) {
    header('Location: login.php');
}else{
    $_SESSION['page'] = 'orders';
    header('Location: index.php');
    
}
?>