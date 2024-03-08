<?php
include("./config.php");
include("./models/firebaseRDB.php");
date_default_timezone_set('Asia/Manila');
Class Order {
    private $firebaseApiKey = 'AIzaSyBABVyjXFYyEfHTPVsF-s06XpA8ZcuMKrs';
    private $firebaseProjectId = 'db-pharmacy';
    private $firebaseDatabaseUrl = 'https://db-pharmacy-default-rtdb.firebaseio.com/';

    // Firebase Realtime Database endpoint
    public $firebaseEndpoint = 'https://db-pharmacy-default-rtdb.firebaseio.com/orders';
    public $firebaseSecret = 'NBfTDSrOJOnu8MgRha89GXz6iRddiHe6kuuVgRkz';
    // Make the GET request
    public $response;
    // 
    // Check if the request was successful
    public function get_order(){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $data = $db->retrieve("orders");
        $data = json_decode($data,1);
        $toReturn = [];
        if($data != null){
            foreach ($data as $key => $value) {
                if($value['dateDelivered'] == '' && in_array($value['status'],['In Transit','Pending'])){
                    $value['id'] = $key;
                    $toReturn = array($key => $value) + $toReturn;
                }
            }
        }
        
        return $toReturn;
    }

    public function get_delivered(){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $data = $db->retrieve("orders");
        $data = json_decode($data,1);
        $toReturn = [];
        
        foreach ($data as $key => $value) {
            if($value['dateDelivered'] != ''){
                $value['id'] = $key;
                $toReturn = array($key => $value) + $toReturn;
            }
        }
        return $toReturn;
    }

    public function deliver_order($id){
        // return $id;
        $today = date('F j, Y');
        $updateData = [
            'dateDelivered' => $today,
            'status' => 'Delivered',
        ];
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        // NOTE: this one is for the updating of deliver_order
        $db->deliver_order($id,$updateData);
        $order = json_decode($db->retrieve('orders/'.$id));
        $product_list = json_decode($db->retrieve('product-list'));
        // $newProductList = [];
        // return print_r($product_list);
        $product = [];
        foreach ($product_list as $key => $value) {
            # code...
            $newProperty = $order->itemName;
            // return print_r([$key,$value,$order->itemName,isset($value->$newProperty)]);
            if(isset($value->$newProperty)){
                $product = $value->$newProperty;
                $product->product_category = $key;
            }
        }
        // return print_r($product);
        $newQuantity = intval($product->quantity) - intval($order->quantity);
        $productUpdate=[
            'quantity' => $newQuantity
        ];
        // print_r($productUpdate);

        $db->update("product-list",$product->product_category."/".$product->brandName,$productUpdate);
        return header('Location: index.php');
    }

    public function out_of_stock($id){
        $updateData = [
            'status' => 'Cancel',
        ];
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        // NOTE: this one is for the updating of deliver_order
        $db->deliver_order($id,$updateData);
        return header('Location: index.php');
    }

    public function in_transit($id){
        $updateData = [
            'status' => 'In Transit',
        ];
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        // NOTE: this one is for the updating of deliver_order
        $db->deliver_order($id,$updateData);
        return header('Location: index.php');
    }

    public function get_product(){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $data = $db->retrieve("product-list");
        $data = json_decode($data,1);
        $toCheckProduct = [];
        if($data != null){
            foreach ($data as $key => $value) {
                if($value != null){
                    foreach ($value as $key1 => $value1) {
                        $toCheckProduct[] = $value1;
                    }
                }
                
                
            }
        }
        
        return [$data,$toCheckProduct];
    }

    public function walkin_order($data){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        // $data = $db->retrieve("product-list");
        // $data = json_decode($data,1);
        // $toReturn = [];
        $product = json_decode($db->retrieve("product-list/".$data['product_category']."/".$data['product_name']));
        $newQuantity = intval($product->quantity) - intval($data['quantity']);
        $productUpdate=[
            'quantity' => $newQuantity
        ];
        $toInsert = [
            'amount' => intval($data['quantity']) * intval($product->price),
            'contactNumber' => "walkIn",
            'dateDelivered' => date('F j, Y'),
            'dateOrder' => date('F j, Y'),
            'deliveryMode' => "walkIn",
            'discount' => 0,
            'fullName' => "Walk In",
            'itemName' => $data['product_name'],
            'itemNumber' => 0,
            'paymentMode' => "walkIn",
            'prescription' => "Sample Prescription",
            'productId' => 0,
            'quantity' => $data['quantity'],
            'shipAddress' => "Walk In",
            'status' => "Delivered",
            'totalPay' => intval($data['quantity']) * intval($product->price),
            'unitPrice' => intval($product->price),

        ];
        $db->insert("orders",$toInsert);
        $db->update("product-list",$data['product_category']."/".$data['product_name'],$productUpdate);
        return $data;
    }

    // Decode the JSON response
}


?>