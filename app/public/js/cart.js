$(document).on("click", ".lang_change", function() {
    // Show confirmation dialog
    var lang = $(this).data("id");
    var userConfirmed = confirm("Are you sure you want to change the language?");

    // Proceed only if user confirms
    if (userConfirmed) {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: './change-language',
            data: { lang: lang },
            success: function(response) {
                $('#loading').hide();
                var response = $.parseJSON(response);
                if (response.status == true) { 
                    toastr.success(response.message, 'Success');
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    toastr.warning(response.message, 'Warning');
                }
            }
        });
    } else {
        // User clicked "No", do nothing
        return false;
    }
});




$('.search_header').val('');

var g_rating=0;
$(document).ready(function()
{

	$(document).on("click",".delete_cart_pro",function()
	{
		var pid = $(this).data("id");
		remove_me(pid);
	}); 

	$(document).on("click",".get_star",function(){
		var id=$(this).data('id');
		g_rating=id;
		$(".get_star").removeClass("theme-color");
		if(id==1)
		{
			$("#one").addClass('theme-color');   
		}else if(id==2)
		{
			$("#one").addClass('theme-color');   
			$("#two").addClass('theme-color');   
		}else if(id==3)
		{
			$("#one").addClass('theme-color');   
			$("#two").addClass('theme-color');   
			$("#three").addClass('theme-color');   
		}else if(id==4)
		{
			$("#one").addClass('theme-color');   
			$("#two").addClass('theme-color');   
			$("#three").addClass('theme-color');   
			$("#four").addClass('theme-color');   
		}else if(id==5)
		{
			$("#one").addClass('theme-color');   
			$("#two").addClass('theme-color');   
			$("#three").addClass('theme-color');   
			$("#four").addClass('theme-color');   
			$("#five").addClass('theme-color');   
		}else{
			swal("","Something Went wrong","warning");
		}   
	});

	$(document).on("submit","#rating_submit",function(e){
		e.preventDefault();
		var rating_name=$.trim($("#rating_name").val());
		var rating_email=$.trim($("#rating_email").val());
		var rating_review=$.trim($("#rating_review").val());
		var error=1;
		if(g_rating==0)
		{
			error=0;
			swal("","Please click on star","warning");
			return false;
		}
		if(rating_name=='')
		{
			error=0;
			swal("","Please enter your name","warning");
			return false;
		}

		if(rating_email=='')
		{
			error=0;
			swal("","Please enter your email","warning");
			return false;
		}
		if(rating_email!='')
		{
			if(!isValidEmailAddress(rating_email))
			{             
				error=0;                
				swal("","Please Enter Valid Email Id","warning");
				return false;
			}                  
		}

		if(rating_review=='')
		{
			error=0;
			swal("","Please enter your review","warning");
			return false;
		}
	  	// var formData = new FormData();
		formData = new FormData(this); 
		formData.append("rating", g_rating);
		if(error==1)
		{
			$('#loading').show(); 
			$.ajax({
				url: "./ajax/product-rating",
				type: "POST",
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
				success: function (response) {
					$('#loading').hide(); 
					if(response.status==true)
					{
						toastr.success(response.message,"Success");
						setTimeout(function(){ location.reload(); }, 1500);
					}else{
						toastr.warning(response.message,"Warning");
					}

				}
			});

		}
	}); 

	$(document).on("click",".clear_all_items",function(){
		swal({
			title: "Are you sure?",
			text: "You want to remove!",
			type:"warning",
			showCancelButton: true,
			confirmButtonText: "YES",
			cancelButtonText: "NO",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(inputValue){        
			if (inputValue===true) 
			{
				$('#loading').show();
				$.ajax({
					type: 'GET',
					url: "./cart/clear-all-items",
					dataType:"json",  
					success: function(response)
					{
						$('#loading').hide();
						if(response.status==true) {
							toastr.success(response.message,"Success");
							$(".hide_data").show();
							$(".hide_cart_div").hide();
							$(".c_total_div").hide();
							$(".cart-count").text(0);
						}
					}
				});
			} 
		});

	});

	$(document).on("keyup","#header_search_val",function(){
		var search_val=$(this).val();
	// if(search_val!='')
	// {
		$.ajax({
			type: 'POST',
			url: "./product/get-product-name",
			data: {'search':search_val},            
			success: function(response)
			{
				response=$.trim(response);
				var response = $.parseJSON(response);
				if(response.status==true)
				{
					$(".search-full").addClass("show");
				// $('#add_search_product').show();
					$("#add_search_product").html(response.data);
				}else{
				// $('#add_search_product').hide();
				}
			}
		});      
	// }
	});
});



function remove_cart(pid,flag='')
{  
	$('#loading').show();
	$.ajax({
		type: 'POST',  
		url: './add-to-wish-list',
		data: {pid:pid,is_wish:'0'},
		success: function(response)
		{
			$('#loading').hide();
			var response = $.parseJSON(response);
			if (response.status == true)
			{
				$(".wishlist"+pid).empty();
				$(".wishlist"+pid).addClass('btn-product btn-wishlist mr-6');
				$(".wishlist"+pid).attr("onclick","move_to_wish_list("+pid+")");
				app ='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
				$(".wishlist"+pid).append(app);
				toastr.success(response.message,"Success");

				$(".remove_pro"+pid).remove();
				var row_count = $('.row_count').length;
				if(row_count==0)
				{
					$(".hide_data").show();
					$(".hide_cart_div").hide();
				}
			}
			else
			{
				toastr.warning(response.message,"Warning");
			}
		}
	});     
} 

function move_to_wish_list(pid,flag='')
{ 
	$('#loading').show();  
	$.ajax({
		type: 'POST',
		url: "./add-to-wish-list",
		data: {pid:pid,is_wish:"1"},
		success: function(response)
		{
			$('#loading').hide();
			var response = $.parseJSON(response);
			if (response.status == true)
			{
				$(".wishlist"+pid).empty();
				// <a  class="wishlist wishlist<?php echo $pval['id']; ?>"  onclick="move_to_wish_list(<?php echo $pval['id']; ?>)"><i data-feather="heart"></i> </a>
				// $(".wishlist"+pid).addClass('wish_color');
				$(".wishlist"+pid).attr("onclick","remove_cart("+pid+")");
				app ='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
				$(".wishlist"+pid).append(app);

				toastr.success(response.message,"Success");
			}
			else
			{
				toastr.warning(response.message,"Warning");
			}    
		}
	});
}

function productQty(e)
{
	var op = jQuery(e).attr("data-symbol");
	var target = jQuery(e).attr("data-target");
	var pid = jQuery(e).attr("data-id");

	var minimum_add_to_cart = $(".minimum_a_t_c_"+pid).data('min');
	var increment_by = $(".minimum_a_t_c_"+pid).data('incremental_qty');
	var qty = $(".p_qty_"+target).val();

	// var tip_amount = $(".tip_value").val();

	var old_qty = qty;
	var newqty = qty;    

	var sale_price = parseFloat(jQuery(e).attr('data-sale-value'));
	price4 = parseFloat (jQuery('.total_sale_price').text());

	if (qty == minimum_add_to_cart && op == 'minus-btn') {
		remove_me(target); return false;
	}

	var status = true;
	if(op == 'minus-btn')
	{
		var added_count = $(".p_qty_"+target).val();
		if (added_count == minimum_add_to_cart) {
			var increment_by = minimum_add_to_cart;
		}
		var newqty = parseInt(added_count)-parseInt(increment_by);
		newqty = -increment_by;
		final_qty = parseInt(old_qty)-parseInt(increment_by);
	}
	else{
		newqty = increment_by;
		final_qty = parseInt(old_qty) + parseInt(increment_by);
	}

	if (status) {    
		$('#loading').show();
		$.ajax({
			type: 'POST',
			url: "./update-cart",
			data: {pid:pid,qty:newqty,append:target},
			success: function(response)
			{
				view_cart_count();
				$('#loading').hide(); 

				var response = $.parseJSON(response);
				if (response.message == 'quantity_not_avilable')
				{
					// alert('current'+qty);  
					toastr.warning("Not Enough Stock To Add Quantity","Warning");
					if(newqty==-1)
					{                      
						$("#"+target).val(qty-newqty);                      
						setTimeout(function(){ location.reload(); }, 2000);
					}
					else{                      
						$("#"+target).val(newqty-1);
					}
				}
				else if (response.message=='time_limit'){
					toastr.warning("Shope close please order between Sun-Thu... 11.30AM -11.30PM Fri-Sat....... 8:30AM â€“ 11:30PM ","Warning");
				}
				else if(response.message=='not_added_tocart'){
					toastr.warning("Product not found","Warning");
					setTimeout(function(){ location.reload('/en'); }, 2000);
				}
				else if(response.message=='product_deactive'){
					toastr.warning("This product is deactivated by admin it will remove form cart","Warning");
					setTimeout(function(){ remove_ok(target); }, 2000);                   
				}
				else if(response.message=='min_order')
				{
					$("#"+target).val(old_qty);
					toastr.warning(response.message2,"Warning");
				}
				else
				{
					var added_product_price = response.added_product_price;
					var p_total = parseInt(added_product_price) * parseInt(final_qty);
					$(".p_qty_"+target).val(final_qty);
					$(".aount_u_"+target).html("$"+p_total);

					$(".price_u_"+target).html("$"+added_product_price);

					var offer  = response.product_offer;
					if (offer) 
					{
						all_users = '';
	                    // all_users = '<div class="wrp_blk_ofr">';
						$.each(offer, function( index, value ) 
						{
							all_users += '<div class="singl_ofr_list singl_ofr_list_cart '+value['status']+'"  >';
							all_users += '<i class="fa fa-certificate" aria-hidden="true"></i>';

							var active_class = '';
							if (value['status'] == 'active') {
								var active_class = 'activ_ofer_pop';
							}

							all_users += '<span class="'+active_class+'">';
							all_users += ''+value['title']+'';
							all_users += '</span>';
							all_users += '<div class="clear"></div>';
							all_users += '</div>';
						});
	                    // all_users += '</div>';
						$('.offer_div_'+target).html(all_users);
					}

					jQuery('.total_sale_price').text(response.sub_total);
					jQuery('.shipping_amt').text(response.shipping_amount);
					jQuery('.tax_amount').text(response.tax_amount);

					// jQuery('.tip_amt').text(tip_amount);

					// alert(tip_amount);
					jQuery('.main_total').text(response.grand_total);
				}
			}
		});
	}        
}


function remove_me(pid,type='')
{
	var text = 'Do you want to remove this product from the cart?';
	var confirmButtonText = 'Yes';
	var cancelButtonText = 'CANCEL';

	swal({
		title: "",
		text: text,
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true,
		confirmButtonText: confirmButtonText,
		cancelButtonText: cancelButtonText,
	},
	function(){  
		$('#loading').show();
		remove_ok(pid,type);
	});
}

function remove_ok(pid,type='')
{
	if(pid!=''){
		$.ajax({
			type: 'POST',
			url: './remove-from-cart',
			data: {pid:pid,type:type},
			success: function(response)
			{
				$('#loading').hide();
				var response = $.parseJSON(response);
				if (response.status == true)
				{
					view_cart_count();
					if(type=="view-menu")
					{
						$("#drop_view_cart").html(response.data.html_tag);
						swal("Deleted", response.message, "success");
					}else{
						jQuery('.total_sale_price').text(response.sub_total);
						jQuery('.shipping_amt').text(response.shipping_amount);
						jQuery('.tax_amount').text(response.tax_amount);
            			// jQuery('.coupon_amount').text(response.coupon_amount);
						jQuery('.main_total').text(response.grand_total);            

						swal({
							type: 'success',
							title: 'Deleted',
							text: response.message,
							showConfirmButton: false,
							timer: 2000
						});

						$(".remove_pro_"+pid).remove();
						var row_count = $('.row_count').length;
						if(row_count==0)
						{
							$(".hide_data").show();
							$(".hide_cart_div").hide();
							$(".c_total_div").hide();
						}
					}
				}                
			}
		});      
	}
	else
	{
		swal("","Something went wrong","warning");
	}
}
