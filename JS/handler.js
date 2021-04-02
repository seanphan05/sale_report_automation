$(document).ready(function () {
    // Login Page
    $("#login-form-submit").on('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const loginErrorMsg = document.getElementById("login-error-msg-holder");
        
        var clerkName = document.getElementById("username-field").value;
        var shiftInfo = document.getElementById("shift-field").value;
        var password = document.getElementById("password-field").value;

        if (clerkName === "" || shiftInfo === "" || password === "") {
            loginErrorMsg.innerHTML = "Please fill out all fields!";
            loginErrorMsg.style.display = "block";
        } else if (password === "vgs1495" || password === "testuser") {
            document.cookie = "code=" + password;
            var json = {clerkName: clerkName, shiftInfo: shiftInfo, code: password};
            $.ajax({
                method: "POST",
                url: "wp-content/themes/lotterytheme/main/verification.php",
                data: json,
                success: function() {
                    alert("You have successfully logged in.");
                    window.location.href="https://lotteryreport.ga/wp-content/themes/lotterytheme/main/main.php"; } 
            })
        } else {
            loginErrorMsg.innerHTML = "Invalid Verification Code! Please try again.";
            loginErrorMsg.style.display = "block";
            }
        });


    // Send data after submitting
    $("#submit").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var i;
        var jsonSale = {};
        for (i = 1; i < 33; i++) {
            var sale = document.getElementById("add_game" + ('0' + i).slice(-2)).innerHTML;
            if (sale !== "0") {
                jsonSale["game" + ('0' + i).slice(-2)] = sale; }
        }
        if (jQuery.isEmptyObject(jsonSale)) {
            jsonSale["error"] = "error";
        }
            ;
        $.ajax({
            method: "POST",
            url: "updateSale.php",
            data: jsonSale,
            success: function (data) {
                $("#add_sale_message").show();
                document.getElementById("add_sale_message").innerHTML = data;
                document.getElementById("submit").disabled = true;
            }
        })
    });


    // Get Current
    $("#toggle").on('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            method: "POST",
            url: "getCurrent.php",
            success: function (data) {
                document.getElementById("quickModeInfo").innerHTML = data;
            }
        })
    });


    // Return Ticket
    $("#returnTicket").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var gameID = $("#returnList").val();
        var noReturn = $("#returnTicketNum").val();
        var action = "return";
        var json = {action: action, gameID: gameID, noReturn: noReturn};

        $.ajax({
            method: "POST",
            url: "updateSale.php",
            data: json,
            success: function (data) {
                $("#returnSection").hide();
                $("#returnTicket").hide();
                $("#returnMessage").show();
                document.getElementById("returnMessage").innerHTML = data;
                $("#returnAnotherTicket").show();
            }
        })
    });


    // Pack Activation
    $(document).ready(function(){
        $('#activatePack').one('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var checkValues = $('input[name=checkboxlist]:checked').map(function()
            {
                return $(this).val();
            }).get();

            $.ajax({
                url: 'packActivate.php',
                method: "POST",
                data: {action: "activate", selectedGames: checkValues},
                success:function(data){
                    document.getElementById("nav-message").innerHTML = data;
                    $("#activation_section").hide();
                }
            });
        });
    });


    // Reverse Activation
    $(document).ready(function(){
        $('#reverseActivation').one('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var checkValues = $('input[name=checkboxlist]:checked').map(function()
            {
                return $(this).val();
            }).get();

            $.ajax({
                url: 'packActivate.php',
                method: "POST",
                data: {action: "reverse", selectedGames: checkValues},
                success:function(data){
                    document.getElementById("nav-message").innerHTML = data;
                    $("#activation_section").hide();
                }
            });
        });
    });


    // Update Game Info
    // Select Game Info
    $("#updateList").change(function() {
        var gameID = $("#updateList").val();
        var action = "get";
        var json = {action: action, gameID: gameID};
        
        $.ajax({
            method: "POST",
            url: "gameInfo.php",
            data: json,
            beforeSend: function() {
                $("#updateMessage").hide();
            },
            success: function(data) {
                $("#infoSection").show();
                document.getElementById("currentGameInfo").innerHTML = data;
                document.getElementById("updateGame").style.display = 'inline-block';
            }
        });
    });

    //Update Game Info
    $("#updateGame").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var gameID = $("#updateList").val();
        var newName = $("#newName").val();
        var newCount = $("#newCount").val();
        var newCode = $("#newCode").val();
        var newBegin = $("#newBegin").val();
        var newCurrent = $("#newCurrent").val();
        var newEnd = $("#newEnd").val();
        var newPrice = $("#newPrice").val();
        var action = "update";
        var json = {action: action, gameID: gameID, newName: newName, newCount: newCount, newCode: newCode, newBegin: newBegin, newCurrent: newCurrent, newEnd: newEnd, newPrice: newPrice};
        $.ajax({
            method: "POST",
            url: "gameInfo.php",
            data: json,
            beforeSend: function() {
                $("#updateMessage").hide();
            },
            success: function (data) {
                $("#updateSection").hide();
                document.getElementById("updateGame").style.display = 'none';
                $("#updateMessage").show();
                $("#updateMessage").html(data);
            }
        })
    });
    

    // Quick Add
    $(document).ready(function(){
        $('#quickAdd').one('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var json = [];
            
            $('input[name=qaEnd]').each(function(){
                values = {};
                values.id = this.id;
                values.val = this.value;
                json.push(values);
            });

            $('input[name=qaActivation]').each(function(){
                for (var i in json) {
                    if (json[i].id == this.id) {
                        json[i].ac = this.value;
                    }
                }
            });

            $.ajax({
                url: 'quickadd_ticket.php',
                method: "POST",
                data: {json: json},
                success:function(data){
                    document.getElementById("nav-message").innerHTML = data;
                    $("#quickadd_section").hide();
                    $("#quickAdd").hide();
                    $("#remind").hide();
                }
            });
        });
    });



    // Sale Report Generation
    // Pin info
    $("#pin").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var cigar_open = $("#cigar_open").val();
        var cigar_add = $("#cigar_add").val();
        var cigar_close = $("#cigar_close").val();
        var open_note = $("#open_note").val();
        var add_note = $("#add_note").val();
        var sold_note = $("#sold_note").val();

        var sales = $("#sale_sales").val();
        var start = $("#sale_start").val();
        var ad_scratcher = $("#sale_ad_scratcher").val();
        var ad_loto = $("#sale_ad_loto").val();
        var ad_other = $("#sale_ad_other").val();
        var memo = $("#memo").val();
        var scratcher = $("#sale_scratcher").val();
        var loto = $("#sale_loto").val();
        var reg = $("#sale_reg").val();
        var end = $("#sale_end").val();
        var credit = $("#sale_credit").val();

        var drop = [];
        for (i = 1; i < 19; i++) {
            amount = $("#drop" + i).val();
            drop.push(amount);
        }
           
        var json = {cigar_open: cigar_open, cigar_add: cigar_add, cigar_close: cigar_close, open_note: open_note, add_note: add_note, 
                    sold_note: sold_note, sales: sales, start: start, ad_scratcher: ad_scratcher, ad_loto: ad_loto, ad_other: ad_other, 
                    memo: memo, scratcher: scratcher, loto: loto, reg: reg, end: end, credit: credit, drop: drop};
        
        $.ajax({
            method: "POST",
            url: "updateStoreSale.php",
            data: json,
            success: function() {
                $("#pin_message").show();
            }
        });
    });

    $("#generation").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var blank_field = false;
        $('input[required]').each(function() {
            if ($(this).val() === '') {
                blank_field = true;
                document.getElementById("missing_error").style.display = 'block';
            }
        });


        if (!blank_field) {
            // cigar table
            var cigar_open = parseInt($("#cigar_open").val());
            var cigar_add = parseInt($("#cigar_add").val()) || 0;
            var cigar_close = $("#cigar_close").val();
            var total = cigar_open + cigar_add;
            var sold = cigar_open + cigar_add - cigar_close;
            document.getElementById("cigar_total").innerHTML = total;
            document.getElementById("cigar_sold").innerHTML = sold;

            // drop table
            var drop_total = 0;
            $(".drop_amount").each(function() { drop_total += (parseFloat($(this).val()) || 0) ; });
            document.getElementById("sale_safe_drop").innerHTML = drop_total.toFixed(2);

            // sale table
            var sales = parseFloat($("#sale_sales").val());
            var start = parseFloat($("#sale_start").val());
            var ad_scratcher = parseFloat($("#sale_ad_scratcher").val()) || 0;
            var ad_loto = parseFloat($("#sale_ad_loto").val()) || 0;
            var ad_other = parseFloat($("#sale_ad_other").val()) || 0;
            var scratcher = parseFloat($("#sale_scratcher").val()) || 0;
            var loto = parseFloat($("#sale_loto").val()) || 0;
            var reg = parseFloat($("#sale_reg").val()) || 0;
            var end = parseFloat($("#sale_end").val());
            var drop = parseFloat($("#sale_safe_drop").val()) || 0;
            var credit = parseFloat($("#sale_credit").val());
            var left_total = sales + start + ad_scratcher + ad_loto + ad_other;
            var right_total = scratcher + loto + reg + end + drop_total + credit;
            document.getElementById("sale_left_total").innerHTML = left_total.toFixed(2);
            document.getElementById("sale_right_total").innerHTML = right_total.toFixed(2);

            document.getElementById("sale_print").disabled = false;
            document.getElementById("missing_error").style.display = 'none';
            document.getElementById("pin_message").style.display = 'none';
        };
    });


    // Shift Close
    $("#closeShift").one('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            method: "POST",
            url: "closeShift.php",
            success: function () {
                $("#close_shift_message").show();
                $("#scratcher_report").hide();
            }
        })
    });


    //Sign Off
    // View Report
    $("#signOff").one('click', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "signOff.php",
            success: function () {
                window.location.href='https://lotteryreport.ga';
            }
        })
    });
});
