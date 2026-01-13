$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".tax_listing").css({"color": "white"});
});



$(document).on("submit",".update_tax_shipping",function(e)
{
    e.preventDefault();
    $('.error_show').html("");
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "admin/tax",
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
                $('.error_show').html(response.message);
                $(".error_show").css({"position": "relative","top":"0px", "color":"green","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                toastr.success(response.message, 'Success');
                // setTimeout(function(){ location.reload(); }, 1500);
            }
            else
            {
                $(".error_show").css({"position": "relative","top":"0px", "color":"red","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                $('.error_show').html(response.message);
                toastr.warning(response.message, 'Warning');
            }
        }
    });
    
});