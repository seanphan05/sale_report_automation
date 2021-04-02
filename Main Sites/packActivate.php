<?php
require ('../../../../wp-load.php');
get_header();

if (isset($_POST['selectedGames']) && isset($_POST['action'])) {
    try { 
        // Activation
        if ($_POST['action'] === 'activate') {
            $games = implode("', '" , $_POST['selectedGames']);
            require "userCheck.php";
            if ($tbName === 'Scratcher Report') {
                $sql = "SELECT * FROM `Scratcher Report`
                WHERE `Current Ticket` <> `Pack Ct.` 
                AND `Current Ticket` IS NOT NULL
                AND `Game ID` IN ("."'".$games."'".")";
            } else {
                $sql = "SELECT * FROM `Scratcher Report Test`
                WHERE `Current Ticket` <> `Pack Ct.` 
                AND `Current Ticket` IS NOT NULL
                AND `Game ID` IN ("."'".$games."'".")";
            }
            
            $statement1 = $connection->prepare($sql);
            $statement1->execute();
            $result1 = $statement1->fetchAll();

            if ($tbName === 'Scratcher Report') {
                $sql = "UPDATE `Scratcher Report`
                SET `Current Ticket` = 0,
                `Begin Ticket` = COALESCE(`Begin Ticket`, 0),
                `End Ticket` = 0
                WHERE (`Current Ticket` = `Pack Ct.` OR `Current Ticket` IS NULL)
                AND `Game ID` IN ("."'".$games."'".")";
            } else {
                $sql = "UPDATE `Scratcher Report Test`
                SET `Current Ticket` = 0,
                `Begin Ticket` = COALESCE(`Begin Ticket`, 0),
                `End Ticket` = 0
                WHERE (`Current Ticket` = `Pack Ct.` OR `Current Ticket` IS NULL)
                AND `Game ID` IN ("."'".$games."'".")";
            }
            
            $statement = $connection->prepare($sql);
            $statement->execute();
        } 

        // Reverse Activation
        else {
            $games = implode("', '" , $_POST['selectedGames']);
            require "userCheck.php";
            if ($tbName === 'Scratcher Report') {
                $sql = "SELECT * FROM `Scratcher Report`
                WHERE (`Current Ticket` <> 0 OR `Current Ticket` IS NULL)
                AND `Game ID` IN ("."'".$games."'".")";
            } else {
                $sql = "SELECT * FROM `Scratcher Report Test`
                WHERE (`Current Ticket` <> 0 OR `Current Ticket` IS NULL)
                AND `Game ID` IN ("."'".$games."'".")";
            }
            
            $statement1 = $connection->prepare($sql);
            $statement1->execute();
            $result1 = $statement1->fetchAll();

            if ($tbName === 'Scratcher Report') {
                $sql = "UPDATE `Scratcher Report`
                SET `Current Ticket` = NULL,
                `Begin Ticket` = NULLIF(`Begin Ticket`, 0),
                `End Ticket` = NULL
                WHERE `Current Ticket` = 0
                AND `End Ticket` = 0
                AND `Game ID` IN ("."'".$games."'".")";
            } else {
                $sql = "UPDATE `Scratcher Report Test`
                SET `Current Ticket` = NULL,
                `Begin Ticket` = NULLIF(`Begin Ticket`, 0),
                `End Ticket` = NULL
                WHERE `Current Ticket` = 0
                AND `End Ticket` = 0
                AND `Game ID` IN ("."'".$games."'".")";
            }    
            $statement = $connection->prepare($sql);
            $statement->execute();
        }
        
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<?php if ($_POST['action'] === 'activate') {
    if (count($result1)==0 && count($_POST['selectedGames'])!=0) { ?>
        <div>
            <p>All selected Games have been activated! </p><br>
            <button class="group_function" type="button" onclick="refresh();">Activate/Reverse Other Games</button>
        </div>
    <?php } else if (count($_POST['selectedGames'])==0){ ?>
        <div>
            <p style="color: red">You have to select at lease 1 game to activate! </p><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        </div>
    <?php } else { ?>
        <div>
            <p><span style="color: red">Something went wrong!</span><br> Some game(s) cannot be activated. Please check again!</p><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        </div>
    <?php }
} else { 
    if (count($result1)==0 && count($_POST['selectedGames'])!=0) { ?>
        <div>
            <p>All selected Games have been reversed! </p><br>
            <button class="group_function" type="button" onclick="refresh();">Active/Reverse Other Games</button>
        </div>
    <?php } else if (count($_POST['selectedGames'])==0){ ?>
        <div>
            <p style="color: red">You have to select at lease 1 game to reverse! </p><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        </div>
    <?php } else { ?>
        <div>
            <p><span style="color: red">Something went wrong!</span><br> Some game(s) cannot be reversed. Please check again!</p><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        </div>
    <?php } 
} ?>