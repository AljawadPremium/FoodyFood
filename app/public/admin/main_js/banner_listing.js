$("document").ready(function() { 
    $(".banner_tab").trigger('click');
    $(".banner_listing").css({"color": "white"});
});

var table = $('#l_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(document).on('click',".delete_banner",function()
{
    var b_id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Remove this?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) 
        {
            $.ajax({
                type: 'POST',
                url: './banner/delete_banner',
                data: {b_id:b_id},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        $("#l_listing").DataTable().rows($(".banner_"+b_id)).remove()
                        $("#l_listing").DataTable().draw();

                        // $('.banner_'+b_id).remove('');
                        toastr.success(response.message, 'Success');
                    }
                    else 
                    {
                        toastr.warning(response.message, 'Warning');
                    }
                }
            });
        }
    })
});