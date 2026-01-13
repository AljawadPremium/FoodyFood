$("document").ready(function() { 
    $(".category_tab").trigger('click');
    $(".category_listing").css({"color": "white"});
});

var table = $('#l_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(document).on('click',".delete_sub_category",function()
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
                url: './category/delete_sub_category',
                data: {s_id:s_id},
                success: function(response)
                {
                    if(response)
                    {
                        $('.sub_category_'+s_id).remove('');
                        Swal.fire('Deleted!','All your category data has been deleted.','success');
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

$(document).on('click',".delete_main_category",function()
{
    var m_id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Remove this main category? All your subcategory along with there product will be deleted.",
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
                url: './category/delete_main_category',
                data: {m_id:m_id},
                success: function(response)
                {
                    if(response)
                    {
                        $("#l_listing").DataTable().rows($(".main_category_"+m_id)).remove()
                        $("#l_listing").DataTable().draw();

                        Swal.fire('Deleted!','All your category data has been deleted.','success');
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
