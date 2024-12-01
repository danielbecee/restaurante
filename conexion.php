<?php

$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbbasedatos = "db_restaurante";

try {
    $con = new mysqli($dbserver, $dbusername, $dbpassword, $dbbasedatos);

   
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
