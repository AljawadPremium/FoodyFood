$( document ).ready(function()
{
    $("#instock").click(function()
    {
        $('#stock').val('1');
        $("#stock").prop( "disabled", false );
    });

    $("#notinstock").click(function()
    {         
        $('#stock').val('0');
        $("#stock").prop( "disabled", true );
    });
});

$("#stock").change(function()
{
    var num = parseInt($('#stock').val());
    if (num < 1)
    {
        $('#stock').val('1');
        swal('','Stock quantity should be greater than zero.');
    }
});


jQuery(function () {
    jQuery("select").chosen({no_results_text: "Oops, nothing found!",allow_single_deselect: true}); 
});


$(document).on('click', 'input[type="checkbox"]', function() {      
    $('input[type="checkbox"]').not(this).prop('checked', false);      
});
    
$(document).on("change","#price_select",function()
{
    Price_flag=$(this).val();
    if(Price_flag==2)
    {
        $(".hss_price").hide();
        $(".hsm_price").show();
        $(".shattbute").show();
    }else if(Price_flag==1)
    {
        $(".hsm_price").hide();
        $(".shattbute").hide();
        $(".hss_price").show();
    }else{
        $(".shattbute").hide();
        $(".hsm_price").hide();
        $(".hss_price").hide();
    }
});


$(document).on("change",".get_shop",function()
{
    var product_id = $('.product_id').val();
    shop_id = $(this).val();

    $.ajax({
        type: 'POST',
        url: "./admin/get_category_shop_wise",
        data: {shop_id:shop_id,product_id:product_id},
        success: function(response)
        {
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                $('#main_category').html(response.option);
                $('#main_category').trigger("chosen:updated");

                if (product_id == '') {
                }
                // toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});




$(document).on("submit",".product_add_edit",function(e)
{
        var product_name=$(".product_name").val();
        var sku=$(".sku").val();
        var stock=$("#stock").val();
        var short_description=$(".short_description").val();
        var main_category=$("#main_category").val();
        var ckeditor10=$("#ckeditor10").val();
        var price_select=$("#price_select").val();

        var error=1;    
        if(product_name=='') {
            toastr.warning("Please enter product name", 'Warning');
            return false;
        }
        if(sku=='') {
            // toastr.warning("Please enter sku", 'Warning');
            // return false;
        }
        if(short_description=='')
        {
            toastr.warning("Please enter short description", 'Warning');
            return false;
        }

        if(main_category=='0')
        {
            toastr.warning("Please select category", 'Warning');
            return false;
        }

        if(stock=='')
        {
            toastr.warning("Please enter quantity in Stock", 'Warning');
            return false;
        }

        if(ckeditor10=='')
        {
            toastr.warning("Please enter description", 'Warning');
            return false;
        }
 
        if(price_select==0)
        {
            toastr.warning("Please select price", 'Warning');
            return false;
        }
      
        if(Price_flag==1)
        {
            var price=$("#price").val();  
            var sale_price=$("#sale_price").val();
            if(price=='')
            {
                toastr.warning("Please enter price", 'Warning');
                return false;
            }  
            if(sale_price=='')
            {
                toastr.warning("Please enter sale price", 'Warning');
                return false;
            }    
        }
        else if(Price_flag==2)
        {
            var select_size20=$("#select_size20").val();
            if(select_size20==null)
            {
                toastr.warning("Please select size", 'Warning');
                return false;
            }
        }


        e.preventDefault();
        var error=1;
        var product_id = $('.product_id').val();

        var a_url = "./admin/product/add";

        if (product_id) {
            var a_url = "./admin/product/edit/"+product_id;
        }

        // alert(product_id);
        // alert(a_url);
        // return false;

        $('.error_show').html("");
        if(error==1)
        {
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: a_url,
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
                        if (product_id == '') {
                            $(".showImage").css("display", "none");
                            $(".showImage").css("background-image", "url()");
                            $('.product_add_edit').trigger("reset");
                        }

                        $('.error_show').html(response.message);
                        $(".error_show").css({"display": "block","top":"0px", "color":"green","margin-bottom":"10px"});
                        toastr.success(response.message, 'Success');
                        // setTimeout(function(){ location.reload(); }, 1500);
                    }
                    else
                    {
                        $(".error_show").css({"display": "block","top":"0px", "color":"red","margin-bottom":"10px"});
                        $('.error_show').html(response.message);
                        toastr.warning(response.message, 'Warning');
                    }
                }
            });
        }
});


$(".ban_img").on("change", function()
{    
    $(".showImage").html('');
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader();  // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file
        reader.onloadend = function(){ // set image data as background of div
            $(".showImage").css("background-image", "url("+this.result+")");
            $(".showImage").css("display", "block");
            $(".showImage").css("margin-bottom", "5px");
        }
    }
});


$("document").ready(function() { 
    $(".product_tab").trigger('click');
    $(".product_add").css({"color": "white"});
});



/*Multiple images*/

var image_gallery_g = '';
var index_g = 2;

$(document).on("change",".image_check",function()
{
    var class_name=$(this).data("class");      
    // file = this.files[0];
    files = this.files;
    if(files.length>0)
    {
        for(i=0; i<files.length; i++ )
        {
            // console.log(file);
            var imagefile = files[i].type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                alert("Please select a valid image file (JPEG/JPG/PNG)");
                return false;
            } 
            else 
            {
                image_gallery_arr = image_gallery_g.split(',');
                // alert(image_gallery_arr.length);
                if(image_gallery_arr.length>24)
                {
                    swal("","You can upload only 24 image","warning");
                    return false;
                }   

                fd = new FormData();

                individual_capt = "Product image";
                fd.append("caption", individual_capt);  
                fd.append('action', 'fiu_upload_file'); 
                fd.append("file", this.files[i]);
                fd.append("path", 'public/admin/products/');
                fd.append("count", i+1);
                $("#loading").show();
                jQuery.ajax({
                    type: 'POST',
                    url: './product/uploadFiless',
                    data: fd,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response)
                    {
                        // alert(response);
                        $("#loading").hide();
                        var response = $.parseJSON(response);
                        var status = response.status;
                        var response = response.img_name;

                        if(status == false)
                        {
                            swal("","Something went wrong, Please try again...","warning");
                        }
                        else
                        {
                            if(image_gallery_g=='')
                            {
                                image_gallery_g=response;
                            }else{
                                image_gallery_g=image_gallery_g + ',' + response;
                            }
                            image_gallery_arr = image_gallery_g.split(',');
                            if(image_gallery_arr.length==1)
                            {
                                // jQuery('.galryim_pop').prepend('<div  class="singl_upded_img"> <img id="first_img" class="blah" src="../assets/admin/product/'+response+'">  </div>');   
                            }
                            jQuery('.prepend_img').append('<input type="hidden" name="gallery_images[]" value="'+response+'"> <div id="pic'+index_g+'" data-name="'+response+'" class="multipl_car_div site-upload-img"><img src="./public/admin/products/'+response+'" class="img_multpl_img" > <div class="clear" ></div> <ul style="font-size: 18px;"> <li><div class="zoom_multpl_img" data-name="'+response+'" data-toggle="modal" data-target="#zoom_img_as" > <i class="fa fa-search-plus" aria-hidden="true"></i></div></li> <li><div class="delet_multpl_img"><i class="fa fa-trash" aria-hidden="true" onclick="remove_pic(\''+index_g+'\',\''+',' + response+'\')"></i> </div> </ul> <div class="clear" ></div> </div>');  
                            index_g = parseInt(index_g) + 1;
                        }
                    }
                });
            }
        }
    }
});

function remove_pic(id,name)
{
    swal({
        title: "Are you sure?",
        text: "You want to remove this Gallery image",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
    },
    function()
    {
        $("#loading").show();
        swal("Deleted!", "Product gallery image removed successfully", "success");
        image_gallery_g = image_gallery_g.replace(name,'');
        image_gallery_arr=image_gallery_g.split(',');
        if(image_gallery_arr.length==1)
        {
            image_gallery_g=','+image_gallery_g;
        }

        jQuery('#pic'+id).remove();
        jQuery('.pic'+id).remove();
        // var url='<?php echo base_url('/assets/admin/product/') ?>'+response.first_image;
        var url= '';
        // $("#first_img").attr("src",url);
        $("#loading").hide();
    });
}

$(document).on("click",".zoom_multpl_img",function(){
    var image_name=$(this).attr('data-name');
    var url='./public/admin/products/'+image_name;
    $("#modal_img").attr("src",url);
    $('#zoom_img_as').modal('show');
})


$('.add_btn_extra').click(function() {
    $('.extra_records').clone().appendTo('.add_extra_for_product');
    $('.add_extra_for_product .extra_records').addClass('single remove');
    $('.single .add_btn_extra').remove();
    $('.single').append('<a href="#" class="remove_extra btn-remove-customer">Remove Fields</a>');
    $('.add_extra_for_product > .single').attr("class", "remove");

    $('.add_extra_for_product input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        count++;
    });

});

$(document).on('click', '.remove_extra', function(e) {
    $(this).parent('.remove').remove();
    e.preventDefault();
});
$(document).on('click', '.remove_added_extra', function(e) {
    $(this).parent('.remove').remove();
    e.preventDefault();
});