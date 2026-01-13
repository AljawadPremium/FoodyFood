$(".dropdown.category-dropdown.has-border").removeClass("menu-fixed");


function setRating(rating) {
	$('.rating_count').val(rating);
	let stars = document.querySelectorAll('.rating_div span');
	stars.forEach((star, index) => {
		star.style.color = index < rating ? 'gold' : 'gray';
	});
}

$("#ImageMedias").change(function () {
	if (typeof (FileReader) != "undefined") {
		var dvPreview = $("#divImageMediaPreview");
		dvPreview.html("");            
		$($(this)[0].files).each(function () {
			var file = $(this);                
			var reader = new FileReader();
			reader.onload = function (e) {
				var img = $("<img />");
				img.attr("class", "rating_upload_img");
					// img.attr("style", "width: 150px; height:100px; padding: 10px");
				img.attr("src", e.target.result);
				dvPreview.append(img);
			}
			reader.readAsDataURL(file[0]);                
		});
	} else {
		alert("This browser does not support HTML5 FileReader.");
	}
});

$("#ImageMedias_1").change(function () {
	if (typeof (FileReader) != "undefined") {
		var dvPreview = $("#divImageMediaPreview_1");
		dvPreview.html("");
		$($(this)[0].files).each(function () {
			var file = $(this);                
			var reader = new FileReader();
			reader.onload = function (e) {
				var img = $("<img />");
				img.attr("class", "rating_upload_img");
					// img.attr("style", "width: 150px; height:100px; padding: 10px");
				img.attr("src", e.target.result);
				dvPreview.append(img);
			}
			reader.readAsDataURL(file[0]);                
		});
	} else {
		alert("This browser does not support HTML5 FileReader.");
	}
});

$(document).on("submit",".ratingsubmit",function()
{
	var pid = $(".pid").val();

    event.preventDefault();
    $('#loading').show();
    $.ajax({
        type: 'POST',
        url: "./product/review/"+pid,
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
            	$('.append_msg').html(response.message);
                toastr.success(response.message, 'Success');
            }
            else
            {
                toastr.warning(response.message, 'Warning');
            }
        }
    });
});