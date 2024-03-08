<?php 
session_start();
if( !isset($_SESSION['token']) && !isset($_SESSION['username'])) {
    header('Location: login.php');
}else{
    if($_SESSION['page'] == 'dashboard'){
        include('admin/dashboard.php');
    }else if($_SESSION['page'] == 'sales'){
        include('cre.php');
    }else if($_SESSION['page'] == 'orders'){
        include('admin/order.php');
    }else if($_SESSION['page'] == 'product'){
        include('admin/product.php');
    }
    
}
?>