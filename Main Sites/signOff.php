<?php
require ('../../../../wp-load.php');
get_header();

try {
    $code = $_COOKIE['code'];
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "UPDATE `Credentials`
    SET `User Name` = NULL,
    `Shift Info` = NULL,
    `Shift Status` = 'OFF'
    WHERE `Validation Code` = ?";

    $statement = $connection->prepare($sql);
    $statement->execute([$code]);

    // destroy session
    session_start();
    session_destroy();
    $_SESSION = array();

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}