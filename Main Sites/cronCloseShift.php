<?php

require ('../../../../wp-load.php');
get_header();

try {
    require "../config/config.php";
    require "../config/common.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT `Validation Code` FROM `Credentials`
    WHERE `Shift Status` = 'ON'";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $passcode = $statement->fetchAll();

    if (!empty($passcode)) {
        foreach ($passcode as $val) {
            if ($val['Validation Code'] === "vgs1495") { 
                
                $sql = "UPDATE `Scratcher Report`
                SET `No Ticket Sold` = NULL,
                `Total Sale` = NULL,
                `Current Ticket` = IF(`Current Ticket` = `Pack Ct.`, NULL, `Current Ticket`),
                `End Ticket` = IF(`End Ticket` = `Pack Ct.`, NULL, `End Ticket`),
                `Begin Ticket` = `End Ticket`,
                `Activation Status` = 'N'
                WHERE `Begin Ticket` IS NOT NULL";

                $sql1 = "UPDATE `Sale Report`
                SET `Cigar Open` = `Cigar Close`, `Cigar Add` = NULL, `Cigar Close` = NULL, `Cigar Open Note` = NULL, `Cigar Add Note` = NULL, `Cigar Sold Note` = NULL, `Total Sales` = NULL, `Cash Start` = `Cash End`, 
                `Adjust Scratcher` = NULL, `Adjust Loto` = NULL, `Adjust Other` = NULL, `Memo` = NULL, `Scratcher` = NULL, `Loto` = NULL, `Reg` = NULL, `Cash End` = NULL, `Credit` = NULL, `Drop01` = NULL, `Drop02` = NULL, `Drop03` = NULL,                `Drop04` = NULL, `Drop05` = NULL, `Drop06` = NULL, `Drop07` = NULL, `Drop08` = NULL, `Drop09` = NULL, `Drop10` = NULL, `Drop11` = NULL, `Drop12` = NULL, `Drop13` = NULL, `Drop14` = NULL, `Drop15` = NULL, `Drop16` = NULL,                  `Drop17` = NULL, `Drop18` = NULL";

                $statement = $connection->prepare($sql);
                $statement->execute();

                $statement1 = $connection->prepare($sql1);
                $statement1->execute();

            } else {

                $sql = "UPDATE `Scratcher Report Test`
                SET `No Ticket Sold` = NULL,
                `Total Sale` = NULL,
                `Current Ticket` = IF(`Current Ticket` = `Pack Ct.`, NULL, `Current Ticket`),
                `End Ticket` = IF(`End Ticket` = `Pack Ct.`, NULL, `End Ticket`),
                `Begin Ticket` = `End Ticket`,
                `Activation Status` = 'N'
                WHERE `Begin Ticket` IS NOT NULL";

                $sql1 = "UPDATE `Sale Report Test`
                SET `Cigar Open` = `Cigar Close`, `Cigar Add` = NULL, `Cigar Close` = NULL, `Cigar Open Note` = NULL, `Cigar Add Note` = NULL, `Cigar Sold Note` = NULL, `Total Sales` = NULL, `Cash Start` = `Cash End`, 
                `Adjust Scratcher` = NULL, `Adjust Loto` = NULL, `Adjust Other` = NULL, `Memo` = NULL, `Scratcher` = NULL, `Loto` = NULL, `Reg` = NULL, `Cash End` = NULL, `Credit` = NULL, `Drop01` = NULL, `Drop02` = NULL, `Drop03` = NULL,                `Drop04` = NULL, `Drop05` = NULL, `Drop06` = NULL, `Drop07` = NULL, `Drop08` = NULL, `Drop09` = NULL, `Drop10` = NULL, `Drop11` = NULL, `Drop12` = NULL, `Drop13` = NULL, `Drop14` = NULL, `Drop15` = NULL, `Drop16` = NULL,                  `Drop17` = NULL, `Drop18` = NULL";

                $statement = $connection->prepare($sql);
                $statement->execute();

                $statement1 = $connection->prepare($sql1);
                $statement1->execute();
            }
        }

        $sql = "UPDATE Credentials
                SET `User Name` = NULL,
                `Shift Info` = NULL,
                `Shift Status` = 'OFF'";

        $statement1 = $connection->prepare($sql);
        $statement1->execute();
    }
      
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>