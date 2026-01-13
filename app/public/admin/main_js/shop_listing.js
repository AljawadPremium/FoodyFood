$("document").ready(function() { 
    $(".shop_tab").trigger('click');
    $(".shop_listing").css({"color": "white"});
});

var table = $('#l_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(document).on('click',".delete_sub_shop",function()
{
    var s_id = $(this).data('id');
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
                url: './shop/delete_sub_shop',
                data: {s_id:s_id},
                success: function(response)
                {
                    if(response)
                    {
                        $('.sub_shop_'+s_id).remove('');
                        Swal.fire('Deleted!','All your shop data has been deleted.','success');
                    }
                    else 
                    {
                        Swal.fire('','Invalid request try after sometime.','warning');
                    }
                }
            });
        }
    })
});

$(document).on('click',".delete_main_shop",function()
{
    var m_id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Remove this shop?",
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
                url: './shop/delete_main_shop',
                data: {m_id:m_id},
                success: function(response)
                {
                    if(response)
                    {
                        $("#l_listing").DataTable().rows($(".main_shop_"+m_id)).remove()
                        $("#l_listing").DataTable().draw();

                        Swal.fire('Deleted!','Shop data has been deleted.','success');
                    }
                    else 
                    {
                        Swal.fire('','Invalid request try after sometime.','warning');
                    }
                }
            });
        }
    })
});