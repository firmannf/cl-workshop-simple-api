<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "cl_mahasiswa";
    
    $connection = mysqli_connect($host, $username, $password);
    $connectionDatabase = mysqli_select_db($connection, $database);
?>