<?php
require ('../../../../wp-load.php');
get_header();

try {
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
    <div id="updateSection" style="text-align: center">
        <h3 style="text-align: center;">Game Information</h3>
        <select id="updateList">
            <option selected="selected" value="title">-------------- Please Select A Game --------------</option>
            <?php for($i= 0; $i<=31; $i++) {
                echo '<option value="'.$result[$i]['Game ID'].'">Game '.substr(escape($result[$i]['Game ID']), 4).' - '.$result[$i]['Game Name'].' - '.$result[$i]['Game Code'].'</option>';
            } ?>
        </select><br><br>
        <div id="infoSection" style="display: none;">
            <div id="currentGameInfo" style="text-align: center;"></div>
            <div id="newGameInfo" style="text-align: center;">
                <div style="display: inline-block; text-align: left;">
                    <h3>New Game Info</h3>
                    <hr class="divide">
                    <p><strong>Game Name:</strong>
                    <input id="newName" type="text" name="newName" placeholder="Text"></p>
                    <p><strong>Pack Count:</strong>
                    <input id="newCount" type="number" placeholder="Number"></p>
                    <p><strong>Game Code:</strong>
                    <input id="newCode" type="number" placeholder="Number"></p>
                    <p><strong>Begin Ticket:</strong>
                    <input id="newBegin" type="number" placeholder="-1 For NULL"></p>
                    <p><strong>Current Ticket:</strong>
                    <input id="newCurrent" type="number" placeholder="-1 For NULL"></p>
                    <p><strong>End Ticket:</strong>
                    <input id="newEnd" type="number" placeholder="-1 For NULL"></p>
   
                    <p><strong>Price Unit:</strong>
                    <select id="newPrice">
                    <option selected="selected" value="30">30</option>
                    <option value="20">20</option>
                    <option value="10">10</option>
                    <option value="5">5</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                    </select></p>

                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>