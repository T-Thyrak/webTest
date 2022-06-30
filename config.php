<?php
    $server="localhost";
    $username="root";
    $password="loco0117";
    $database="form";
    $conn= mysqli_connect($server,$username,$password,$database);

    if(!$conn){
        echo "<script> alert('Connection Failed!') </script>";
    }
?>