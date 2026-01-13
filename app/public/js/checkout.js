$("input[name=wallet_amount]").change(function () {
    var wall_amt = $("input[name=wallet_amount]:checked").val();
    var code = $("#voucher_code").val();
    $("#loading").show();
    values_update(wall_amt);
});

/*$('input[name=payment_mode]').change(function()
{
var payment_mode = $( 'input[name=payment_mode]:checked' ).val();
if (payment_mode == 'bank_transfer') 
{
$(".bank_info_div").css("display", "block");
}
else
{
$(".bank_info_div").css("display", "none");
}
});*/

function values_update(wall_amt, popup_mode = "") {

    var tip_amt = $('.tip_value').val();
    $('.checkout_tip_amt').val(tip_amt);
    
    var code = $("#voucher_code").val();

    var lat = $("#lat").val();
    var lng = $("#lng").val();

    $.ajax({
        type: "POST",
        url: "./ajax/get_checkout_amt",
        data: { wall_amt: wall_amt, code: code, lat: lat, lng: lng },
        success: function (response) {
            var response = $.parseJSON(response);
            $("#loading").hide();
            if (response.status == true) {

                var currency = "$ ";
                var w_amt = currency + "" + Math.abs(response.info.w_amt);
                $(".old_wall_minus_amount").html(w_amt);
                var w_amt_reason = response.info.w_amt_reason;
                $(".text_wallet").html(w_amt_reason);

                var c_price = response.info.cart_price;
                var cart_price = currency + "" + c_price;
                $(".checkout_sub_total_amount").html(cart_price);

                var shipping_amount = currency + "" + response.info.shipping_amount;
                $(".checkout_shipping_amount").html(shipping_amount);

                var tax_amt = currency + "" + response.info.tax_amt;
                $(".checkout_tax_amount").html(tax_amt);

                var used_wall_amt = currency + "" + response.info.used_wall_amt;
                $(".checkout_wallet_amount").html(used_wall_amt);

                var voucher_amount = currency + "" + response.info.voucher_amount;
                $(".checkout_voucher_amount").html(voucher_amount);

                $(".checkout_tip_amt").html(tip_amt);
                $(".add_distance").html("Distance :"+response.info.distance);


                // var g_price = response.info.total_cart + Math.abs(response.info.w_amt) ;
                var g_price = response.info.total_cart;

                var gtotal = Math.abs(g_price) + Math.abs(tip_amt);

                // console.log(tip_amt);
                // console.log(gtotal);
                // console.log(g_price);


                var checkout_grand_amount = currency + "" + gtotal;

                $(".checkout_grand_total").html(checkout_grand_amount);

                if (response.info.stattus === false) {
                    toastr.warning(response.info.voucher_message, "Warning");
                } else if (popup_mode != "") {
                    $("#voucher_code").val(code);
                    $("#coupn_popup .close").click();

                    window.scrollTo({ top: 0, behavior: "smooth" });
                    toastr.success(response.info.voucher_message, "Success");
                }

                $(".voucher_msg").html(response.info.voucher_message);
            } else if (response.status == false) {
                if (code) {
                    $("#voucher_code").val("");
                    $(".voucher_msg").html(response.message);
                }
                // swal("",response.message,"warning");
            }
        },
    });
}

$(document).on("submit", ".checkout_submit", function () {
    event.preventDefault();
    $("#loading").show();

    $.ajax({
        type: "POST",
        url: "./place-order",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            var response = $.parseJSON(response);
            $("#loading").hide();
            if (response.status == true) {
                swal({
                    title: "",
                    text: response.message,
                    type: "success",
                    showConfirmButton: false,
                    confirmButtonText: "",
                });
                setTimeout(function () {
                    window.location = "./cart/thank_you/" + response.data;
                }, 3000);
            } else if (response.status == false) {
                toastr.warning(response.message, "Warning");
            } else if (response.status == "incorrect_voucher") {
                $("#voucher_code").val("");
                $(".voucher_msg").html("");
                call_remove_voucher();
                toastr.warning(response.message, "Warning");
            } else if (response.status == "redirect") {
                swal({
                    title: "",
                    text: response.message,
                    type: "warning",
                    showConfirmButton: false,
                    confirmButtonText: "",
                });
                // $("#loading").show();
                // $(".payment_form_div").html(response.htmlForm);
                // $("#payment_form").submit();
                setTimeout(function () {
                    window.location = response.url;
                }, 2000);
            } else {
                swal("", "Something went worng", "warning");
            }
        },
    });
});

// $('input[name=payment_mode]').change(function(){
//     var payment_type = $( 'input[name=payment_mode]:checked' ).val();
//     if (payment_type === 'account_transfer')
//     {
//         $(".account_information").css("display", "block");
//     }
//     else
//     {
//         $(".account_information").css("display", "none");
//     }
// });

$(document).on("click", ".voucher_code_submit", function () {
    var code = $("#voucher_code").val();
    var lat = $("#lat").val();
    var address = $("#address_autocomplete").val();
    if (lat == '' || address == '') {
        toastr.warning("First add shipping street address then apply voucher","warning");
        $('#address_autocomplete').focus().css({
            'border': '2px solid blue',
            'background-color': '#f0f8ff',
            'color': '#333'
        });
        call_remove_voucher();
        return false;
    }

    $('#address_autocomplete').removeAttr('style'); 

    if (code != "") {
        $(".voucher_msg").html("");
        var wall_amt = $("input[name=wallet_amount]:checked").val();
        values_update(wall_amt);
        $(".che_voucher").css("display", "contents");
    } else {
        // call_remove_voucher();
        $(".che_voucher").css("display", "none");
        $(".voucher_msg").html("Please enter voucher code");
    }
});

$(document).on("click", ".remove_voucher", function () {
    call_remove_voucher();
});

function call_remove_voucher() {
    $("#voucher_code").val("");
    $(".voucher_msg").html("");
    var wall_amt = $("input[name=wallet_amount]:checked").val();
    $("#loading").show();
    values_update(wall_amt);
    $(".che_voucher").css("display", "none");
}

/*$("input:checkbox").on("click", function () {
var $box = $(this);
if ($box.is(":checked")) {
var group = "input:checkbox[name='" + $box.attr("name") + "']";
$(group).prop("checked", false);
$box.prop("checked", true);
} else {
$box.prop("checked", false);
}
});*/

/*$(document).on("click", "#hideshow", function () {
    $('input[name="address_id"]').each(function () {
        this.checked = false;
    });

    var content_html = $("#content_html").html();
    if (content_html !== "") {
        $("#content_html").html("");
        return false;
    }

    $("#loading").show();

    var html = "";
    $("#loading").hide();
    var city =
    '<input value="" name="city" type="text" class="form-control" placeholder="City">';

    html += '<div class="col-xs-6">';
    html += "<label>First Name *</label>";
    html +=
    '<input value="" name="first_name" type="text" class="form-control" placeholder="First Name">';
    html += '<p class="first_name"></p>';
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>Last Name *</label>";
    html +=
    '<input value="" name="last_name" type="text" class="form-control" placeholder="Last Name">';
    html += "</div>";

    html += '<div class="col-xs-6">';
    html += "<label>Street Address *</label>";
    html +=
    '<input value="" name="address" type="text" class="form-control" placeholder="Address">';
    html += "</div>";

    html += '<div class="col-xs-6">';
    html += "<label>Landmark *</label>";
    html +=
    '<input value="" name="landmark" type="text" class="form-control" placeholder="Landmark">';
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>Town / City *</label>";
    html += city;
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>State / County *</label>";
    html +=
    '<input value="" name="state" type="text" class="form-control" placeholder="State / County">';
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>Postcode / Zip *</label>";
    html +=
    '<input value="" name="postcode" type="text" class="form-control" placeholder="Postcode / Zip">';
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>Email Address </label>";
    html +=
    '<input value="" name="email" type="email" class="form-control" placeholder="Email Address" autocomplete="off">';
    html += "</div>";
    html += '<div class="col-xs-6">';
    html += "<label>Mobile/Phone Number *</label>";
    html +=
    '<input value="" name="phone" type="text" class="form-control" placeholder="Mobile/Phone Number" autocomplete="off">';
    html += "</div>";
    $("#content_html").html(html);
});*/

/*$(document).on("click", ".vouc_submit", function () {
    var code = $(this).data("id");
    if (code != "") {
        $(".voucher_msg").html("");
        var wall_amt = $("input[name=wallet_amount]:checked").val();
        values_update(wall_amt, "popup_mode");
        $("#loading").show();
    }
});*/



$(document).ready(function() {
    // Handle the click event on label elements
    $('.tip_sml').on('click', function() {
        // Remove 'active' class from all labels
        $('.tip_sml').removeClass('active');
        
        // Add 'active' class to the clicked label
        $(this).addClass('active');

        var tip = $(this).text().trim().replace('$', '');
        $('.tip_value').val(tip);
        $('.tip_a_input').val('');
        values_update();
    });
});
function validateInput(input) {
    // Remove invalid characters
    input.value = input.value.replace(/[^0-9.]/g, '');

    // Allow only one decimal point
    const parts = input.value.split('.');
    if (parts.length > 2) {
        input.value = parts[0] + '.' + parts[1];
    }
}



$('.aply_tip').on('click', function() {
    var tip = $('.tip_a_input').val();

    $('.tip_sml').removeClass('active');
    $('.tip_value').val(tip);
    if (tip) {
        toastr.success("Tip added successfully","Success");
    }
    values_update();
});
