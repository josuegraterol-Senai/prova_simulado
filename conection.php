<?php
$host="localhost";
$user="root";
$password="";
$database="saep_db";

$con = mysqli_connect($host,$user, $password, $database);

if(!$con){
    die("Falha na conexao: " . mysqli_connect_error());
}


