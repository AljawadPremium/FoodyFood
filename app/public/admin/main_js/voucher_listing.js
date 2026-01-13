$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".coupon_listing").css({"color": "white"});
});

var table = $('#v_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(".edit").click(function ()
{
    $('#loading').show();
    $('.error_show').html("");
    $('.modal-title').html("Edit Coupon");
    var id = $(this).data("id");
    if (id) 
    {
        $.ajax({
            type: 'POST',
            url: "./ajax/get_coupon_data/"+id,
            // data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true)
                {
                    $("#code").val(response.data.code);
                    $("#start_date").val(response.data.start_date);
                    $("#end_date").val(response.data.end_date);
                    $("#amount").val(response.data.amount);
                    $("#min_amount_to_apply").val(response.data.min_amount_to_apply);
                    $("#description").val(response.data.description);
                    $("#private_coupon").val(response.data.private_coupon);
                    $("#max_discount").val(response.data.max_discount);
                    $("#title").val(response.data.title);

                    if (response.data.type != 'percent') 
                    {
                        $("#max_discount").val("");
                        $(".max_order").css({"display":"none"}); 
                    }
                    else
                    {
                        $(".max_order").css({"display":"block"}); 
                    }

                    if (response.data.status) 
                    {
                        $('.ce_status option:selected').removeAttr('selected');
                        $('.ce_status option[value='+ response.data.status +']').attr("selected", "selected");
                    }
                    if (response.data.type) 
                    {
                        $('#type option:selected').removeAttr('selected');
                        $('#type option[value='+ response.data.type +']').attr("selected", "selected");
                    }

                    if (response.data.city_id) 
                    {
                        $('#city_id option:selected').removeAttr('selected');
                        $('#city_id option[value='+ response.data.city_id +']').attr("selected", "selected");
                    }
                    if (response.data.use_type) 
                    {
                        $('#use_type option:selected').removeAttr('selected');
                        $('#use_type option[value='+ response.data.use_type +']').attr("selected", "selected");
                    }

                    if (response.data.payment_method) 
                    {
                        $('#payment_method option:selected').removeAttr('selected');
                        $('#payment_method option[value='+ response.data.payment_method +']').attr("selected", "selected");
                    }
                    if (response.data.private_coupon) 
                    {
                        $('#private_coupon option:selected').removeAttr('selected');
                        $('#private_coupon option[value='+ response.data.private_coupon +']').attr("selected", "selected");
                    }
                    
                    $("<span class=\"coupon_id\">" +
                        "<input  type='hidden' value="+ response.data.id +" id='vid'> " +
                        "" +
                        "</span>").insertAfter("label.error_show.code");

                    $("#voucher_model").modal("show");
                }
                else
                {
                    // $('.error_show').html(response.message);
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }    
});

$('#type').on('change', function() {
    var value =  this.value ;
    if (value == 'percent') 
    {
        $(".max_order").css({"display":"block"});
    }
    else
    {
        $("#max_discount").val("");
        $(".max_order").css({"display":"none"}); 
    }
});



$(".model_btnn").click(function ()
{
    $("#voucher_model").modal("show");
    $('.error_show').html("");
    $('.coupon_form').trigger("reset");
    $("#vid").val('');
    $('.modal-title').html("Create new coupon");
    $('.coupon_id').remove();  
    $("#code").val('');
    $("#start_date").val('');
    $("#end_date").val('');
    $("#amount").val('');
    $("#min_amount_to_apply").val('');
    $("#description").val('');
    $("#vid").val('');
    $("#title").val('');
});

$(".close_modal").click(function ()
{
    $("#voucher_model").modal("hide");
});


$(document).on("submit",".coupon_form",function(e)
{
    $('.error_show').html("");
    var code = $("#code").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var status = $(".ce_status").val();
    var payment_method = $("#payment_method").val();
    var type = $("#type").val();
    var amount = $("#amount").val();
    var min_amount_to_apply = $("#min_amount_to_apply").val();
    var city_id = $("#city_id").val();
    var description = $("#description").val();
    var coupon_id = $("#vid").val();

    var error = 1;    
    if(code==''){
        $(".code").html('Please enter code name');
        error = 0;
    }else{$(".code").html('');}

    if (start_date) 
    {
        if(end_date==''){
            $(".end_date").html('Please enter end date');
            error = 0;
        }else{$(".end_date").html('');}

        var fromdate = new Date($("#start_date").val()); //Year, Month, Date
        var todate = new Date($("#end_date").val()); //Year, Month, Date

        if (todate < fromdate) 
        {
            swal('',"End date must be greater than start date",'warning');
            error = 0;
            return false;
        }
        else if (start_date == end_date) 
        {
            swal('',"Please change end date because start date and end date must be different",'warning');
            error=0;
            return false;
        }        
    }

    if(status==''){
        $(".status").html('Please enter status');
        error = 0;
    }else{$(".status").html('');}

    if(payment_method==''){
        $(".payment_method").html('Please select payment method');
        error = 0;
    }else{$(".payment_method").html('');}

    if(type==''){
        $(".type").html('Please select type');
        error = 0;
    }else{$(".type").html('');}

    if(amount==''){
        $(".amount").html('Please enter discount amount');
        error = 0;
    }else{$(".amount").html('');}
    
    if (coupon_id == undefined) 
    {
        var coupon_id = 'add';
    }

    e.preventDefault();
    if(error==1)
    {
        if (type == 'flat') 
        {
            if (amount > 100 )
            {
                swal('',"Flat amount must be less than 100 Rs. ",'warning');
                error=0;
                return false;
            }
        }

        if (type == 'percent') 
        {
            if (amount >= 100 )
            {
                swal('',"Percentage amount must be less than 100% ",'warning');
                error=0;
                return false;
            }  
        }

        $('.error_show').html("");
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./ajax/add_edit_voucher/"+coupon_id,
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
                    $('.coupon_form').trigger("reset");
                    toastr.success(response.message, 'Success');
                    $("#voucher_model .close").click();
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});



$(document).on('click',".detete_coupon",function(){
    var cid = $(this).data('id');
    if(cid!='')
    {
      swal({
            title: "",
            text: "Are you sure you want to delete this coupon?",
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
                    url: './ajax/delete_coupon',
                    data: {cid:cid},
                    success: function(response)
                    {
                        if(response)
                        {
                            toastr.success("Coupon Deleted successfully", 'Success');
                            $(".coupon_"+cid).remove();
                            // setTimeout(function(){ location.reload(); }, 2000);
                        }
                        else
                        {
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