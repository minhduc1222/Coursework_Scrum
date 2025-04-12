<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'coursework_scrum';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $output = 'Connection failed: ' . $e->getMessage();
}

if (isset($output)) {
    echo $output;
}
?>