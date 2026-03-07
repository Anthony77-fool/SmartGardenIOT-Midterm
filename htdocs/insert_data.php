<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_garden_db"; // Use your actual Laravel DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the ESP8266
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    // Extract values from the JSON sent by ESP8266
    $temp = $data['temp'];
    $humid = $data['humid'];
    $raw = $data['soil_raw'];
    $percent = $data['soil_percent'];

    // Updated SQL to match your actual column names: temp, humidity, soil_raw, soil_percent
    // We also include created_at and updated_at because Laravel tables usually expect both
    $sql = "INSERT INTO plant_readings (temp, humidity, soil_raw, soil_percent, created_at, updated_at) 
            VALUES ('$temp', '$humid', '$raw', '$percent', NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully";
    } else {
        // This will help you debug in the Serial Monitor if it fails
        echo "SQL Error: " . $conn->error;
    }
}
$conn->close();
?>