<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'testDB';

$id = $_POST['id'];

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Remove by id 
$sql = "DELETE FROM question WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data removed successfully.";
} else {
    echo "Error removing data: " . $conn->error;
}

$conn->close();
?>
