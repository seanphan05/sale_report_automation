<?php
require ('../../../../wp-load.php');
get_header();

session_start();
if($_SESSION['status']!="Active") {
    header("location: https://lotteryreport.ga");
}
?>
<body id="close_shift_page">
<main id="main-holder">
<?php require "userCheck.php";
    if ($tbName === 'Scratcher Report') { ?>
    <h1 style="text-align: center;">Scratchers Sale Report</h1>
<?php } else { ?> 
    <h1 style="text-align: center;">Scratchers Sale Report Test Mode</h1>
<?php } ?>
<form style="text-align: center;">
    <button class="group_function" id="home_button" type="button" onclick="home();">Home Page</button>
    <button id="print" class="group_function" type="button" onclick="printReport();">Print</button>
    <input id="closeShift" class="group_function" type="submit" value="Close Shift" disabled/>
</form>
<div class="reminder-message" id="reminder" style="text-align: center; display:block"><p>Reminder: You can only close the shift after printing out the report!<p></div>
<hr style="width:80%" class="divide">
<div id="spacer" style="padding: 10px 0"></div>
<div id="scratcher_report">
    <?php include "printReport.php"; ?>
</div>
<div id="close_shift_message" style="text-align: center; display:none">
    Shift Close has been processed! You can now sign off.<br><br>
    <input id="signOff" type="submit" value="Sign Off">
</div>
<?php get_footer(); ?>