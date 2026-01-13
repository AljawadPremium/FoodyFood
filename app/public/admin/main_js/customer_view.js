
$("document").ready(function() { 
    // $(".customer_tab").trigger('click');
    $(".customer_tab").css({"color": "white"});
});


$(document).on("submit","#customer_form_update",function(e)
{
    var cid = $('.customer_id').val();
    e.preventDefault();
    $('#loading').show();

   $.ajax({
        type: 'POST',
        url: "./admin/customer/view/"+cid,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true) {
                toastr.success(response.message, 'Success');
                // setTimeout(function(){ window.location = response.redirect }, 1500);
            }
            else {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
    
});
