function pagination_remove_speical(pageno)
{
    var pageno = pageno.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
    return pageno;
}




$(document).on('click',".delete_product",function(){
    var pid = $(this).data('id');
    if(pid!='')
    {
        swal({
            title: "",
            text: "Are you sure you want to delete this product! ",
            type:"warning",
            showCancelButton: true,
            confirmButtonText: "YES",
            cancelButtonText: "NO",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(inputValue){
            if (inputValue===true) 
            {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: './product/delete_product',
                    data: {pid:pid},
                    success: function(response)
                    {
                        $('#loading').hide();
                        var response = $.parseJSON(response);
                        if (response.status == true){
                            $(".rowdelete_"+pid).remove();
                            toastr.success(response.message, 'Success');
                            // setTimeout(function(){ location.reload(); }, 1500);
                        }
                        else{
                            toastr.warning(response.message, 'Warning');
                        }
                    }
                });
            } 
        });
    } 
});

$(document).ready(function()
{
    $(".checkboxx").change(function() {
        $('.checkboxx').prop("checked",false);
        $(this).prop("checked",true);
        loadPagination("0","call");
        $(".ad_clear_btn").html('<label class="clear_selection">Clear selection</label>');
    });

    $(document).on("click",".clear_selection",function() {
        $('.checkboxx').prop("checked",false);
        $(".ad_clear_btn").html('');
        loadPagination("0","call");
    });

    $("#pagination").on("click","a",function(e)
    {
        e.preventDefault();
        var ajax="call";
        var pageno = $(this).attr("data-id");
        var pageno = pagination_remove_speical(pageno);
        loadPagination(pageno,ajax);
    });

    $(document).on("keyup","#search_btn",function()
    {
        var pagno=0;
        var ajax="call";
        loadPagination(pagno,ajax); 
    });

    $('.cat_id').on('change', function() {
        loadPagination("0","call");
    });

    $('.filter_by').on('change', function() {
        loadPagination("0","call");
    });

    $('.sort_by').on('change', function() {
        loadPagination("0","call");
    });


    function loadPagination(pagno,ajax)
    {
        var search = $(".search_value").val();
        var cat_id = $('.cat_id').find(":selected").val();
        var filter_by = $('.filter_by').find(":selected").val();
        var sort_by = $('.sort_by').find(":selected").val();
        var c_box = $('.checkboxx:checked').val();

        if (c_box == undefined) {
            var c_box = '';
        }

        $('#loading').show();
        $.ajax({        
            url: './admin/product',
            type: 'POST',
            data:{pagno:pagno,ajax:ajax,search:search,cat_id:cat_id,filter_by:filter_by,sort_by:sort_by,c_box:c_box},
            dataType: 'json',       
            success: function(response, textStatus, xhr)
            {  
                $('#loading').hide(); 
                if(xhr.status==200)
                {
                    if(response.status==true)
                    {
                        $('.checkbox_msg').html(response.checkbox_msg);

                        $('#pagination').html(response.pagination_link);
                        var tabledata=response.result;            
                        var trHTML= creatTable(tabledata);              
                        $('#table_body').html(trHTML);
                    }else{
                        toastr.warning(response.message, 'Warning'); 
                    }
                }else{
                    toastr.warning("Something Went Wrong", 'Warning');
                }    
            }
        });
    }


    function creatTable(tabledata) 
    {
        if(tabledata!='')
        {
            var trHTML='';

            $.each(tabledata, function( k, v ) 
            {   
               trHTML+='<tr class="rowdelete_"'+v.product_id+'>';
               trHTML+='<td>'+v.id+'</td>';
               trHTML+='<td>'+v.product_name+'</td>';
               // trHTML+='<td><img class="img_show" src="'+v.product_image+'"></td>';
               trHTML+='<td>'+v.category_name+'</td>';
               trHTML+='<td>'+v.stock+'</td>';
               trHTML+='<td>'+v.stock_status+'</td>';
               trHTML+='<td>'+v.status+'</td>';
               trHTML+='<td>'+v.action_url+'</td>';

               trHTML+='</tr>';                                
            });  
            return trHTML;    
        }else{
            var trHTML='<tr><td colspan="13">Record Not Found.!!</td></tr>';
            return trHTML;
        }
    }

});



// var table = $('#l_listing').DataTable({
//     // pageLength : 25,
//     paging : false,
//     searching : false,
//     // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
// });


$("document").ready(function() { 
    $(".product_tab").trigger('click');
    $(".product_listing").css({"color": "white"});
});


$(".cat_id").select2({
});

$(".filter_by").select2({
});


$(".sort_by").select2({
});

