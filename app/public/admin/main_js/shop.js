$("document").ready(function() { 
    $(".shop_tab").trigger('click');
    $(".shop_add").css({"color": "white"});
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
    var shop_id = $('.shop_id').val();
    e.preventDefault();
    var error=1;
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_shop",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true) {
                    if (shop_id == '') {
                        $('.m_name').val('');
                    }
                    toastr.success(response.message, 'Success');
                    // setTimeout(function(){ location.reload(); }, 1500);
                }
                else {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});