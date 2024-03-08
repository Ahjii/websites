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
        $data = $_POST;
        // return $id;
        $instance->insert_existing_product($data);
        header('Location: index.php');
        // return $product;
    }
?>