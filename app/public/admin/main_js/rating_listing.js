$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".rating_listing").css({"color": "white"});
});

var table = $('#v_listing').DataTable({
    pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(".edit").click(function ()
{
    $('#loading').show();
    $('.error_show').html("");
    $('.modal-title').html("Edit");
    var id = $(this).data("id");
    if (id) 
    {
        $.ajax({
            type: 'POST',
            url: "./ajax/get_rating_data/"+id,
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
                    $(".ce_title").val(response.data.title);
                    $(".ce_comment").val(response.data.comment);

                    if (response.data.status){
                        $('.ce_status option:selected').removeAttr('selected');
                        $('.ce_status option[value='+ response.data.status +']').attr("selected", "selected");
                    }
                    if (response.data.pid){
                        $('.ce_pid option:selected').removeAttr('selected');
                        $('.ce_pid option[value='+ response.data.pid +']').attr("selected", "selected");
                    }
                    if (response.data.uid){
                        $('.ce_uid option:selected').removeAttr('selected');
                        $('.ce_uid option[value='+ response.data.uid +']').attr("selected", "selected");
                    }
                    if (response.data.rating) {
                        $('.ce_rating option:selected').removeAttr('selected');
                        $('.ce_rating option[value='+ response.data.rating +']').attr("selected", "selected");
                    }
                    
                    $("<span class=\"c_id\">" +
                        "<input  type='hidden' value="+ response.data.id +" id='vid'> " +
                        "" +
                        "</span>").insertAfter(".ce_form .modal-body");

                    $("#ce_model").modal("show");
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }    
});


$(".model_btnn").click(function ()
{
    $("#ce_model").modal("show");
    $('.error_show').html("");
    $('.modal-title').html("Create new coupon");

    $('.ce_form').trigger("reset");

    $("#vid").val('');
    $('.c_id').remove();  

    // $(".ce_title").val('');
    // $(".ce_comment").val('');
});

$(".close_modal").click(function (){
    $("#ce_model").modal("hide");
});

$(".c_modal").click(function (){
    $("#ce_model").modal("hide");
});


$(document).on("submit",".ce_form",function(e)
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
    var c_id = $("#vid").val();

    var error = 1;
    if (c_id == undefined){
        var c_id = 'add';
    }

    e.preventDefault();
    if(error==1)
    {
        $('.error_show').html("");
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./ajax/add_edit_rating/"+c_id,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true){
                    $('.ce_form').trigger("reset");
                    toastr.success(response.message, 'Success');
                    $("#ce_model .close").click();
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



$(document).on('click',".detete_tr",function(){
    var cid = $(this).data('id');
    if(cid!='')
    {
        swal({
            title: "",
            text: "Are you sure you want to delete?",
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
                    url: './ajax/delete_rating',
                    data: {cid:cid},
                    success: function(response)
                    {
                        if(response)
                        {
                            toastr.success("Rating Deleted successfully", 'Success');
                            $(".rating_"+cid).remove();
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