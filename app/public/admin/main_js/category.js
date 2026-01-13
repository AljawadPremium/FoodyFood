$("document").ready(function() { 
    $(".category_tab").trigger('click');
    $(".category_add").css({"color": "white"});
});


$(document).on("submit",".add_subcategory",function(e)
{
    e.preventDefault();
    var error=1;
    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_subcategory",
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
                    $(".showImage").css("background-image", "url()");
                    $('.m_name').val('');
                    $('.cat_img').val('');

                    $('.error_show').html(response.message);
                    $(".error_show").css({"position": "relative","top":"0px", "color":"green","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 1500);
                }
                else
                {
                    $(".error_show").css({"position": "relative","top":"0px", "color":"red","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    $('.error_show').html(response.message);
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});

$(document).on("submit",".edit_subcategory",function(e)
{
    var edit_sub_id = $('.edit_sub_id').val();
    e.preventDefault();
    var error=1;
    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/edit_subcategory/"+edit_sub_id,
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
                    $('.error_show').html(response.message);
                    $(".error_show").css({"position": "relative","top":"6px", "color":"green","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 1500);
                }
                else
                {
                    $(".error_show").css({"position": "relative","top":"6px", "color":"red","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    $('.error_show').html(response.message);
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});


$(function() {
    $(".cat_img").on("change", function()
    {
        $(".showImage").html('');

        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader();  // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $(".showImage").css("background-image", "url("+this.result+")");
            }
        }
    });
});


$(document).on("submit",".add_main_cat",function(e)
{
    e.preventDefault();
    var error=1;
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_category",
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
                    $('.m_name').val('');
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 1500);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});

$(document).on("submit",".edit_main_cat",function(e)
{
    var category_id = $('.category_id').val();
    e.preventDefault();
    var error=1;
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/category/edit/"+category_id,
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
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 1500);
                }
                else
                {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});