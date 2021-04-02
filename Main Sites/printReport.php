<?php 
require ('../../../../wp-load.php');
get_header();

try {
    // require "userCheck.php";
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT * FROM `Scratcher Report`, `Credentials` WHERE `Credentials`.`Validation Code` = ? GROUP BY `Game ID`";
    } else {
        $sql = "SELECT * FROM `Scratcher Report Test`, `Credentials` WHERE `Credentials`.`Validation Code` = ? GROUP BY `Game ID`";
    }

    $statement = $connection->prepare($sql);
    $statement->execute([$code]);
    $result = $statement->fetchAll();
}
    catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) {
    $grandTotal = 0;
    $clerkName = $result[0]["User Name"];
    $shiftInfo = $result[0]["Shift Info"]; 
    $dateInfo = new DateTime(null, new DateTimeZone('America/Los_Angeles')); ?>
    <table id="scratcher_report_table">
        <thead class="table_head">
        <tr class="report_head">
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Clerk Name: <?php echo $clerkName ?></th>
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Date: <?php echo $dateInfo->format("m/d/Y") ?></th>
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Shift: <?php echo $shiftInfo ?></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Game Name</th>
            <th>Pack Count</th>
            <th>Game Code</th>
            <th>Begin Ticket</th>
            <th>End Ticket</th>
            <th>No Ticket Sold</th>
            <th>Price Unit</th>
            <th>Total Sale</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) { ?>
            <tr style="height: 23px">
                <td style="text-align: center; width: 25px"><?php echo escape(substr($row["Game ID"], 4)); ?></td>
                <td style="text-align: center; width: 230px"><?php echo escape($row["Game Name"]); ?></td>
                <td style="text-align: center"><?php echo escape($row["Pack Ct."]); ?></td>
                <td style="text-align: center"><?php echo escape($row["Game Code"]); ?></td>
                <td style="text-align: center"><?php if(is_null($row['Begin Ticket'])) {echo "N/A";} else {echo sprintf("%02d", $row['Begin Ticket']);} ?></td>
                <td style="text-align: center"><?php if(is_null($row['End Ticket']) or ($row['End Ticket']==$row["Pack Ct."])) {echo "N/A";} else {echo sprintf("%02d", $row['End Ticket']);} ?></td>
                <td style="text-align: center"><?php if(empty($row["No Ticket Sold"])) {echo "";} else {echo $row["No Ticket Sold"];} ?></td>
                <td style="text-align: center"><?php echo escape($row["Price Unit"]); ?></td>
                <td style="text-align: center"><?php if(empty($row["Total Sale"])) {echo "";} else {echo $row["Total Sale"];} ?></td>
            </tr>

            <?php
            $grandTotal += $row["Total Sale"];
        } ?>
        <tr style="height: 23px">
            <td colspan="8" style="text-align: center; font-weight: bold">GRAND TOTAL</td>
            <td style="text-align: center; font-weight: bold"><?php echo $grandTotal; ?></td>
        </tr>
        </tbody>
    </table>
<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>
