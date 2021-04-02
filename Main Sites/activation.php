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
        <h1 style="text-align: center;">Scratchers - Activation</h1>
    <?php } else { ?> 
        <h1 style="text-align: center;">Scratchers - Activation Test Mode</h1>
    <?php } ?>
    <div style="text-align: center;">
        <button class="group_function" type="button" onclick="home();">Home Page</button>
        <input id="activatePack" class="group_function" type="submit" value="Activate"/>
        <input id="reverseActivation" class="group_function" type="submit" value="Reverse Activation"/>
    </div>
    <hr class="divide">
    <div id="nav-message" style="text-align: center"></div>
    <div id="activation_section" style="display: block">
        <div class="checkbox_list">
            <?php for($i= 0; $i<=10; $i++) {
                echo '<strong><label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" />'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label></strong><br><br>';
            } ?>
        </div>
        <div class="checkbox_list">
            <?php for($i= 11; $i<=21; $i++) {
                echo '<strong><label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" />'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label></strong><br><br>';
            } ?>
        </div>
        <div class="checkbox_list">
            <?php for($i= 22; $i<=31; $i++) {
                echo '<strong><label><input type="checkbox" name="checkboxlist" value="'.$result[$i]['Game ID'].'" />'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'<label></strong><br><br>';
            } ?>
        </div>
    </div>
<?php }?>
<?php get_footer(); ?>



