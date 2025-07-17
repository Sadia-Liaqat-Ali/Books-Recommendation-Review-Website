
<?php

$host     = 'localhost';
$user     = 'root';         // your DB username
$password = '';             // your DB password
$dbname   = 'booksrecommendation_db';   // your database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
