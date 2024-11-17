<?php
// db_connection.php
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password (usually empty for XAMPP)
$dbname = "transactions"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
