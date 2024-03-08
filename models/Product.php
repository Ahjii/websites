<?php
include("./config.php");
include("./models/firebaseRDB.php");
date_default_timezone_set('Asia/Manila');
Class Product {
    private $firebaseApiKey = 'AIzaSyBABVyjXFYyEfHTPVsF-s06XpA8ZcuMKrs';
    private $firebaseProjectId = 'db-pharmacy';
    private $firebaseDatabaseUrl = 'https://db-pharmacy-default-rtdb.firebaseio.com/';

    // Firebase Realtime Database endpoint
    public $firebaseEndpoint = 'https://db-pharmacy-default-rtdb.firebaseio.com/orders.json';

    // Make the GET request
    public $response;
    // 
    // Check if the request was successful
    public function get_product(){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $data = $db->retrieve("product-list");
        $data = json_decode($data,1);
        $toReturn = [];
        return $data;
    }

    public function insert_product($data){
        // return $data;
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $path = "product-list/".$data['product_category']."/".$data['product_name'];
        $existing = json_decode($db->retrieve($path));
        // $data = $db->update($data['product_category'],$data['product_name'],$newData);
        // echo '<pre>';
        // print_r($existing);
        // echo '</pre>';
        if(!isset($existing)){
            $toInsertStock = [
                'brandName' => $data['product_name'],
                'product_category' => $data['product_category'],
                'price' => intval($data['original_price']),
                'quantity' => intval($data['quantity']),
                'total' => intval($data['original_price']) * intval($data['quantity']),
                'dateDelivered' => date('F j, Y')
            ];
            $toInsert = [
                $data['product_name'] => [
                    'brandName' => $data['product_name'],
                    'description' => $data['description'],
                    'imageUrl' => $data['imageUrl'],
                    'price' => intval($data['price']),
                    'quantity' => intval($data['quantity'])
                ]
            ];
            if($data['product_category'] === "health-care"){
                $toInsert[$data['product_name']]['genericName'] = $data['genericName'];
            }
            $db->update("product-list/",$data['product_category'],$toInsert);
            $db->insert("stock-in",$toInsertStock);
        }
    }

    public function insert_existing_product($data){

        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $path = "product-list/".$data['product_category']."/".$data['product_name'];
        $existing = json_decode($db->retrieve($path));
        // $data = $db->update($data['product_category'],$data['product_name'],$newData);
        echo '<pre>';
        print_r($existing);
        echo '</pre>';
        $newQuantity = intval($existing->quantity) + intval($data['quantity']);
        $toUpdate = [
            'quantity'=> $newQuantity,
            'price'=> intval($data['price'])
        ];
        
        // $thisTime =  date('YmdHis');
        $toInsert = [
            'brandName' => $data['product_name'],
            'product_category' => $data['product_category'],
            'price' => intval($data['original_price']),
            'quantity' => intval($data['quantity']),
            'total' => intval($data['original_price']) * intval($data['quantity']),
            'dateDelivered' => date('F j, Y')
        ];
        $db->update("product-list",$data['product_category']."/".$data['product_name'],$toUpdate);
        $db->insert("stock-in",$toInsert);
        // $path = $data['']
        // return $data;
    }

    public function delete_product($data){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $path = "product-list/".$data['product_category']."/".$data['product_name'];
        $existing = json_decode($db->retrieve($path));

        if(isset($existing)){

            $db->delete("product-list",$data['product_category']."/".$data['product_name']);
        }
    }
    
    // Decode the JSON response
}


?>