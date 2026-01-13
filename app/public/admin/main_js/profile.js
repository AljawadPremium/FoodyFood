$(document).on("submit",".admin_add_edit",function(e)
{
    e.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./admin/profile_update",
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
                // setTimeout(function(){ location.reload(); }, 2000);
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
        $("#profile_image").on("change", function(e) {
            var files = e.target.files,
            filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $('.jquery_imge_preview').remove();  
                    $("<span class=\"jquery_imge_preview pip\">" +
                    "<img class=\"upload_img_dr\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "" +
                    "</span>").insertAfter("#profile_image");
                    $(".remove").click(function(){
                        $(this).parent(".pip").remove();
                    });
                });
                fileReader.readAsDataURL(f);
            }
          console.log(files);
        });
    } 
    else 
    {
        alert("Your browser doesn't support to File API")
    }
});