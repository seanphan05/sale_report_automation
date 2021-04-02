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
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code`, `Begin Ticket` FROM `Scratcher Report`";
    } else {
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code`, `Begin Ticket` FROM `Scratcher Report Test`";
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
        <h1 style="text-align: center;">Scratchers - Quick Add</h1>
    <?php } else { ?> 
        <h1 style="text-align: center;">Scratchers - Quick Add Test Mode</h1>
    <?php } ?>
    <div style="text-align: center;">
        <button class="group_function" type="button" onclick="home();">Home Page</button>
        <input id="quickAdd" class="group_function" type="submit" value="Quick Add"/>
    </div>
    <div class="reminder-message" id="remind" style="text-align: center"> Reminder: Set End Ticket to -1 for empty slot(s) (N/A) & if one game gets error(s) others won't be updated!</div>
    <hr class="divide">
    <div id="nav-message" style="text-align: center"></div>
    <div id="quickadd_section" style="display: block">
        <div class="quickadd_list">
            <?php for($i= 0; $i<=10; $i++) {
                echo '<strong><label>'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</label></strong><br>
                    <label>End Ticket:</label><input id="'.$result[$i]['Game ID'].'" name="qaEnd" type="number" min="-1" value="'.$result[$i]['Begin Ticket'].'" style="width: 3em" />&nbsp;&nbsp;
                    <label>Activation Count:</label><input id="'.$result[$i]['Game ID'].'" name="qaActivation" type="number" min="0" value="0" style="width: 3em" />&nbsp;&nbsp;<br><br>';
            } ?>
        </div>
        <div class="quickadd_list">
            <?php for($i= 11; $i<=21; $i++) {
                 echo '<strong><label>'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</label></strong><br>
                    <label>End Ticket:</label><input id="'.$result[$i]['Game ID'].'" name="qaEnd" type="number" min="-1" value="'.$result[$i]['Begin Ticket'].'" style="width: 3em" />&nbsp;&nbsp;
                    <label>Activation Count:</label><input id="'.$result[$i]['Game ID'].'" name="qaActivation" type="number" min="0" value="0" style="width: 3em" />&nbsp;&nbsp;<br><br>';
            } ?>
        </div>
        <div class="quickadd_list">
            <?php for($i= 22; $i<=31; $i++) {
                 echo '<strong><label>'.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</label></strong><br>
                    <label>End Ticket:</label><input id="'.$result[$i]['Game ID'].'" name="qaEnd" type="number" min="-1" value="'.$result[$i]['Begin Ticket'].'" style="width: 3em" />&nbsp;&nbsp;
                    <label>Activation Count:</label><input id="'.$result[$i]['Game ID'].'" name="qaActivation" type="number" min="0" value="0" style="width: 3em" />&nbsp;&nbsp;<br><br>';
            } ?>
        </div>
    </div>
<?php }?>
<?php get_footer(); ?>



