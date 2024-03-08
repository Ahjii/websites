<?php 
session_start();
if( !isset($_SESSION['token']) && !isset($_SESSION['username'])) {
    header('Location: login.php');
}else{
    // $_SESSION['page'] = 'product';
    $mode = $_POST['mode'];
    if($mode == 'delivered'){
        $_SESSION['mode'] = 'delivered';
    }else if($mode == 'orders'){
        $_SESSION['mode'] = 'orders';
    }
    $_SESSION['selected_year'] = $_POST['year'];
    header('Location: index.php');
}
?>