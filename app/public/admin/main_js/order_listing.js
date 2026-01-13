$("document").ready(function() { 
    $(".order_tab").trigger('click');
    $(".o_listing").css({"color": "white"});
});

$(document).ready(function()
{
    $('.orders ').addClass('active');
});

$(document).ready(function()
{
    $("#selUser").select2({
        // minimumInputLength: 3,
        ajax: {
            url: "./orders/get_customer",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('#selUser').on('change', function(e) {
        // console.log($('#selUser').select2("val"));
        loadPagination('1','');
    });

    $('.city_id').on('change', function(e) {
        // console.log($('#selUser').select2("val"));
        loadPagination('1','');
    });

    $('.filter_by').on('change', function(e) {
        // console.log($('#selUser').select2("val"));
        loadPagination('1','');
    });

    $(".city_id").select2({
        
    });
    $(".filter_by").select2({
        
    });
});

$(function() {
    var start = moment().subtract(30, 'days');
    var end = moment();
    function cb(start, end) {
        $('.start_date').val(start);
        $('.end_date').val(end);
        $('.custome_date').html('  '+start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        loadPagination('1','');
    }

    $('.custome_date').daterangepicker({
        //timePicker: true,
        //timePicker24Hour: true,
        //timePickerSeconds: true,
        // singleDatePicker: true,
        autoUpdateInput: false,

        showDropdowns: true,               
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           // 'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
           // 'Next 7 Days': [moment(), moment().add(6, 'days')],
           // 'Next 30 Days': [moment(), moment().add(29, 'days')],
           // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           // 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           // 'This Month': [moment().startOf('month'), moment().endOf('month')],
           // 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           // 'Last 6 Month': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last 1 Year': [moment().subtract(12, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           // 'Last 2 Year': [moment().subtract(24, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last 3 Year': [moment().subtract(36, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
});


$(document).on("keyup","#search_value",function() {
    loadPagination('1','');
});

$('#pagination').on('click','a',function(e)
{
    e.preventDefault();
    var ajax="call";
    var pageno = $(this).attr("data-id");
    var pageno = pagination_remove_speical(pageno);
    loadPagination(pageno,ajax);
});

function pagination_remove_speical(pageno)
{
    var pageno = pageno.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
    return pageno;
}

function loadPagination(pagno,ajax)
{
    var start_date = $('.start_date').val();
    var end_date = $('.end_date').val();

    var search_value = $('#search_value').val();
    var customer_id = $('.customer_id').val();
    var city_id = $('.city_id').val();
    var filter_by = $('.filter_by').val();

    $('#loading').show();
    $.ajax({
        url: "./admin/order/listing",
        type: 'post',
        data:{pagno:pagno,ajax:ajax,search_value:search_value,start_date:start_date,end_date:end_date,city_id:city_id,filter_by:filter_by,customer_id:customer_id},
        dataType: 'json',
        success: function(response)
        {
            $('#loading').hide();
            $(".order_count").html(response.count_array.order_count);
            $(".acc_count").html(response.count_array.acc_count);
            $(".shipped_count").html(response.count_array.shipped_count);
            $(".disp_count").html(response.count_array.disp_count);
            $(".deli_count").html(response.count_array.deli_count);
            $(".can_count").html(response.count_array.can_count);

            $('#pagination').html(response.pagination_link);
            var tabledata=response.result;
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
            trHTML+='<tr class="remove_'+v.order_id+'  '+v.tr_class+'">';
            trHTML+='<td>'+v.order_master_id+'</td>';
            trHTML+='<td><a href="./admin/orders/view/'+v.order_id+'">'+v.customer_name+'</a>';
            // trHTML+='<span class="chip__content">'+v.order_count+'</span></td>';
            trHTML+='</td>';
            // trHTML+='<td>'+v.driver_name+'</td>';
            // trHTML+='<td>'+v.city+'</td>';
            trHTML+='<td>'+v.payment_mode+'</td>';
            trHTML+='<td class="status_'+v.order_master_id+'" >'+v.order_status+'</td>';
            trHTML+='<td>'+v.payment_status+'</td>';
            currency = "$";
            trHTML+='<td>'+currency+''+v.net_total+'</td>';
            trHTML+='<td>'+v.order_datetime+'</td>';
            trHTML+='<td>'+v.source+'</td>';
            trHTML+='<td class="relative">'+v.action_url+'</td>';

            trHTML+='</tr>';
        });  
    }
    else
    {
        trHTML+='<tr>';
        trHTML+='<td colspan="10"> No record found';
        trHTML+='</td>';
        trHTML+='</tr>';
    }
    return trHTML;
}

$(document).on('click',".delete_order_listing",function(){
    var o_id = $(this).data('id');
    if(o_id!='')
    {
        swal({
            title: "",
            text: "Are you sure you want to delete this order! ",
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
                $.ajax({
                    type: 'POST',
                    url: './admin/orders/delete_order',
                    data: {o_id:o_id},
                    success: function(response)
                    {
                        if(response) {
                            $(".remove_"+o_id).remove();
                            toastr.success("Order deleted successfully", 'Success');
                        }
                        else {
                            toastr.warning("Invalid request try after sometime", 'Warning');
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


$('#pagination').on("click",function(){
    $('html, body').animate({scrollTop:100}, 'slow');
});
