$("document").ready(function() { 
    $(".order_tab").trigger('click');
    $(".o_listing").css({"color": "white"});
});

$(".p_status").select2({  
});
$(".o_status").select2({  
});
$(".driver_select").select2({  
});

$('.o_status').on('change', function() {
    var status = $('.o_status').val();
    var display_order_id = $('.d_order_id').val();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/orders/order_status_change/"+display_order_id,
        data: {"order_status":status},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$('.p_status').on('change', function() {
    var status = $('.p_status').val();
    var display_order_id = $('.d_order_id').val();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/orders/payment_status_change/"+display_order_id,
        data: {"payment_status":status},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$('.driver_select').on('change', function() {
    var driver_id = $('.driver_select').val();
    var display_order_id = $('.d_order_id').val();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/orders/assign_driver/"+display_order_id,
        data: {"driver_id":driver_id},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(document).on("submit",".order_c_form",function(e)
{
    e.preventDefault();
    $('.error_show').html("");
    var order_master_id = $('.order_master_id').val();
    var order_comment = $('.order_comment').val();

    var error = 1;    
    if(order_comment==''){
        toastr.warning("Please enter order comment", 'Warning');
        $(".order_c_error").html('Please enter order comment');
        error = 0;
    }

    if(error==1)
    {
      $('#loading').show();
       $.ajax({
            type: 'POST',
            url: "./orders/comment_order_notification/"+order_master_id,
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
                    toastr.success(response.message, 'Success');
                    // $(".dataTables_empty").css("display", "none");
                    $('.order_comment').val("");
                    $('.comment_body').prepend("<tr class='remove_"+response.inserted_id+"'><td>"+order_comment+"</td><td>"+response.created_date+"</td><td><a class='order_comment_delete' data-id = "+response.oid+" data-iid = "+response.inserted_id+"><i class='fa fa-trash'></i></a></td></tr>");
                    
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});

$(document).on('click',".order_comment_delete",function(){
    var c_id = $(this).data('id');
    var i_id = $(this).data('iid');

    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: './admin/order/delete_order_comment',
        data: {i_id:i_id},
        success: function(response)
        {
            $('#loading').hide();
            if(response)
            {
                $(".remove_"+i_id).remove();
                toastr.success("Comment deleted successfully", 'Success');
            }
            else 
            {
                toastr.warning("Invalid request try after sometime", 'Warning');
            }
        }
    });
});

$(document).on("click",".a_comment_submit",function(e)
{
    e.preventDefault();
    var order_master_id = $('.order_master_id').val();
    var admin_note = $('.admin_comment').val();

    var error = 1;    
    if(admin_note==''){
        toastr.warning("Please enter comment", 'Warning');
        error = 0;
    }

    if(error==1)
    {
      $('#loading').show();
       $.ajax({
            type: 'POST',
            url: "./admin/orders/admin_comment/"+order_master_id,
            data: {admin_note:admin_note},
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true) {
                    toastr.success(response.message, 'Success');
                }
                else {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});


$(document).on('click','.o_edit_s',function()
{
    $('#o_edit_model').modal('show');
});

$(function () {
    $('.clost_btn').on('click', function () {
        $("#o_edit_model").modal("hide");
    })
});