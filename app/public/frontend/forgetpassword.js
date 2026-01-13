$('#verify_form1').submit(function(event)
{ 
    event.preventDefault(); 
    var ajax_url = $(this).data('url');
    var new_pw = $('#new_pw').val();
    var cfm_pw = $('#cfm_pw').val(); 
    var error = 1;

    if(new_pw =="") {   
        error = 0;
        $('.error_show').html('Please Enter New Password');
        toastr.warning("Please Enter New Password", 'Warning');
        return false;
    }
    if(cfm_pw =="") {
        error = 0;
        $('.error_show').html('Please Enter Confirm Password');
        toastr.warning("Please Enter Confirm Password", 'Warning');
        return false;
    }
    if (new_pw != cfm_pw) {
        error=0;
        $('#new_pw').val('');
        $('#cfm_pw').val('');
        $('.error_show').html('New Password & Confirm Password Not Matched');
        toastr.warning("New Password & Confirm Password Not Matched", 'Warning');
        return false;
    }

    if(error==1)
    {
        $('.error_show').html('');
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response, textStatus, xhr)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true)
                {
                    $('.error_show').html(response.message);
                    toastr.success(response.message, 'Success');
                    setTimeout(function(){ window.location = response.flag }, 1500);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});