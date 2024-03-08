<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../../models/' . $class . '.php';
});

header('Content-Type: application/json; charset=utf-8');

$today = date('Y-m-d H:i:s');
// Initialize variables
$errors = [];
$success = false;

// print_r($_POST);
// exit();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate the input fields
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform validation for each field
    if (empty($username)) {
        $errors[] = "Please enter your username.";
    }

    if (empty($password)) {
        $errors[] = "Please enter your password.";
    }


    // If there are no errors, the form is successfully submitted
    if (empty($errors)) {

        
        if ($username == 'admin' && $password == 'admin') {
            $_SESSION['username'] = $username;
            $_SESSION['page'] = 'dashboard';
            $_SESSION['mode'] = 'orders';
            $_SESSION['selected_year'] = date("Y");
            $_SESSION['success'] = "Appointment has been added!";
            header('Location: ../index.php');
        }else{
            $_SESSION['errors'] = ['Incorect password or username'];
            header('Location: ../login.php');
        }
        
    }else{
        $_SESSION['errors'] = $errors;;
        header('Location: ../login.php');
    }


}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

