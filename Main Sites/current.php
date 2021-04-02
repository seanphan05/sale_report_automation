<?php
require ('../../../../wp-load.php');
get_header(); 
session_start();


if($_SESSION['status']!="Active") {
    header("location: https://lotteryreport.ga");
} ?>

<body>
<main id="main-holder">
<?php require "userCheck.php";
    if ($tbName === 'Scratcher Report') { ?>
        <h1 style="text-align: center;">Scratchers - Update Game Info</h1>
    <?php } else { ?> 
        <h1 style="text-align: center;">Scratchers - Update Game Info Test Mode</h1>
    <?php } ?>
<form style="text-align: center;">
    <button class="group_function" type="button" onclick="home();">Home Page</button>
    <input id="updateGame" class="group_function" type="submit" value="Update" style="display:none">
</form>
<hr class="divide">
<div id="updateInfo">
    <div id="updateMessage" style="display: none; text-align: center; color: darkgreen;"></div>
    <?php include "updateGame.php"; ?>
</div>
<?php get_footer(); ?>
