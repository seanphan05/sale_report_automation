<?php 
require ('../../../../wp-load.php');
get_header();

try {
    $code = $_COOKIE["code"];
    if ($code === "vgs1495") {
        $tbName = 'Scratcher Report';
    } else {
        $tbName = 'Scratcher Report Test';
    }
    
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}