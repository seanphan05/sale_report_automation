<?php
require ('../../../../wp-load.php');
get_header(); 

session_start();
if($_SESSION['status']!="Active") {
    header("location: https://lotteryreport.ga");
}
?>
<?php try {
    require "userCheck.php";
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code` FROM `Scratcher Report`";
    } else {
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code` FROM `Scratcher Report Test`";
    }
    
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
}
catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
if ($result && $statement->rowCount() > 0) { ?>
<body>
<main id="main-holder">
<?php if ($tbName === 'Scratcher Report') { ?>
        <h1 style="text-align: center;">Scratchers - Return</h1>
    <?php } else { ?> 
        <h1 style="text-align: center;">Scratchers - Return Test Mode</h1>
    <?php } ?>
<div style="text-align: center;">
    <button class="group_function" type="button" onclick="home();">Home Page</button>
    <button style="display:none" id="returnAnotherTicket" class="group_function" type="button" onclick="refresh();">Return Another Game</button>
    <input id="returnTicket" class="group_function" type="submit" value="Return"/>
</div>
<hr class="divide">
<div id="returnMessage" style="text-align: center"></div><br>
<div id="returnSection" style="text-align: center">
    <select id="returnList">
        <option selected="selected" value="title">-------------- Please Select A Game --------------</option>
        <?php for($i= 0; $i<=31; $i++) {
            echo '<option value="'.$result[$i]['Game ID'].'">Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</option>';
        } ?>
    </select><br><br>
    <div id="returnNo">
        <label><strong>How many ticket do you want to return?</strong></label>
        <input id="returnTicketNum" type="number" placeholder="0" min="0"/>
    </div>
</div>
<?php }?>
<?php get_footer(); ?>