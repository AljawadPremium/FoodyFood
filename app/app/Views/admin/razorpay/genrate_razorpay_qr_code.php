<div id="popup">
    <div class="popup-container">
        <div class="popup">
            <div class="close-popup" id="closeBtn"><a href="javascript:void(0);">X</a></div>
            <a class="popup-btn"></a>
            <div class="add_qr_code"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).on("click","#clickBtn",function()
{
    $('.add_qr_code').html("");
    $('.popup-btn').html("Please wait we are fetching QR code.");

    var did = $(this).data("id");
    $("#loading").show();
    $.ajax({
        type: 'POST',
        url: "./admin/razorpay/orders/get_qr/"+did,
        success: function(response)
        { 
            $('#loading').hide();
            var response = $.parseJSON(response);
            if (response.status == true)
            {
                var html = '<img class = "double img-thumbnail" src="'+response.image+'" title="image..."/>';
                $('.add_qr_code').html(html);
                $('.popup-btn').html("Once the payment is completed successfully. Please refresh the page so you can see the payment was successful");
                $("#popup").css({"display": "block"});
                // $(".qr_mode").css({"color": "black", "display": "block"});
                // toastr.success(response.message, 'Success');
            }
            else
            {
                $('.popup-btn').html(response.message);
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});

$(document).on("click","#closeBtn",function()
{
    const popup = document.getElementById("popup");
    popup.style.display = 'none';
}); 
</script>

<style type="text/css">
    @media  (min-width: 350px) and (max-width: 740px)  { 
        .popup
        {
            width: 100%!important;
        }
    }

    .popup-btn
    {
        text-align: center;
        width: 85%;
        display: block;
        margin-bottom: 10px;
        color: red;
        font-size: 14px;
        margin-top: 0px;
    }
    .add_qr_code {
        text-align: center;
    }
    img.double.img-thumbnail {
        /* width: 100%; */
        height: 600px;
    }

    #popup{
        display: none;
    }
    .popup-container{
        height: 100vh;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        background-color: rgb(96 95 127 / 70%);
        position: absolute;
        top: 0;
        left: 0;
        z-index: 9999999;
    }
    .popup{
        background-color: #ffffff;
        padding: 20px 30px;
        width: 40%;
        border-radius: 15px;
        z-index: 99999;
    }
    .close-popup{
        display: flex;
        justify-content: flex-end;
        width: 10%;
        float: right;
    }
    .close-popup a{
        font-size: 1.2rem;
        background-color: rebeccapurple;
        color: #fff;
        padding: 5px 10px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 10px;
        display: inline-block;
    }

    #clickBtn
    {
        cursor: pointer;
    }
</style>

<script type="text/javascript">
    /*const clickBtn = document.getElementById("clickBtn");
    const popup = document.getElementById("popup");
    const closeBtn = document.getElementById("closeBtn");

    clickBtn.addEventListener('click', ()=>{
        popup.style.display = 'block';
    });
    closeBtn.addEventListener('click', ()=>{
        popup.style.display = 'none';
    });
    popup.addEventListener('click', ()=>{
        popup.style.display = 'none';
    });*/
</script>