<?php
spl_autoload_register(function ($class) {
    include './models/' . $class . '.php';
});
// Replace these values with your Firebase project credentials
$firebaseApiKey = 'AIzaSyBABVyjXFYyEfHTPVsF-s06XpA8ZcuMKrs';
$firebaseProjectId = 'db-pharmacy';
$firebaseDatabaseUrl = 'https://db-pharmacy-default-rtdb.firebaseio.com/';

// Firebase Realtime Database endpoint
$firebaseEndpoint = $firebaseDatabaseUrl . 'product-list/health-care.json';

// Make the GET request
function tryal($firebaseEndpoint){
    $response = file_get_contents($firebaseEndpoint);
    // echo $response;
    // Check if the request was successful
    if ($response === FALSE) {
        die('Error fetching data from Firebase.');
    }

    // Decode the JSON response
    $data = json_decode($response, TRUE);

    // Output the data
    print_r($data);
}

function modelo(){
    $instance = new Order;
    $order = $instance->get_order();
    // echo $order;
    echo '<pre>';
    print_r($order);
    echo '</pre>';
}

modelo();

?>