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
        $id = $_POST["id"];
        $status = $_POST["status"];
        // return $id;
        if($status == "delivered"){
            $order = $instance->deliver_order($id);
        }else if($status == "intransit"){
            $order = $instance->in_transit($id);
        }else if($status == "outofstock"){
            $order = $instance->out_of_stock($id);
        }
        
        return $order;
    }
?>