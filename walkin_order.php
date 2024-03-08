<?php
    
    spl_autoload_register(function ($class) {
        include './models/' . $class . '.php';
    });
    // echo 'wowow';
    // print_r($_POST);
    $instance = new Order;
    
    // echo $_POST['id'];


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize and validate the input fields
        $data = $_POST;
        // return $id;
        $instance->walkin_order($data);
        header('Location: index.php');
        // return $product;
    }
?>