<?php
require ('../../../../wp-load.php');
get_header();
if (isset($_POST)) {
    try {
        require "userCheck.php";
        
        if ($tbName === 'Scratcher Report') {
            $sql = "UPDATE `Sale Report`
            SET `Cigar Open` = ?, `Cigar Add` = ?, `Cigar Close` = ?, `Cigar Open Note` = ?, `Cigar Add Note` = ?, `Cigar Sold Note` = ?, `Total Sales` = ?, `Cash Start` = ?, `Adjust Scratcher` = ?,
                `Adjust Loto` = ?, `Adjust Other` = ?, `Memo` = ?, `Scratcher` = ?, `Loto` = ?, `Reg` = ?, `Cash End` = ?, `Credit` = ?, `Drop01` = ?, `Drop02` = ?, `Drop03` = ?, `Drop04` = ?,
                `Drop05` = ?, `Drop06` = ?, `Drop07` = ?, `Drop08` = ?, `Drop09` = ?, `Drop10` = ?, `Drop11` = ?, `Drop12` = ?, `Drop13` = ?, `Drop14` = ?, `Drop15` = ?, `Drop16` = ?, `Drop17` = ?, `Drop18` = ?";
        } else {
            $sql = "UPDATE `Sale Report Test`
            SET `Cigar Open` = ?, `Cigar Add` = ?, `Cigar Close` = ?, `Cigar Open Note` = ?, `Cigar Add Note` = ?, `Cigar Sold Note` = ?, `Total Sales` = ?, `Cash Start` = ?, `Adjust Scratcher` = ?,
                `Adjust Loto` = ?, `Adjust Other` = ?, `Memo` = ?, `Scratcher` = ?, `Loto` = ?, `Reg` = ?, `Cash End` = ?, `Credit` = ?, `Drop01` = ?, `Drop02` = ?, `Drop03` = ?, `Drop04` = ?,
                `Drop05` = ?, `Drop06` = ?, `Drop07` = ?, `Drop08` = ?, `Drop09` = ?, `Drop10` = ?, `Drop11` = ?, `Drop12` = ?, `Drop13` = ?, `Drop14` = ?, `Drop15` = ?, `Drop16` = ?, `Drop17` = ?, `Drop18` = ?";
        }
        
        $statement = $connection->prepare($sql);
        $statement->execute([$_POST["cigar_open"], $_POST["cigar_add"], $_POST["cigar_close"], $_POST["open_note"], $_POST["add_note"], $_POST["sold_note"], $_POST["sales"], $_POST["start"], $_POST["ad_scratcher"], $_POST["ad_loto"],                                   $_POST["ad_other"], $_POST["memo"], $_POST["scratcher"], $_POST["loto"], $_POST["reg"], $_POST["end"], $_POST["credit"], $_POST["drop"][0], $_POST["drop"][1], $_POST["drop"][2], $_POST["drop"][3], 
                                $_POST["drop"][4], $_POST["drop"][5], $_POST["drop"][6], $_POST["drop"][7], $_POST["drop"][8], $_POST["drop"][9], $_POST["drop"][10], $_POST["drop"][11], $_POST["drop"][12], $_POST["drop"][13], 
                                $_POST["drop"][14], $_POST["drop"][15], $_POST["drop"][16], $_POST["drop"][17]]);

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    } 
} ?>
