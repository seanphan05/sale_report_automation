<?php
require ('../../../../wp-load.php');
get_header(); 
require "userCheck.php";

if ($_POST['action'] == 'get') {
    $gameId = $_POST['gameID'];
    try {
        if ($tbName === 'Scratcher Report') {
            $sql = "SELECT `Game Name`, `Pack Ct.`, `Game Code`, `Begin Ticket`, `Current Ticket`, `End Ticket`, `Price Unit` FROM `Scratcher Report` 
            WHERE `Game ID` = ?";
        } else {
            $sql = "SELECT `Game Name`, `Pack Ct.`, `Game Code`, `Begin Ticket`, `Current Ticket`, `End Ticket`, `Price Unit` FROM `Scratcher Report Test` 
            WHERE `Game ID` = ?";
        }
    
        $statement = $connection->prepare($sql);
        $statement->execute([$gameId]);
        $result = $statement->fetchAll();
    }
    catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} elseif ($_POST['action'] == "update") {
    $gameId = $_POST['gameID'];
    $newName = !empty($_POST['newName']) ? $_POST['newName'] : NULL;
    $newCount = !empty($_POST['newCount']) ? $_POST['newCount'] : NULL;
    $newCode = !empty($_POST['newCode']) ? $_POST['newCode'] : NULL;
    $newBegin = (!empty($_POST['newBegin']) ||  $_POST['newBegin'] === '0') ? $_POST['newBegin'] : NULL;
    $newCurrent = (!empty($_POST['newCurrent']) ||  $_POST['newCurrent'] === '0') ? $_POST['newCurrent'] : NULL;
    $newEnd = (!empty($_POST['newEnd']) ||  $_POST['newEnd'] === '0') ? $_POST['newEnd'] : NULL;
    $newPrice = !empty($_POST['newPrice']) ? $_POST['newPrice'] : NULL;

    if ($gameId === 'title') {
        $result = 'error';
    } else {
        try {
            if ($tbName === 'Scratcher Report') {
                $sql = "UPDATE `Scratcher Report`
                SET `Game Name`= COALESCE(?, `Game Name`), `Pack Ct.`= COALESCE(?, `Pack Ct.`), `Game Code`= COALESCE(?, `Game Code`), 
                `Begin Ticket` = IF(?=-1, NULL, COALESCE(?, `Begin Ticket`)), `Current Ticket` = IF(?=-1, NULL, COALESCE(?, `Current Ticket`)), 
                `End Ticket` = IF(?=-1, NULL, COALESCE(?, `End Ticket`)), `Price Unit`= COALESCE(?, `Price Unit`)
                WHERE `Game ID` = ?
                AND  (? IS NOT NULL AND NOT (? <=> `Game Name`) OR
                    ? IS NOT NULL AND NOT (? <=> `Pack Ct.`) OR
                    ? IS NOT NULL AND NOT (? <=> `Game Code`) OR
                    ? IS NOT NULL AND NOT (? <=> `Begin Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `Current Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `End Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `Price Unit`))";
            } else {
                $sql = "UPDATE `Scratcher Report Test`
                SET `Game Name`= COALESCE(?, `Game Name`), `Pack Ct.`= COALESCE(?, `Pack Ct.`), `Game Code`= COALESCE(?, `Game Code`), 
                `Begin Ticket` = IF(?=-1, NULL, COALESCE(?, `Begin Ticket`)), `Current Ticket` = IF(?=-1, NULL, COALESCE(?, `Current Ticket`)), 
                `End Ticket` = IF(?=-1, NULL, COALESCE(?, `End Ticket`)), `Price Unit`= COALESCE(?, `Price Unit`)
                WHERE `Game ID` = ?
                AND  (? IS NOT NULL AND NOT (? <=> `Game Name`) OR
                    ? IS NOT NULL AND NOT (? <=> `Pack Ct.`) OR
                    ? IS NOT NULL AND NOT (? <=> `Game Code`) OR
                    ? IS NOT NULL AND NOT (? <=> `Begin Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `Current Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `End Ticket`) OR
                    ? IS NOT NULL AND NOT (? <=> `Price Unit`))";
            }
            $statement = $connection->prepare($sql);
            $statement->execute([$newName, $newCount, $newCode, $newBegin, $newBegin, $newCurrent, $newCurrent, $newEnd, $newEnd, $newPrice, $gameId, 
                                $newName, $newName, $newCount, $newCount, $newCode, $newCode, $newBegin, $newBegin, $newCurrent, $newCurrent, $newEnd, $newEnd, $newPrice, $newPrice]);

            }
        catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    } 
}  else {
    echo ("No result found!");
}

if ($_POST['action'] == 'get') { ?>
<div style="display: inline-block; text-align: left;">
    <h3>Current Game Info</h3>
    <hr class="divide">
    <p style="padding: 1.5px;"><strong>Game Name: <span style="color: darkgreen;"><?php echo $result[0]['Game Name'] ?></span></strong></p>
    <p style="padding: 1.5px;"><strong>Pack Count: <span style="color: darkgreen;"><?php echo $result[0]['Pack Ct.'] ?></span></strong></p>
    <p style="padding: 1.5px;"><strong>Game Code: <span style="color: darkgreen;"><?php echo $result[0]['Game Code'] ?></span></strong></p>
    <p style="padding: 1.5px;"><strong>Begin Ticket: <span style="color: darkgreen;">
        <?php if(is_null($result[0]['Begin Ticket'])) {echo "NULL";} else {echo sprintf("%02d", $result[0]['Begin Ticket']);} ?>
    </span></strong></p>
    <p style="padding: 1.5px;"><strong>Current Ticket: <span style="color: darkgreen;">
        <?php if(is_null($result[0]['Current Ticket']) or ($result[0]['Current Ticket']==$result[0]["Pack Ct."])) {echo "NULL";} else {echo sprintf("%02d", $result[0]['Current Ticket']);} ?>
    </span></strong></p>
    <p style="padding: 1.5px;"><strong>End Ticket: <span style="color: darkgreen;">
        <?php if(is_null($result[0]['End Ticket']) or ($result[0]['End Ticket']==$result[0]["Pack Ct."])) {echo "NULL";} else {echo sprintf("%02d", $result[0]['End Ticket']);} ?>
    </span></strong></p>
    <p style="padding: 1.5px;"><strong>Price Unit: <span style="color: darkgreen;"><?php echo $result[0]['Price Unit'] ?></span></strong></p>
</div>
<?php } elseif ($_POST['action'] == 'update') { 
    if ($result === 'error') { ?>
        <p style="color: red;">Something went wrong! You have to select at least one game to update!</p>
        <button class="group_function" type="button" onclick="refresh();">Try Again</button>
    <?php } else { ?>
        <p>The selected Game's Info has been update!</p>
        <button class="group_function" type="button" onclick="refresh();">Update Another Game</button>
    <?php }
} else {
    echo ("No result found!");
}
get_footer(); ?>