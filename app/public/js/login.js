$(document).on("submit",".user_login_form",function(e)
{
    e.preventDefault();
    $('.error_show').html("");
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./login",
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
                errorsHtml = '<div class="alert alert-success"><ul>';
                errorsHtml += '<li>' + response.message + '</li>'; //showing only the first error.
                errorsHtml += '</ul></di>';
                $( '.error_show' ).html( errorsHtml );

                toastr.success(response.message, 'Success');
                setTimeout(function(){ location.reload(); }, 1500);
            }
            else
            {
                errorsHtml = '<div class="alert alert-danger"><ul>';
                errorsHtml += '<li>' + response.message + '</li>'; //showing only the first error.
                errorsHtml += '</ul></di>';
                $( '.error_show' ).html( errorsHtml );

                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(document).on("submit",".user_register_form",function(e)
{
    e.preventDefault();
    $('.register_msg_show').html("");
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./register",
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
                $(".register-button").prop("disabled", true);

                errorsHtml = '<div class="alert alert-success"><ul>';
                errorsHtml += '<li>' + response.message + '</li>'; //showing only the first error.
                errorsHtml += '</ul></di>';
                $( '.register_msg_show' ).html( errorsHtml );

                toastr.success(response.message, 'Success');
                setTimeout(function(){ location.reload(); }, 1500);
            }
            else
            {
                errorsHtml = '<div class="alert alert-danger"><ul>';
                errorsHtml += '<li>' + response.message + '</li>'; //showing only the first error.
                errorsHtml += '</ul></di>';
                $( '.register_msg_show' ).html( errorsHtml );

                toastr.warning(response.message, 'Warning');
            }
        }
    });
});