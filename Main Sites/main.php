<?php
require ('../../../../wp-load.php');
get_header(); 
session_start();
if($_SESSION['status']!="Active") {
    header("location: https://lotteryreport.ga");
}
require "userCheck.php";
?>

<body>
<main id="main-holder">
<?php if ($tbName === 'Scratcher Report') { ?>
    <h1 style="text-align: center;">Scratchers - Report System</h1>
<?php } else { ?> 
    <h1 style="text-align: center;">Scratchers - Report System Test Mode</h1>
<?php } ?>

<div id="main-ribbon">
    <input class="group_function" id="submit" type="submit" value="Submit"/>
    <button class="group_function" id="toggle" type="button" onclick="showInfo();">Show Current</button>
    <button class="group_function" type="button" onclick="current();">Update Game Info</button>
    <button class="group_function" type="button" onclick="activate();">Activation/Reverse</button>
    <button class="group_function" type="button" onclick="returnTicket();">Return Ticket</button>
    <button class="group_function" type="button" onclick="quickAdd();">Quick Add</button>
    <button class="group_function" type="button" onclick="template();">Get Templates</button>
    <button class="group_function" type="button" onclick="saleReport();">Gas Sale Report</button>
    <button class="group_function" type="button" onclick="closeShift();">Scratchers Report/Close Shift</button>
</div>
<hr class="divide">
<div id="quickModeInfo" class="sticky" style="display:none;"></div>
<div id="total_add_message" style="display:none;">
    <strong>Total Sale for This Transaction is: <span style="color: red">$<a id="total_add_price">0</a></span></strong>
</div>
<div id="add_sale_message" class="notification" style="display:none;"></div>

<?php try {
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code`, `Price Unit`, `Current Ticket` FROM `Scratcher Report`";
    } else {
        $sql = "SELECT `Game ID`, `Game Name`, `Game Code`, `Price Unit`, `Current Ticket` FROM `Scratcher Report Test`";
    }
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
}
catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) { ?>
<div id="firstCol">
    <?php for($i= 0; $i<=15; $i++) { ?>
        <div class="game_column"> 
            <?php echo '<img style="float: right; margin: 0px 15px 15px 0px;" src="../image/'.$result[$i]['Game ID'].'.jpg" width="100" />' ?>
            <p><strong class="title">Game <?php echo substr(escape($result[$i]['Game ID']), 4); ?> - <?php echo $result[$i]['Game Name']; ?> - <?php echo $result[$i]['Game Code']; ?> - $<span id="price_<?php echo $result[$i]['Game ID']; ?>"><?php echo $result[$i]['Price Unit']; ?></span>&nbsp;<span id="current_<?php echo $result[$i]['Game ID']; ?>" style="display:none;"><?php echo $result[$i]['Current Ticket']; ?></span></strong></p>
            <p id="add_message_<?php echo $result[$i]['Game ID']; ?>" class="tab" style="display:none;">Added <a class="temp" id="add_<?php echo $result[$i]['Game ID']; ?>">0</a> ticket(s) - Total: <a class="temp" id="add_price_<?php echo $result[$i]['Game ID']; ?>">0</a> - Next Current: <a class="temp" id="next_current_<?php echo $result[$i]['Game ID']; ?>">0</a></p>
            <form style="display:inline-block;">
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 1);">Add 1</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 2);">Add 2</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 3);">Add 3</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 4);">Add 4</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 5);">Add 5</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 10);">Add 10</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="resetCount(this);">Reset</button>
            </form>
        </div>
    <hr>
    <?php } ?>
</div>

<div id="secondCol">
    <?php for($i= 16; $i<=31; $i++) { ?>
        <div class="game_column"> 
            <?php echo '<img style="float: right; margin: 0px 15px 15px 0px;" src="../image/'.$result[$i]['Game ID'].'.jpg" width="100" />' ?>
            <p><strong class="title">Game <?php echo substr(escape($result[$i]['Game ID']), 4); ?> - <?php echo $result[$i]['Game Name']; ?> - <?php echo $result[$i]['Game Code']; ?> - $<span id="price_<?php echo $result[$i]['Game ID']; ?>"><?php echo $result[$i]['Price Unit']; ?></span>&nbsp;<span id="current_<?php echo $result[$i]['Game ID']; ?>" style="display:none;"><?php echo $result[$i]['Current Ticket']; ?></span></strong></p>
            <p id="add_message_<?php echo $result[$i]['Game ID']; ?>" class="tab" style="display:none;">Added <a class="temp" id="add_<?php echo $result[$i]['Game ID']; ?>">0</a> ticket(s) - Total: <a class="temp" id="add_price_<?php echo $result[$i]['Game ID']; ?>">0</a> - Next Current: <a class="temp" id="next_current_<?php echo $result[$i]['Game ID']; ?>">0</a></p>
            <form style="display:inline-block;">
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 1);">Add 1</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 2);">Add 2</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 3);">Add 3</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 4);">Add 4</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 5);">Add 5</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="addFunction(this, 10);">Add 10</button>
                <button class="<?php echo $result[$i]['Game ID']; ?>" type="button" onclick="resetCount(this);">Reset</button>
            </form>
        </div>
        <hr>
    <?php } ?>
</div>
<?php } ?>
<?php get_footer(); ?>
