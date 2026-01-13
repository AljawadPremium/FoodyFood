$("document").ready(function() { 
    $(".attribute_tab").trigger('click');
    $(".attribute_add").css({"color": "white"});
});


$(document).on("submit",".add_attribute",function(e)
{
    e.preventDefault();
    var error=1;
    var attribute_item_id = $('.attribute_item_id').val();

    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_attribute",
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
                    if (attribute_item_id == '') {
                        $('.add_attribute').trigger("reset");
                    }

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
    }
});
