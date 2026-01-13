$(document).on("submit","#edit_profile",function()
{
    event.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./my_account/edit",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(response)
        {
            var response = $.parseJSON(response);
            $('#loading').hide();
            if(response.status==true)
            {
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

/* Preview Image before Upload */
var loadFile = function(event) 
{
    var output = document.getElementById('image_preview');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() 
    {
        URL.revokeObjectURL(output.src) // free memory
    }
};



/* NEWSLETTER */
$(document).on("submit","#newsletter_submit",function(e)
{
    e.preventDefault();
    $("#loading").show();
    $.ajax({
        type: 'POST',
        url: "./my_account/newsletter",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response)
        { 
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true){
                $('#newsletter_submit').trigger("reset");
                toastr.success(response.message, 'Success');
            }
            else{
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});


/*Password Show on change pass page*/
$(document).ready(function() 
{
    
    $('.button-old-psswd').on('click', function() {
        
        if ($('#old_pass').attr('psswd-shown') == 'false') 
        {            
            $('#old_pass').removeAttr('type');
            $('#old_pass').attr('type', 'text');
            
            $('#old_pass').removeAttr('psswd-shown');
            $('#old_pass').attr('psswd-shown', 'true');
            
            $('.button-old-psswd').html('<i class="fa fa-eye-slash m-l5">');
            
        }else {
            
            $('#old_pass').removeAttr('type');
            $('#old_pass').attr('type', 'password');
            
            $('#old_pass').removeAttr('psswd-shown');
            $('#old_pass').attr('psswd-shown', 'false');

            $('.button-old-psswd').html('<i class="fa fa-eye m-l5">');
        }        
    });
});

$(document).ready(function() 
{
    
    $('.button-new-psswd').on('click', function() {
        
        if ($('#new_pass').attr('psswd-shown') == 'false') 
        {
            $('#new_pass').removeAttr('type');
            $('#new_pass').attr('type', 'text');
            
            $('#new_pass').removeAttr('psswd-shown');
            $('#new_pass').attr('psswd-shown', 'true');
            
            $('.button-new-psswd').html('<i class="fa fa-eye-slash m-l5">');
            
        }else {
            
            $('#new_pass').removeAttr('type');
            $('#new_pass').attr('type', 'password');
            
            $('#new_pass').removeAttr('psswd-shown');
            $('#new_pass').attr('psswd-shown', 'false');

            $('.button-new-psswd').html('<i class="fa fa-eye m-l5">');
        }        
    });
});

$(document).ready(function() 
{
    
    $('.conf_button-psswd').on('click', function() {
        
        if ($('#con_password').attr('psswd-shown') == 'false') 
        {
            $('#con_password').removeAttr('type');
            $('#con_password').attr('type', 'text');
            
            $('#con_password').removeAttr('psswd-shown');
            $('#con_password').attr('psswd-shown', 'true');
            
            $('.conf_button-psswd').html('<i class="fa fa-eye-slash m-l5">');
            
        }else {
            
            $('#con_password').removeAttr('type');
            $('#con_password').attr('type', 'password');
            
            $('#con_password').removeAttr('psswd-shown');
            $('#con_password').attr('psswd-shown', 'false');

            $('.conf_button-psswd').html('<i class="fa fa-eye m-l5">');
        }        
    });
});


/*Add address*/

$(".edit_address").click(function ()
{
    $('.button_value').val("Edit Address");
    var id = $(this).data("id");
    if (id) 
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./my_account/get_address_data/"+id,
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
                    $(".f_name").val(response.data.first_name);
                    $(".l_name").val(response.data.last_name);
                    $(".a_email").val(response.data.email);
                    $(".a_phone").val(response.data.phone);
                    $(".a_address").val(response.data.address);
                    $(".a_landmark").val(response.data.landmark);
                    $(".a_state").val(response.data.state);
                    $(".a_postcode").val(response.data.postcode);
                    $(".a_city").val(response.data.city);
                    if (response.data.city_id) 
                    {
                        $('.a_city option:selected').removeAttr('selected');
                        $('.a_city option[value='+ response.data.city_id +']').attr("selected", "selected");
                    }

                    $(".edit_id").remove();
                    $(".user_name_adres").css({"backgroundColor":"transparent"});
                    $(".user_name_adres div").css({"color":"#666"});
                    $(".address_"+id+" .user_name_adres").css({"backgroundColor":"#e9e9e9"});
                    $(".address_"+id+" .user_name_adres div").css({"color":"black"});
                    $("<input type='hidden' value="+ response.data.id +" name = 'edit_id' class = 'edit_id'>").insertAfter(".f_name");
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
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
                url: './my_account/delete_address',
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

$(document).on("submit","#address_create",function()
{
    event.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./my_account/address",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(response)
        {
            var response = $.parseJSON(response);
            $('#loading').hide();
            if(response.status==true)
            {
                toastr.success(response.message, 'Success');
                var edit = $(".edit_id").val();
                if (edit == undefined) 
                {
                    $('#address_create')[0].reset();
                    setTimeout(function(){window.location.reload();}, 2000);
                }
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});


/*Change password*/

$(document).on("submit","#change_pass",function()
{
    event.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./my_account/cng_pass",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(response)
        {
            var response = $.parseJSON(response);
            $('#loading').hide();
            if(response.status==true)
            {
                $('#change_pass')[0].reset();
                toastr.success(response.message, 'Success');
            }
            else if(response.status==false)
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

/*Order History page cancel order*/
$(document).on('click',".cancel_order",function(){
    var o_id  = $(this).data('id');
    if(o_id!='')
    {
        swal({
          title: "Are you sure !",
          text: "You want to cancel this order:",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          animation: "slide-from-top",
          inputPlaceholder: "Please add reason why you want to cancel order"
        },
        function(inputValue){
          if (inputValue === null) return false;
          
            if (inputValue === "") {
                swal.showInputError("Please add reason !");
                return false
            }
            else if (inputValue != "") 
            {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: './my_account/order_cancel',
                    data: {o_id:o_id,reason:inputValue},
                    success: function(response)
                    {
                        swal.close();
                        $('#loading').hide();
                        var response = $.parseJSON(response);
                        if (response.status == true)
                        {
                            $('.calcel_'+o_id).html('canceled');
                            $('.hide_'+o_id).hide();
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

$("#search_me").keyup(function(e)
{
    var str = $("#search_me").val();
    var search_category = $(".search_category").val();
    var kc = e.keyCode;
    if (kc >= 37 && kc <= 40) 
    {
      return true;
    }
        
    $.ajax({
        type: 'POST',
        url: "./ajax/search_assets",
        data: {string:str,search_category:search_category,language:'en'},
        success: function(response){
            var data = jQuery.parseJSON(response);
            
            if (typeof data !== 'undefined' && data.length > 0) 
            {
                var drop_down_optn = '';
                $.each( data, function( key, value ) {
                  // alert( key + ": " + value );
                  drop_down_optn += value;
                });
                $('.items').show();
                $(".items").html(drop_down_optn);
                // $("#YOUR_CONTAINER_SELECTOR").css("height", "150px");
                // $("#YOUR_CONTAINER_SELECTOR").css("overflow-y", "scroll");
            }
            else{
              $('.items').hide();
            }
        }
    });
});


$(document).on('click',".user_logut",function(){
        swal({
            title: "",
            text: "Are you sure you want to logout?",
            type:"warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(inputValue){
            if (inputValue===true) 
            {
                $('#loading').show();
                setTimeout(function(){ window.location = './logout'}, 1000);
            } 
    });
    
});


$("#search_me1").keyup(function(e)
{
    var str = $("#search_me1").val();
    var search_category = $(".search_category").val();
    var kc = e.keyCode;
    if (kc >= 37 && kc <= 40) 
    {
      return true;
    }
        
    $.ajax({
        type: 'POST',
        url: "./ajax/search_assets",
        data: {string:str,search_category:search_category,language:'en'},
        success: function(response){
            var data = jQuery.parseJSON(response);
            
            if (typeof data !== 'undefined' && data.length > 0) 
            {
                var drop_down_optn = '';
                $.each( data, function( key, value ) {
                  // alert( key + ": " + value );
                  drop_down_optn += value;
                });
                $('#YOUR_CONTAINER_SELECTOR1').show();
                $("#YOUR_CONTAINER_SELECTOR1").html(drop_down_optn);
            }
            else{
              $('#YOUR_CONTAINER_SELECTOR1').hide();
            }
        }
    });
});