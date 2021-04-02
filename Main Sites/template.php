<?php 
require ('../../../../wp-load.php');
get_header();

try {
    require "userCheck.php";
    if ($tbName === 'Scratcher Report') {
        $sql = "SELECT * FROM `Scratcher Report`";
    } else {
        $sql = "SELECT * FROM `Scratcher Report Test`";
    }

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
}
    catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) {
?>
<body>
<main id="main-holder">
<h1 id="scratcher_report_template_head" style="text-align: center; display: block">Scratchers Sale Report</h1>
<h1 id="store_sale_report_template_head" style="text-align: center; display: none">Store Sale Report</h1>

<div style="text-align: center;">
    <button class="group_function" id="home_button" type="button" onclick="home();">Home Page</button>
    <input id="toggle" class="group_function" type="submit" onclick="toggle();" value="Sale Template"/>
    <button id="print" class="group_function" type="button" onclick="window.print();">Print</button>
</div>
    <hr class="divide" width="80%">

<div id="scratcher_report_template" style="display: block">
    <table id="scratcher_report_table">
        <thead class="table_head">
        <tr class="report_head">
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Clerk Name: </th>
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Date: </th>
            <th colspan="3" style="vertical-align: middle; text-align: left; font-weight: bold; height: 30px">Shift: </th>
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
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"><?php echo escape($row["Price Unit"]); ?></td>
                <td style="text-align: center"></td>
            </tr>
        <?php } ?>
            <tr style="height: 23px">
                <td colspan="8" style="text-align: center; font-weight: bold">GRAND TOTAL</td>
                <td style="text-align: center; font-weight: bold"></td>
            </tr>
        </tbody>
    </table>
</div>
<div id="store_sale_report_template" style="display: none">

    <div id="sale_content" style="width: 90%">
    <div id="gas_header" style="font-weight: bold; font-size: 18px;">
        <div style="padding: 5px;">Clerk Name: </div>
        <div style="padding: 5px;">Date: </div>
        <div style="padding: 5px;">Shift: </div>
    </div>
    <br><br>
    <div id="gas_table1">
        <table class="shift_sale" id="cigar_table" style="width: 100%">
            <col width="30%"><col width="10%"><col width="15%"><col width="45%">
            <tr>
                <td rowspan="5" style="text-align: center; font-weight: bold; width: 200px">Cigars</td>
                <td style="text-align: center; font-weight: bold">Open</td>
                <td ><input id="cigar_open" type="number"></td>
                <td ><input id="open_note" type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Add</td>
                <td ><input id="cigar_add" type="number"></td>
                <td ><input id="add_note" type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Total</td>
                <td id="cigar_total" style="padding: 0 10px;"></td>
                <td ><input type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Close</td>
                <td ><input id="cigar_close" type="number"></td>
                <td ><input type="text"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Sold</td>
                <td id="cigar_sold" style="padding: 0 10px;"></td>
                <td ><input id="sold_note" type="text"></td>
            </tr>
        </table>
    </div>
    <br>

    <div id="gas_table2">
        <table class="shift_sale" id="sale_table" style="width: 100%">
            <col width="20%"><col width="30%"><col width="20%"><col width="30%">
            <tr>
                <td style="text-align: center; font-weight: bold">Sales</td>
                <td ><input id="sale_sales" type="number"></td>
                <td style="text-align: center; font-weight: bold">Scratcher P/O</td>
                <td ><input id="sale_scratcher" type="number"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Start</td>
                <td ><input id="sale_start" type="number"></td>
                <td style="text-align: center; font-weight: bold">Loto P/O</td>
                <td ><input id="sale_loto" type="number"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Scratcher</td>
                <td ><input id="sale_ad_scratcher" type="number"></td>
                <td style="text-align: center; font-weight: bold">Reg P/O</td>
                <td ><input id="sale_reg" type="number"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Loto</td>
                <td ><input id="sale_ad_loto" type="number"></td>
                <td style="text-align: center; font-weight: bold">End</td>
                <td ><input id="sale_end" type="number"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Adjust Other</td>
                <td ><input id="sale_ad_other" type="number"></td>
                <td style="text-align: center; font-weight: bold">Drops</td>
                <td id="sale_safe_drop" style="padding: 0 10px;"></td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">Memo</td>
                <td><input id="memo" type="text"></td>
                <td style="text-align: center; font-weight: bold">Credit</td>
                <td ><input id="sale_credit" type="number"></td>
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
                <td ><input id="drop1" class="drop_amount" type="number"></td>
                <td ><input id="drop7" class="drop_amount" type="number"></td>
                <td ><input id="drop13" class="drop_amount" type="number"></td>
            </tr>
            <tr>
                <td ><input id="drop2" class="drop_amount" type="number"></td>
                <td ><input id="drop8" class="drop_amount" type="number"></td>
                <td ><input id="drop14" class="drop_amount" type="number"></td>
            </tr>
            <tr>
                <td ><input id="drop3" class="drop_amount" type="number"></td>
                <td ><input id="drop9" class="drop_amount" type="number"></td>
                <td ><input id="drop15" class="drop_amount" type="number"></td>
            </tr>
            <tr>
                <td ><input id="drop4" class="drop_amount" type="number"></td>
                <td ><input id="drop10" class="drop_amount" type="number"></td>
                <td ><input id="drop16" class="drop_amount" type="number"></td>
            </tr>
            <tr>
                <td ><input id="drop5" class="drop_amount" type="number"></td>
                <td ><input id="drop11" class="drop_amount" type="number"></td>
                <td ><input id="drop17" class="drop_amount" type="number"></td>
            </tr>
            <tr>
                <td ><input id="drop6" class="drop_amount" type="number"></td>
                <td ><input id="drop12" class="drop_amount" type="number"></td>
                <td ><input id="drop18" class="drop_amount" type="number"></td>
            </tr>
        </table>
    </div>
</div>
</div>

<?php } else { ?>
    <p>No Result found!</p>
<?php } ?>
<?php get_footer(); ?>