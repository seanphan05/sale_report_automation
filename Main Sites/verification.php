<?php 
require ('../../../../wp-load.php');
get_header();

if (isset($_POST['clerkName']) && isset($_POST['shiftInfo']) && isset($_POST['code'])) {
    session_start();
    $_SESSION['status']="Active";
    try {
        require "../config/config.php";
        require "../config/common.php";
        $clerkName = $_POST['clerkName'];
        $shiftInfo = $_POST['shiftInfo'];
        $code = $_POST['code'];

        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "UPDATE `Credentials`
        SET `User Name` = ?,
        `Shift Info` = ?,
        `Shift Status` = 'ON'
        WHERE `Validation Code` = ?";

        $statement = $connection->prepare($sql);
        $statement->execute([$clerkName, $shiftInfo, $code]);
        
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

