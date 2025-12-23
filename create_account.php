<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = $_POST["first_name"];
    $last = $_POST["last_name"];
    $email = $_POST["email"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $phone = $_POST["phone"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $address = $_POST["address"];

    $stmt = $conn->prepare("INSERT INTO users 
        (first_name, last_name, email, password, phone, country, city, address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", $first, $last, $email, $pass, $phone, $country, $city, $address);

    if ($stmt->execute()) {
        $_SESSION["user"] = $email;
        header("Location: index.php");
        exit;
    } else {
        $error = "Email already exists!";
    }
}
?>
