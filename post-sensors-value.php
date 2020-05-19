<?php
// Setup variables 
$host = "localhost"; // Setup the server location
$dbname = "wstation"; // Setup the database name 
$username = "wstation"; // Setup the username to access to the database
$password = "strongpassword"; // Setup the password to access to the database
$api_key_value = "c81cc6f99e2ad2de51f38d79eee21ee04b406ed218c01ea7ec0b2a1f5fa259af"; // Setup the API key to verify the authenticity of the request

// Setup the blank variables
$api_key= "";
$temperature = "";
$feeling = "";
$humidity = "";
$pressure = "";
$quality = ""; 

// Main script
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request is a posting request 
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) { // check if the API is the right one
        $temperature = test_input($_POST["temperature"]); 
        $feeling = test_input($_POST["feeling"]);
        $humidity = test_input($_POST["humidity"]);
        $pressure = test_input($_POST["pressure"]);
        $quality = test_input($_POST["quality"]);
        

        $conn = new mysqli($host, $username, $password, $dbname); // Connect the script to database
        if ($conn->connect_error) { // Check the database connection
            die("Connection failed: " . $conn->connect_error); // Send "Connection failed" If there is an error
        } 
        
        $sql = "INSERT INTO SensorData (temperature, feeling, humidity, pressure, quality) 
        VALUES ('" . $temperature . "', '" . $feeling . "', '" . $humidity . "', '" . $pressure . "', '" . $quality . "')"; // Sending temperature, feeling, humidity, pressure and air quality
        
        if ($conn->query($sql) === TRUE) { // Check if the request to the DB successfull or not
            echo "Recorded successfully"; // Send "recorded successfully" if they are no problem
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error; // Send "error" if they are an error
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
