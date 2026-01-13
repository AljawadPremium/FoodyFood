$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".building_add").css({"color": "white"});
});

var table = $('#building_listing').DataTable({
    pageLength : 10,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
});

$(document).on("submit",".building_form",function(e)
{
    var building_name = $(".b_name").val();
    var building_id = $("#building_id").val();

    var error = 1;    
    if(building_name=='') {
        $(".error_show").html('* Please enter building name');
        return false;
    }else{$(".b_name").html('');}
    
    if (building_id == undefined || building_id == '') {
        var building_id = 'add';
    }

    e.preventDefault();
    $('.error_show').html('');
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/setting/building_c_edit/"+building_id,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            $('.error_show').html(response.message);

            if (response.status == true) {

                if (building_id == 'add') {
                    $(".b_name").val('');
                }

                toastr.success(response.message, 'Success');
                setTimeout(function(){ location.reload(); }, 2000);
            }
            else {
                toastr.warning(response.message, 'Warning');
            }
        }
    }); 
});

$(document).on("click",".edit_building",function()
{
    $('.building_modal').html("Edit building");
    $('.error_show').html("");
    var id = $(this).data("id");
    if (id) 
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./setting/get_building_data/"+id,
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
                    $("#id01").css({"display": "block"});

                    $(".b_name").val(response.data.building_name);
                    if (response.data.status) 
                    {
                        $('option[value=' + response.data.status + ']').attr('selected',true);
                    }
                    
                    $("<input type='hidden' value="+ response.data.id +" id='building_id'>").insertAfter(".b_name");
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }    
});

$(document).on("click","#add_building",function()
{
    $('.building_modal').html("Add New building");
    $('.error_show').html("");
    $(".b_name").val("");   
});


$(document).on("click",".add_wing",function()
{
    var building_id = $(this).data("id");
    var building_name = $(this).data("name");

    $('.wing_modal').html("Add new wing for - "+building_name);
    $('.append_building_id').val(building_id);
    $('.e_show').html("");
    $(".w_name").val("");   
});

$(document).on("submit",".wing_form",function(e)
{
    var wing_name = $(".w_name").val();
    var wing_id = $(".append_wing_id").val();

    var error = 1;    
    if(wing_name=='') {
        $(".error_show").html('* Please enter building name');
        return false;
    }else{$(".w_name").html('');}
    
    if (wing_id == undefined || wing_id == '') {
        var wing_id = 'add';
    }

    e.preventDefault();
    $('.error_show').html('');
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/setting/wing_c_edit/"+wing_id,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            $('.error_show').html(response.message);

            if (response.status == true) {

                if (wing_id == 'add') {
                    $(".w_name").val('');
                }

                toastr.success(response.message, 'Success');
                setTimeout(function(){ location.reload(); }, 2000);
            }
            else {
                toastr.warning(response.message, 'Warning');
            }
        }
    }); 
});

$(document).on("click",".edit_wing",function()
{
    $('.wing_modal').html("Edit wing");
    $('.error_show').html("");
    var id = $(this).data("id");
    if (id) 
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./setting/get_wing_data/"+id,
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
                    $("#id02").css({"display": "block"});

                    $(".w_name").val(response.data.wing_name);
                    $(".append_building_id").val(response.data.building_id);
                    if (response.data.status) 
                    {
                        $('option[value=' + response.data.status + ']').attr('selected',true);
                    }
                    
                    $("<input type='hidden' value="+ response.data.id +" class='append_wing_id'>").insertAfter(".w_name");
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }    
});


$(document).on('click',".delete_building",function()
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
                url: './setting/delete_building',
                data: {b_id:b_id},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        $("#building_listing").DataTable().rows($(".banner_"+b_id)).remove()
                        $("#building_listing").DataTable().draw();

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

$(document).on('click',".delete_wing",function()
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
                url: './setting/delete_wing',
                data: {b_id:b_id},
                success: function(response)
                {
                    $('#loading').hide();
                    var response = $.parseJSON(response);
                    if (response.status == true)
                    {
                        $(".w_l_"+b_id).remove();
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
