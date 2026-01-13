/*var table = $('#customer_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});*/

$("document").ready(function() { 
    // $(".customer_tab").trigger('click');
    $(".customer_tab").css({"color": "white"});
    loadPagination("1","call");
});


$('.building_name').on('change', function() {
    loadPagination("1","call");
});

$('.filter_by').on('change', function() {
    loadPagination("1","call");
});

$('.sort_by').on('change', function() {
    loadPagination("1","call");
});


$(document).on("keyup","#search_val",function()
{      
    loadPagination('0','search');
});

$('#pagination').on('click','a',function(e)
{
    e.preventDefault();
    var pageno = $(this).attr("data-id");
    var pageno = pagination_remove_speical(pageno);
    loadPagination(pageno,"call");
});

function loadPagination(pagno,ajax,serach='')
{
    var serach = $("#search_val").val();
    var building_name = $(".building_name").val();
    var filter_by = $(".filter_by").val();
    var sort_by = $(".sort_by").val();

    $('#loading').show();
    $.ajax({
        url: "./admin/customer",
        type: 'post',
        data:{pagno:pagno,ajax:ajax,serach:serach,filter_by:filter_by,sort_by:sort_by,building_name:building_name},
        dataType: 'json',
        success: function(response)
        {  
            $('#loading').hide(); 
            $('#pagination').html(response.pagination_link);
            var tabledata = response.result;
            var trHTML= creatTable(tabledata); 
            $('#table_body').html(trHTML);
        }
    });
}

function creatTable(tabledata) {
    var trHTML='';       
    if(tabledata!='')
    {
        $.each(tabledata, function( k, v ) 
        {
            trHTML+='<tr class="main_c_'+v.c_id+'" id="cus_'+v.c_id+'" >';
                trHTML+='<td>';
                    trHTML+='<input class="check_box_customer_input" name="test" type="checkbox" id="subscribeNews_'+v.c_id+'" value="'+v.c_id+'"> ';
                    trHTML+='<label class="cust_check_box_label" for="subscribeNews_'+v.c_id+'">'+v.id+'</label>';
                trHTML+='</td>';
                trHTML+='<td><a href="admin/customer/view/'+v.c_id+'">'+v.first_name+' '+v.last_name+'</a></td>';        
                trHTML+='<td><a class="w_icon" href="https://api.whatsapp.com/send?phone='+v.phone+'">'+v.phone+' <span class="w_app"><i class="fa fa-whatsapp"></i></span></a></td>';
                trHTML+='<td>'+v.created_date+'';
                // trHTML+='<td>'+v.building_name+'';
                // trHTML+='<td>'+v.wing_name+'';
                trHTML+='<td>'+v.source+'</td>';
                trHTML+='<td>'+v.order_count+' ('+v.unpaid_amt+')</td>';
                trHTML+='<td class="relative">'+v.action_url+'</td>';
            trHTML+='</tr>';
        });  
    }
    else
    {
        trHTML+='<tr>';
            trHTML+='<td colspan="10"> No record found </td>';
        trHTML+='</tr>';
    }
    return trHTML;
}


$(document).on('click',".delete_customer",function(){
    var c_id = $(this).data('id');
    if(c_id!='')
    {
      swal({
            title: "",
            text: "Are you sure you want to delete this user?",
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
                    url: './admin/customer/delete_customer',
                    data: {c_id:c_id},
                    success: function(response)
                    {
                        $('#loading').hide();
                        var response = $.parseJSON(response);
                        if (response.status == true)
                        {
                            $(".main_c_"+c_id).remove();
                            toastr.success(response.message, 'Success');
                        }
                        else
                        {
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

$(document).on('click',".delete_address",function(){
    var a_id  = $(this).data('id');
    if(a_id!='')
    {
        swal({
            title: "Are you sure?",
            text: "You want to remove this address !",
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
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: './customer/delete_address',
                data: {a_id:a_id},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        $('.address_'+a_id).remove('');
                        toastr.success(response.message, 'Success');
                    }
                    else
                    {
                        toastr.warning(response.message, 'Warning');
                    }
                }
            });            
        } 
        });
    }
});

/*Delete Multiple*/

$(document).ready(function () {
    $(document).on('click', '.check_box_customer_input', function() {
        getSelectedCheckBoxwithValueText("test")               
    });

    var getSelectedCheckBoxwithValueText = function (name1) {
        var data = $('input[name="' + name1 + '"]:checked');
        if (data.length > 0) {
            var resultdata='' ;
            data.each(function () {
                var selectedValue = $(this).val();
                 resultdata += selectedValue+',';

            });
            // alert(resultdata);

            $(".p_select_checkbox").css({"display":"block"});
            return resultdata;
        }
        else 
        {
            // alert('resultdata');
            $(".p_select_checkbox").css({"display":"none"});
        }
    };

    $(document).on('click', '.delete_selected', function() 
    {
        var c_ids = getSelectedCheckBoxwithValueText("test");
        if (c_ids) 
        {
            swal({
                title: "",
                text: "Are you sure you want to delete selected customer?",
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
                    $('#loading').show();
                    $.ajax({
                        type: 'POST',
                        url: './admin/customer/delete_multiple_customer',
                        data: {c_ids:c_ids},
                        success: function(response)
                        {
                            $('#loading').hide();
                            var response = $.parseJSON(response);
                            if (response.status == true)
                            {
                                var array = c_ids.split(',');
                                // console.log(array);
                                $.each(array,function(i, value)
                                {
                                    if (value) 
                                    {
                                        $("#cus_"+value).remove();
                                        console.log('index: ' + i + ',value: ' + value);
                                    }
                                });
                                $(".p_select_checkbox").css({"display":"none"}); 
                                toastr.success(response.message, 'Success');
                            }
                            else
                            {
                                toastr.warning(response.message, 'Warning');
                            }
                        }
                    });
                } 
            });
        }
    });
});

$(document).on('click',".notification_c",function() {

    var c_name  = $(this).data('name');
    var cid  = $(this).data('id');
    $('.add_name').html(c_name);
    $('.n_cust_id').val(cid);
    $('.c_not').val('');
    $('#notification_customer').modal('show');
});

$(document).on('click',".clost_btn",function() {
    $('#notification_customer').modal('hide');
});

$(document).on("submit",".send_notification_to_single_user",function(e)
{
    e.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/customer/user_single_notification",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true) {
                $('#notification_customer').modal('hide');
                toastr.success(response.message, 'Success');                
            }
            else {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
    
});

$(".building_name").select2({
});

$(".filter_by").select2({
});

$(".sort_by").select2({
});