<?php

$connection = new mysqli(
    "localhost",
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
