$(document).on('click','.status_c_listing',function()
{
    var oid = $(this).data("id");
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/orders/order_info_get/"+oid,
        data: {},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true) {
                $('select[name="a_order_status"]:first').val(response.order_status) 
                $('#status_c_modal').modal('show');
                $('.a_display_order_id').val(response.display_order_id);

                // toastr.success(response.message, 'Success');
            }
            else {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$('.o_status').on('change', function() {

    var display_order_id = $('.a_display_order_id').val();
    var status = $('.a_o_status').val();

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
                $('.status_'+response.order_master_id).html(response.data_o_status);
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(function () {
    $('.clost_btn').on('click', function () {
        $("#status_c_modal").modal("hide");
    })
});

