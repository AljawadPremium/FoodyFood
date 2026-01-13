$(document).on('click',".user_logut",function()
{
    var base_url = $('.base_url').val();
    swal({
        title: "",
        text: "Are you sure you want to logout ?",
        type:"warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(inputValue)
    {
        if (inputValue===true) 
        {
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: base_url+'/admin/logout',
                data: {},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        toastr.success(response.message, 'Success');
                        setTimeout(function(){window.location= ("./admin");}, 2000);
                    }
                    else
                    {
                        toastr.warning(response.message, 'Warning');
                    }
                }
            });
        } 
    });
});