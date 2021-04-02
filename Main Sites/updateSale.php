<?php
require ('../../../../wp-load.php');
get_header();

if (isset($_POST)) {
    try {
        require "userCheck.php";
        
        // Return sale tickets
        if (isset($_POST['action'])) {
            $gameId = $_POST['gameID'];
            $num = $_POST['noReturn'];

            if ($tbName === 'Scratcher Report') {
                $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `No Ticket Sold` FROM `Scratcher Report` 
                WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
                OR `No Ticket Sold` IS NULL
                OR temp.`No Ticket Sold` < ?
                OR temp.`Current Ticket` < ?";
            } else {
                $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `No Ticket Sold` FROM `Scratcher Report Test`
                WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
                OR `No Ticket Sold` IS NULL
                OR temp.`No Ticket Sold` < ?
                OR temp.`Current Ticket` < ?";
            }
            $statement1 = $connection->prepare($sql);
            $statement1->execute([$gameId, $num, $num]);
            $result1 = $statement1->fetchAll();

            if ($tbName === 'Scratcher Report') {
                $sql = "UPDATE `Scratcher Report` 
                SET `No Ticket Sold` = `No Ticket Sold` - ?,
                `End Ticket` = `Current Ticket` - ?,
                `Current Ticket` = `Current Ticket` - ?,
                `Total Sale` = `Total Sale` - (? * `Price Unit`)
                WHERE `Game ID` = ?
                AND `No Ticket Sold` >= ?
                AND `Current Ticket` >= ?
                AND `Current Ticket` IS NOT NULL
                AND `No Ticket Sold` IS NOT NULL";
            } else {
                $sql = "UPDATE `Scratcher Report Test` 
                SET `No Ticket Sold` = `No Ticket Sold` - ?,
                `End Ticket` = `Current Ticket` - ?,
                `Current Ticket` = `Current Ticket` - ?,
                `Total Sale` = `Total Sale` - (? * `Price Unit`)
                WHERE `Game ID` = ?
                AND `No Ticket Sold` >= ?
                AND `Current Ticket` >= ?
                AND `Current Ticket` IS NOT NULL
                AND `No Ticket Sold` IS NOT NULL";
            }
            $statement = $connection->prepare($sql);
            $statement->execute([$num, $num, $num, $num, $gameId, $num, $num]);
        
        // Add sale tickets
        } else {
            if (isset($_POST['error'])) {
                $result2 = 'blank_submit';
            } else {
                $error_count = 0;
                foreach ($_POST as $key => &$val) {
                    $connection = new PDO($dsn, $username, $password, $options);
                    if ($tbName === 'Scratcher Report') {
                        $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `Pack Ct.` FROM `Scratcher Report`
                        WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
                        OR temp.`Pack Ct.` - temp.`Current Ticket` < ?";
                    } else {
                        $sql = "SELECT * FROM (SELECT `Game ID`, `Current Ticket`, `Pack Ct.` FROM `Scratcher Report Test`
                        WHERE `Game ID` = ?) AS temp WHERE temp.`Current Ticket` IS NULL
                        OR temp.`Pack Ct.` - temp.`Current Ticket` < ?";
                    }

                    $statement2 = $connection->prepare($sql);
                    $statement2->execute([$key, $val]);
                    $result2 = $statement2->fetchAll();

                    if (count($result2) != 0) {
                        $error_count += 1;
                    }
                }

                if ($error_count == 0) {
                    foreach ($_POST as $key => &$val) {
                        if ($tbName === 'Scratcher Report') {
                            $sql = "UPDATE `Scratcher Report`
                            SET `No Ticket Sold` = COALESCE(`No Ticket Sold`,0) + ?,
                            `End Ticket` = `Current Ticket` + ?,
                            `Current Ticket` = `Current Ticket` + ?,
                            `Total Sale` = COALESCE(`Total Sale`,0) + (? * `Price Unit`)
                            WHERE `Game ID` = ?
                            AND `Pack Ct.` - `Current Ticket` >= ?
                            AND `Current Ticket` IS NOT NULL";
                        } else {
                            $sql = "UPDATE `Scratcher Report Test`
                            SET `No Ticket Sold` = COALESCE(`No Ticket Sold`,0) + ?,
                            `End Ticket` = `Current Ticket` + ?,
                            `Current Ticket` = `Current Ticket` + ?,
                            `Total Sale` = COALESCE(`Total Sale`,0) + (? * `Price Unit`)
                            WHERE `Game ID` = ?
                            AND `Pack Ct.` - `Current Ticket` >= ?
                            AND `Current Ticket` IS NOT NULL";
                        }

                        $statement = $connection->prepare($sql);
                        $statement->execute([$val, $val, $val, $val, $key, $val]);
                    }
                }     
            }
                
        }    
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// return section
if (isset($_POST['action'])) {
    if (count($result1)==0) {
        if ($_POST['gameID']==="title") { ?>
            <div style="color: red"><strong>Something went wrong! You have to select a Game to return ticket(s)!</strong><br><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        <?php } else if (empty($_POST['noReturn'])) { ?>
            <div style="color: red"><strong>Something went wrong! Number of return ticket(s) cannot empty!</strong><br><br>
            <button class="group_function" type="button" onclick="refresh();">Try Again</button>
        <?php } else { ?>
            <div><strong>You have returned <?php echo $_POST['noReturn'] ?> ticket(s) of Game <?php echo substr($_POST['gameID'],-2) ?></strong></div>
        <?php }
     } else { ?>
        <div><strong><span style="color: red">Something went wrong! Possible problems may include:</span><br>
        <div style="display: inline-block; text-align: left; color: red">
            1. You are returning ticket(s) from an empty Game<br>
            2. You are returning more than the number of ticket(s) allowed<br>
            3. You are returning ticket(s) of a wrong Game.</div>
            </strong></div><br>
        <button class="group_function" type="button" onclick="refresh();">Try Again</button>
    <?php }
}

// add section
else {
    if ($error_count === 0) { ?>
        <div><strong>Sale ticket(s) have been updated!</strong></div>
    <?php }
    else { 
        if ($result2 === 'blank_submit') { ?>
            <div><strong><span style="color: red">No sale ticket(s) have been update! Please check again! </span><br> 
        <?php } else { ?>
            <div><strong><span style="color: red">Something went wrong! Possible problems may include:</span><br>
            <div style="display: inline-block; text-align: left; color: red;">
                1. You are adding ticket(s) to an empty Game<br>
                2. You are adding more than the number of ticket(s) allowed.</div>
                </strong></div>
        <?php } 
    }
} ?>

