<?php
    $connect = mysqli_connect("localhost", "root", "root", "project_m");

    if(!$connect) {
        die('Error connecting to SQL Server');
    }
//    phpinfo();
?>