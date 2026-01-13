$(document).on("submit","#admin_login_form",function(e)
{
    e.preventDefault();
    var error=1;
    $('.error_show').html("");
    if(error==1)
    {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "./login",
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
                    $(".login-button").prop("disabled", true);
                    $('.error_show').html(response.message);
                    $(".error_show").css({"position": "relative","top":"-15px", "color":"green","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    toastr.success(response.message, 'Success');
                    setTimeout(function(){ location.reload(); }, 1500);
                }
                else
                {
                    $(".error_show").css({"position": "relative","top":"-15px", "color":"red","font-weight":"bold","font-family":"fangsong","font-size":"15px"});
                    $('.error_show').html(response.message);
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    }
});

Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function (e) {
    Array.from(e.querySelectorAll(".password-addon")).forEach(function (r) {
        r.addEventListener("click", function (r) {
            var o = e.querySelector(".password-input");
            "password" === o.type ? (o.type = "text") : (o.type = "password");
        });
    });
});
