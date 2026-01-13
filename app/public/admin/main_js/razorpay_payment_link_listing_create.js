function openModal()
{
    $('#payment_link_model').modal('show');
}


function closeModal()
{
    $('#payment_link_model').modal('hide');
}


$(document).on("submit",".payment_link_form",function(e)
{    
    var name = $("#name").val();
    var mobile = $("#mobile").val();
    var amount = $("#amount").val();

    var error = 1;    
    if(name==''){
        $(".name").html('Please enter customer name');
        error = 0;
    }else{$(".name").html('');}

    if(amount==''){
        $(".amount").html('Please enter amount');
        error = 0;
    }else{$(".amount").html('');}

    if(mobile==''){
        $(".mobile").html('Please enter mobile');
        error = 0;
    }else{$(".mobile").html('');}
    

    e.preventDefault();
    if(error==1)
    {
        $('.error_show').html("");
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./admin/payment/link",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true)
                {
                    $('.payment_link_form').trigger("reset");
                    toastr.success(response.message, 'Success');
                    // $("#payment_link_model .close").click();
                    $('#payment_link_model').modal('hide');
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});


/*payment_link_for_order*/


$(document).on('click',".order_payment_link",function() {
    var o_id = $(this).data('id');
    $.ajax({
        type: 'POST',
        url: './admin/orders/order_payment_link/'+o_id,
        data: {o_id:o_id},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true) {
                $('#order_payment_modal').modal('show');

                var display_order_id = response.data.display_order_id;
                var order_master_id = response.data.order_master_id;
                var net_total = response.data.net_total;
                var name = response.data.name;
                var email = response.data.email;
                var phone = response.data.phone;

                $('.order_id').html(order_master_id);
                $('.p_d_order_id').val(display_order_id);
                $('#pname').val(name);
                $('#pmobile').val(phone);
                $('#pemail').val(email);
                $('#pamount').val(net_total);
                $('#pmessage').val("Payment for Order no #"+order_master_id);
            }
            else {
                $('#order_payment_modal').modal('hide');
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(document).on("submit",".order_payment_link_form",function(e)
{    
    var name = $("#pname").val();
    var mobile = $("#pmobile").val();
    var amount = $("#pamount").val();

    var error = 1;    
    if(name==''){
        $(".name").html('Please enter customer name');
        error = 0;
    }else{$(".name").html('');}

    if(amount==''){
        $(".amount").html('Please enter amount');
        error = 0;
    }else{$(".amount").html('');}

    if(mobile==''){
        $(".mobile").html('Please enter mobile');
        error = 0;
    }else{$(".mobile").html('');}
    

    e.preventDefault();
    if(error==1)
    {
        $('.error_show').html("");
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./admin/razorpay/order_payment_link",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true)
                {
                    $('.order_payment_link_form').trigger("reset");
                    $('#order_payment_modal').modal('hide');
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 2000);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});

function close_Modal_payment_order_link()
{
    $('#order_payment_modal').modal('hide');
}

var table = $('#example_25').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});
