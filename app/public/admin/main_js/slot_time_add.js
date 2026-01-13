$("document").ready(function() { 
    $(".slot_tab").trigger('click');
    $(".slot_add").css({"color": "white"});
});

var table = $('#timer_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});


$(document).on("submit",".add_slot_timing",function(e)
{
    e.preventDefault();
    var error=1;
    var timer_id = $('.timer_id').val();

    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_slot_timer",
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
                    if (timer_id == '') {
                        $('.add_slot_timing').trigger("reset");
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


$(document).on('click',".delete_time",function()
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
                url: './admin/slot/delete_time',
                data: {b_id:b_id},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        $("#timer_listing").DataTable().rows($(".timer_"+b_id)).remove()
                        $("#timer_listing").DataTable().draw();

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