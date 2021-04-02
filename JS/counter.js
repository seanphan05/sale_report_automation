function getId(obj) {
    var name = obj.className;
    var adds = 'add_'.concat(name);
    var add_message = 'add_message_'.concat(name);
    var unit_price = 'price_'.concat(name);
    var add_price = 'add_price_'.concat(name);
    var current = 'current_'.concat(name);
    var next = 'next_current_'.concat(name);
    var arr = [];
    arr.push(adds, add_message, unit_price, add_price, current, next);
    return (arr);
}

function addFunction(obj, num) {
    var idName = getId(obj)[0];
    var idMessage = getId(obj)[1];
    var idUnitPrice = getId(obj)[2];
    var idPrice = getId(obj)[3];
    var idCurrent = getId(obj)[4];
    var idNext = getId(obj)[5];

    var current = parseInt(document.getElementById(idName).innerHTML);
    var grandTotal = parseInt(document.getElementById("total_add_price").innerHTML);
    var unitPrice = parseInt(document.getElementById(idUnitPrice).innerHTML);
    var current_ticket = parseInt(document.getElementById(idCurrent).innerHTML);
    current += num;
    var next_current = current_ticket + current;
    var total = current*unitPrice;
    grandTotal += num*unitPrice;

    document.getElementById(idMessage).style.display = "block";
    document.getElementById("total_add_message").style.display = "block";
    document.getElementById(idName).innerHTML = current;
    document.getElementById(idPrice).innerHTML = '$' + total;
    document.getElementById("total_add_price").innerHTML = grandTotal;
    document.getElementById(idNext).innerHTML = next_current;

    document.getElementById(idName).style.color = "red";
    document.getElementById(idPrice).style.color = "red";
    document.getElementById(idNext).style.color = "red";
    document.getElementById(idName).style.fontWeight = "bold";
    document.getElementById(idPrice).style.fontWeight = "bold";
    document.getElementById(idNext).style.fontWeight = "bold";
}

function resetCount(obj) {
    var idName = getId(obj)[0];
    var idMessage = getId(obj)[1];
    var idPrice = getId(obj)[3];
    var grandTotal = parseInt(document.getElementById("total_add_price").innerHTML);
    var total = parseInt(document.getElementById(idPrice).innerHTML.substring(1));
    grandTotal -= total;

    document.getElementById("total_add_price").innerHTML = grandTotal;
    document.getElementById(idName).innerHTML = "0";
    document.getElementById(idPrice).innerHTML = "0";
    document.getElementById(idMessage).style.display = "none";
}


function activate() {
    window.location.href='activation.php';
}

function current() {
    window.location.href='current.php';
}

function showInfo() {
  var x = document.getElementById("quickModeInfo");
  var label = document.getElementById("toggle");
  if (x.style.display === "none" && label.innerHTML == "Show Current") {
    x.style.display = "block";
    label.innerHTML = "Hide Current"
  } else {
    x.style.display = "none";
    label.innerHTML = "Show Current"
  }
}

function closeShift() {
    window.location.href='close_shift.php';
}

function returnTicket() {
    window.location.href='return.php';
}

function quickAdd() {
    window.location.href='quick_add.php';
}

function saleReport() {
    window.location.href='store_sale_report.php';
}

function setTwoNumberDecimal(el) {
    el.value = parseFloat(el.value).toFixed(2);
}

function setInt(el) {
    el.value = parseFloat(el.value).toFixed();
}

function home() {
    window.location.href='main.php';
}

function refresh() {
    window.location.reload();
}

function template() {
    window.location.href='template.php';
}

function toggle() {
    var x1 = document.getElementById("scratcher_report_template_head");
    var x2 = document.getElementById("scratcher_report_template");
    var x3 = document.getElementById("store_sale_report_template_head");
    var x4 = document.getElementById("store_sale_report_template");

    if (x1.style.display === "none") {
        x1.style.display = "block";
        x2.style.display = "block";
        x3.style.display = "none";
        x4.style.display = "none";
        document.getElementById("toggle").value = "Sale Template";
    } else {
        x1.style.display = "none";
        x2.style.display = "none";
        x3.style.display = "block";
        x4.style.display = "block";
        document.getElementById("toggle").value = "Scratcher Template";
    }
}

function printReport() {
    document.getElementById("closeShift").disabled = false;
    document.getElementById("reminder").style.display = "none";
    window.print();
    return false;
}

