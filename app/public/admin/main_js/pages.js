$("document").ready(function() { 
    $(".setting_tab").trigger('click');
    $(".pages_listing").css({"color": "white"});

    var pages_id = $('.pages_id').val();
    if (pages_id) {
        $(".showImage").css("display", "block");
    }
    else {
        $(".showImage").css("display", "none");
    }
});



$(document).on("submit",".add_pages",function(e)
{
    e.preventDefault();
    var error=1;
    var pages_id = $('.pages_id').val();

    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "admin/add_pages",
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
                    if (pages_id == '') {
                        $(".showImage").css("display", "none");
                        $(".showImage").css("background-image", "url()");
                        $('.add_pages').trigger("reset");
                    }

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



$(function() {
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
                $(".showImage").css("position", "absolute");
            }
        }
    });
});