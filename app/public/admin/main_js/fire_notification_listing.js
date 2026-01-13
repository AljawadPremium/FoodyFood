$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".notification_listing").css({"color": "white"});
});

$(document).on("submit",".f_notifi_submit",function(e)
{
    e.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/notification",
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
                $('.f_notifi_submit').trigger("reset");
                toastr.success(response.message, 'Success');
                // setTimeout(function(){ location.reload(); }, 2000);
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
    
});

$(document).on('click',".delete_noti",function(){
    var bid = $(this).data('id');
    if(bid!='')
    {
      swal({
            title: "",
            text: "Are you sure you want to delete?",
            type:"warning",                                  
            showCancelButton: true,                  
            confirmButtonText: "OK",
            cancelButtonText: "CANCEL",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(inputValue){
            if (inputValue===true) 
            {
                $.ajax({
                    type: 'POST',
                    url: './admin/notification/delete',
                    data: {bid:bid},
                    success: function(response)
                    {
                        if(response) {
                            toastr.success("Notification deleted successfully", 'Success');
                            $(".not_"+bid).remove();
                        }
                        else {
                            swal("","Invalid request try after sometime","warning");
                        }
                    }
                });
            } 
        });
    } 
    else 
    {
        swal("","Some thing want worng!!","warning");
    }
});


$(document).on('click',".resend_noti",function(){
    var bid = $(this).data('id');
    if(bid!='')
    {
      swal({
            title: "",
            text: "Are you sure you want to resend this notification?",
            type:"warning",                                  
            showCancelButton: true,                  
            confirmButtonText: "OK",
            cancelButtonText: "CANCEL",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(inputValue){
            if (inputValue===true) 
            {
                $.ajax({
                    type: 'POST',
                    url: './notification/resend_noti',
                    data: {bid:bid},
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
    } 
    else 
    {
        swal("","Some thing want worng!!","warning");
    }
});