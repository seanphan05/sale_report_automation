<?php
require ('../../../../wp-load.php');
get_header();

if (isset($_POST)) {
    try {
        require "userCheck.php";

        $error_count = 0;
        foreach($_POST['json'] as $game) {
            $id = $game['id'];
            $val = $game['val'];
            $ac = $game['ac'];

            if(!is_null($val) && $val != '') {
                $connection = new PDO($dsn, $username, $password, $options);
                if ($tbName === 'Scratcher Report') {
                    $sql = "SELECT * FROM (SELECT `Game ID`, `Begin Ticket`, `Current Ticket`, `Pack Ct.` FROM `Scratcher Report`
                    WHERE `Game ID` = ?) AS temp
                    WHERE temp.`Pack Ct.` <= ?
                    OR -1 > ?
                    OR (temp.`Begin Ticket` IS NULL AND ? = 0 AND ? IS NOT NULL)
                    OR (temp.`Begin Ticket` > ? AND ? = 0 AND ? != -1)";
                } else {
                    $sql = "SELECT * FROM (SELECT `Game ID`, `Begin Ticket`, `Current Ticket`, `Pack Ct.` FROM `Scratcher Report Test`
                    WHERE `Game ID` = ?) AS temp
                    WHERE temp.`Pack Ct.` <= ?
                    OR -1 > ?
                    OR (temp.`Begin Ticket` IS NULL AND ? = 0 AND ? IS NOT NULL)
                    OR (temp.`Begin Ticket` > ? AND ? = 0 AND ? != -1)";
                }
                $statement2 = $connection->prepare($sql);
                $statement2->execute([$id, $val, $val, $ac, $val, $val, $ac, $val]);
                $result2 = $statement2->fetchAll();

                if (count($result2) != 0) {
                    $error_count += 1;
                }
            }
        }

        if ($error_count == 0) {
            foreach($_POST['json'] as $game) {
                $id = $game['id'];
                $val = $game['val'];
                $ac = $game['ac'];

                if(!is_null($val) && $val != '') {
                    // Update Begin Ticket when activation detected at start of the shift
                    if ($tbName === 'Scratcher Report') {
                        $sql = "UPDATE `Scratcher Report`
                        SET `Begin Ticket` = 0,
                        `Activation Status` = 'Y'
                        WHERE ? > 0
                        AND `Game ID` = ?
                        AND `Begin Ticket` IS NULL";
                    } else {
                        $sql = "UPDATE `Scratcher Report Test`
                        SET `Begin Ticket` = 0,
                        `Activation Status` = 'Y'
                        WHERE ? > 0
                        AND `Game ID` = ?
                        AND `Begin Ticket` IS NULL";
                    }
                        $statement1 = $connection->prepare($sql);
                        $statement1->execute([$ac, $id]);

                    // Quick Add execution
                    if ($tbName === 'Scratcher Report') {
                        $sql = "UPDATE `Scratcher Report`
                        SET `No Ticket Sold` = IF(? = -1, IF(`Activation Status` = 'Y', ? * `Pack Ct.` - `Begin Ticket`, (? + 1) * `Pack Ct.` - `Begin Ticket`), IF(`Activation Status` = 'Y', ? + (? - 1) * `Pack Ct.` - `Begin Ticket`, ? + ? * `Pack Ct.` - `Begin Ticket`)),
                        `End Ticket` = IF (? = -1, `Pack Ct.`, ?),
                        `Current Ticket` = IF (? = -1, `Pack Ct.`, ?),
                        `Total Sale` = IF(? = -1, IF(`Activation Status` = 'Y', (? * `Pack Ct.` - `Begin Ticket`) * `Price Unit`, ((? + 1) * `Pack Ct.` - `Begin Ticket`) * `Price Unit`),  IF( `Activation Status` = 'Y', (? + (? - 1) * `Pack Ct.` - `Begin Ticket`) * `Price Unit`, (? + ? * `Pack Ct.` - `Begin Ticket`) * `Price Unit`)),
                        `Activation Status` = 'N'
                        WHERE `Game ID` = ?
                        AND `Pack Ct.` > ?
                        AND -1 <= ?
                        AND `Begin Ticket` IS NOT NULL
                        AND NOT (`Begin Ticket` > ? AND ? != -1 AND ? = 0)";
                    } else {
                        $sql = "UPDATE `Scratcher Report Test`
                        SET `No Ticket Sold` = IF(? = -1, IF(`Activation Status` = 'Y', ? * `Pack Ct.` - `Begin Ticket`, (? + 1) * `Pack Ct.` - `Begin Ticket`), IF(`Activation Status` = 'Y', ? + (? - 1) * `Pack Ct.` - `Begin Ticket`, ? + ? * `Pack Ct.` - `Begin Ticket`)),
                        `End Ticket` = IF (? = -1, `Pack Ct.`, ?),
                        `Current Ticket` = IF (? = -1, `Pack Ct.`, ?),
                        `Total Sale` = IF(? = -1, IF(`Activation Status` = 'Y', (? * `Pack Ct.` - `Begin Ticket`) * `Price Unit`, ((? + 1) * `Pack Ct.` - `Begin Ticket`) * `Price Unit`),  IF( `Activation Status` = 'Y', (? + (? - 1) * `Pack Ct.` - `Begin Ticket`) * `Price Unit`, (? + ? * `Pack Ct.` - `Begin Ticket`) * `Price Unit`)),
                        `Activation Status` = 'N'
                        WHERE `Game ID` = ?
                        AND `Pack Ct.` > ?
                        AND -1 <= ?
                        AND `Begin Ticket` IS NOT NULL
                        AND NOT (`Begin Ticket` > ? AND ? != -1 AND ? = 0)";
                    }
                    
                    $statement = $connection->prepare($sql);
                    $statement->execute([$val, $ac, $ac, $val, $ac, $val, $ac, $val, $val, $val, $val, $val, $ac, $ac, $val, $ac, $val, $ac, $id, $val, $val, $val, $val, $ac]);
                }
            }
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// message section
if ($error_count == 0) { ?>
    <div><strong>Quick add has been executed! Double check with your report!</strong></div>
<?php }
else { ?>
    <div><strong><span style="color: red">An error has been found! Quick add wont be executed. Possible problems may include:</span><br>
    <div style="display: inline-block; text-align: left; color: red;">
        1. You are adding ticket(s) to an empty Game<br>
        2. You are adding (an) inappropriate number(s).</div>
        </strong></div>
<?php } ?>
