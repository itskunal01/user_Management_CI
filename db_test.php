<?php

$connection = new mysqli(
    "127.0.0.1",
    "root",
    "",
    "user_management_db",
    6666
);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

echo "PHP database connection successful!";

$connection->close();

?>