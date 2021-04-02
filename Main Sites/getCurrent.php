<?php
require ('../../../../wp-load.php');
get_header();
require "userCheck.php";

try {
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT `Game ID`, `Pack Ct.`, `Current Ticket` FROM `Scratcher Report`";
    } else {
        $sql = "SELECT `Game ID`, `Pack Ct.`, `Current Ticket` FROM `Scratcher Report Test`";
    }
    
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    }

catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) { ?>
    <h3 style="text-align: center;">Current Game Information</h3>
    <table id="game_info">
        <tr>
            <th  class= "head" style="text-align: center">Game</th>
            <?php foreach ($result as $row) { ?>
            <td style="text-align: center"><?php echo substr(escape($row["Game ID"]), 4); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <th class= "head" style="text-align: center">Cur.</th>
            <?php foreach ($result as $row) { ?>
            <td style="text-align: center; font-weight: bold">
                <?php if(is_null($row['Current Ticket']) or $row['Current Ticket']==$row["Pack Ct."]) {echo "";} else {echo sprintf("%02d", $row['Current Ticket']);} ?>
            </td>
            <?php } ?>
        </tr>
        <tr>
            <th class= "head" style="text-align: center">Ct.</th>
            <?php foreach ($result as $row) { ?>
            <td style="text-align: center; font-weight: bold"><?php echo $row["Pack Ct."]?></td>
            <?php } ?>
        </tr>
    </table>
<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>

