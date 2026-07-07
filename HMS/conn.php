<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "izwn_hotel"
);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

?>