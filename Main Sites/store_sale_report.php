<?php 
require ('../../../../wp-load.php');
get_header();

try {
    require "userCheck.php";
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT * FROM `Scratcher Report`, `Credentials` WHERE `Credentials`.`Validation Code` = ? GROUP BY `Game ID`";
        $sql1 = "SELECT * FROM `Sale Report`";
    } else {
        $sql = "SELECT * FROM `Scratcher Report Test`, `Credentials` WHERE `Credentials`.`Validation Code` = ? GROUP BY `Game ID`";
        $sql1 = "SELECT * FROM `Sale Report Test`";
    }

    $statement = $connection->prepare($sql);
    $statement->execute([$code]);
    $result = $statement->fetchAll();

    $statement1 = $connection->prepare($sql1);
    $statement1->execute();
    $result1 = $statement1->fetchAll();
}
    catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
} ?>

<body id="sale_report_page">
<main id="main-holder">

<?php if ($result && $statement->rowCount() > 0) {
    $clerkName = $result[0]["User Name"];
    $shiftInfo = $result[0]["Shift Info"];
    $dateInfo = new DateTime(null, new DateTimeZone('America/Los_Angeles')); ?>

<?php if ($tbName === 'Scratcher Report') { ?>
    <h1 style="text-align: center;">Store Sale Report</h1>
<?php } else { ?> 
    <h1 style="text-align: center;">Store Sale Report Test Mode</h1>
<?php } ?>

<div id="main-ribbon">
    <button class="group_function" id="home_button" type="button" onclick="home();">Home Page</button>
    <button class="group_function" id="generation" type="button">Generate</button>
    <button class="group_function" id="pin" type="button">Pin</button>
    <button id="sale_print" class="group_function" type="button" onclick="window.print();" disabled>Print</button>
</div>
<hr class="divide" style="width: 90%">
<div id="missing_error" style="display: none">Please fill in all required fields</div>
<div id="pin_message" style="display: none; font-weight: bold">Store Sale Information has been recorded!</div>

<div id="sale_content" style="width: 90%">
    <div id="gas_header" style="font-weight: bold; font-size: 18px;">
        <div style="padding: 5px;">Clerk Name: <?php echo $clerkName ?></div>
        <div style="padding: 5px;">Date: <?php echo $dateInfo->format("m/d/Y") ?></div>
        <div style="padding: 5px;">Shift: <?php echo $shiftInfo ?></div>
    </div>
    <br><br>
    <div id="gas_table1">
        <table class="shift_sale" id="cigar_table" style="width: 100%">
            <col width="30%"><col width="10%"><col width="15%"><col width="45%">
            <tr>
                <td rowspan="5" style="text-align: center; font-weight: bold; width: 200px">Cigars</td>
                <td style="text-align: center; font-weight: bold">Open</td>
                <td ><input id="cigar_open" type="number" onchange="setInt(this)" <?php echo 'value="'.$result1[0]['Cigar Open'].'"' ?> required></td>
                <td ><input id="open_note" type="text" <?php echo 'value="'.$result1[0]['Cigar Open Note'].'"' ?>></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Add</td>
                <td ><input id="cigar_add" type="number" onchange="setInt(this)" <?php echo 'value="'.$result1[0]['Cigar Add'].'"' ?>></td>
                <td ><input id="add_note" type="text" <?php echo 'value="'.$result1[0]['Cigar Add Note'].'"' ?>></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Total</td>
                <td id="cigar_total" style="padding: 0 10px;"></td>
                <td ><input type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Close</td>
                <td ><input id="cigar_close" type="number" onchange="setInt(this)" <?php echo 'value="'.$result1[0]['Cigar Close'].'"' ?>required></td>
                <td ><input type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Sold</td>
                <td id="cigar_sold" style="padding: 0 10px;"></td>
                <td ><input id="sold_note" type="text" <?php echo 'value="'.$result1[0]['Cigar Sold Note'].'"' ?>></td>
            </tr>
        </table>
    </div>
    <br>

    <div id="gas_table2">
        <table class="shift_sale" id="sale_table" style="width: 100%">
            <col width="20%"><col width="30%"><col width="20%"><col width="30%">
            <tr>
                <td style="text-align: center; font-weight: bold">Sales</td>
                <td ><input id="sale_sales" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Total Sales'].'"' ?>required></td>
                <td style="text-align: center; font-weight: bold">Scratcher P/O</td>
                <td ><input id="sale_scratcher" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Scratcher'].'"' ?>></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Start</td>
                <td ><input id="sale_start" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Cash Start'].'"' ?> required></td>
                <td style="text-align: center; font-weight: bold">Loto P/O</td>
                <td ><input id="sale_loto" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Loto'].'"' ?>></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Scratcher</td>
                <td ><input id="sale_ad_scratcher" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Adjust Scratcher'].'"' ?>></td>
                <td style="text-align: center; font-weight: bold">Reg P/O</td>
                <td ><input id="sale_reg" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Reg'].'"' ?>></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Loto</td>
                <td ><input id="sale_ad_loto" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Adjust Loto'].'"' ?>></td>
                <td style="text-align: center; font-weight: bold">End</td>
                <td ><input id="sale_end" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Cash End'].'"' ?> required></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Other</td>
                <td ><input id="sale_ad_other" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Adjust Other'].'"' ?>></td>
                <td style="text-align: center; font-weight: bold">Drops</td>
                <td id="sale_safe_drop" style="padding: 0 10px;"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Memo</td>
                <td><input id="memo" type="text" <?php echo 'value="'.$result1[0]['Memo'].'"' ?>></td>
                <td style="text-align: center; font-weight: bold">Credit</td>
                <td ><input id="sale_credit" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Credit'].'"' ?> required></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Total</td>
                <td id="sale_left_total" style="padding: 0 10px; font-weight: bold"></td>
                <td style="text-align: center; font-weight: bold">Total</td>
                <td id="sale_right_total" style="padding: 0 10px; font-weight: bold"></td>
            </tr>
        </table>
    </div>
    <br>

    <div id="gas_table3">
        <table class="shift_sale" id="drop_table" style="width: 100%">
        <col width="25%"><col width="25%"><col width="25%"><col width="25%">
            <tr>
                <td rowspan="6" style="text-align: center; font-weight: bold">Safe Drop</td>
                <td ><input id="drop1" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop01'].'"' ?>></td>
                <td ><input id="drop7" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop07'].'"' ?>></td>
                <td ><input id="drop13" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop13'].'"' ?>></td>
            </tr>
            <tr>
                <td ><input id="drop2" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop02'].'"' ?>></td>
                <td ><input id="drop8" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop08'].'"' ?>></td>
                <td ><input id="drop14" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop14'].'"' ?>></td>
            </tr>
            <tr>
                <td ><input id="drop3" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop03'].'"' ?>></td>
                <td ><input id="drop9" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop09'].'"' ?>></td>
                <td ><input id="drop15" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop15'].'"' ?>></td>
            </tr>
            <tr>
                <td ><input id="drop4" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop04'].'"' ?>></td>
                <td ><input id="drop10" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop10'].'"' ?>></td>
                <td ><input id="drop16" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop16'].'"' ?>></td>
            </tr>
            <tr>
                <td ><input id="drop5" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop05'].'"' ?>></td>
                <td ><input id="drop11" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop11'].'"' ?>></td>
                <td ><input id="drop17" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop17'].'"' ?>></td>
            </tr>
            <tr>
                <td ><input id="drop6" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop06'].'"' ?>></td>
                <td ><input id="drop12" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop12'].'"' ?>></td>
                <td ><input id="drop18" class="drop_amount" type="number" onchange="setTwoNumberDecimal(this)" <?php echo 'value="'.$result1[0]['Drop18'].'"' ?>></td>
            </tr>
        </table>
    </div>
</div>
<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>
</main>
</body>
<?php include "footer.php"; ?>