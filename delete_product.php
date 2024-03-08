<?php
    
    spl_autoload_register(function ($class) {
        include './models/' . $class . '.php';
    });
    // echo 'wowow';
    // print_r($_POST);
    $instance = new Product;
    
    // echo $_POST['id'];


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize and validate the input fields
        $id = $_POST;
        // return $id;
        $instance->delete_product($id);
        // return $order;
        header('Location: index.php');
    }
?>