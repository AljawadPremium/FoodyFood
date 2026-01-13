<input type="hidden" value="<?php echo en_de_crypt($p_data[0]['id']); ?>" class="pid">
<style type="text/css">
	#header-sticky .row.align-items-center{
		background: #f9f9f9 !important;
		height: 102px;
	}
</style>
<section class="prdct_list bd-page__banner-area include-bg page-overlay" data-background="<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg" style="background-image: url(&quot;<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg&quot;);">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="bd-page__banner-content text-center">
					<h2>
						Create Review
					</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<form class="ratingsubmit">
	<div class="container center_div">
		<div class="row">
			<div class="col-sm-12">
				<input type="hidden" name="rating" class="rating_count">
				<input type="hidden" name="order_id" value="<?php echo @$_GET['v']; ?>">
				<p>
					<img style="padding: 6px;border-radius: 10px;width:100px;" src="<?php echo base_url('public/admin/products/') ?>/<?php echo $p_data[0]['product_image'] ?>" alt="product thumbnail" width="110" height="123">
					<a href="<?php echo base_url('product/') ?><?php echo $p_data[0]['id'] ?>"><?php echo $p_data[0]['product_name'] ?></a>
					<a href="<?php echo base_url('product/') ?><?php echo $p_data[0]['id'] ?>" class="btn btn-link btn-underline btn-primary back_detail"> Back to detail <i class="fa fa-arrow-right"></i></a>
				</p>
				<div class="col-md-12">
					<label for="rating" class="text-dark"><b>Overall rating</b> * </label>
					<div class="rating_div">
						<span onclick="setRating(1)">☆</span>
						<span onclick="setRating(2)">☆</span>
						<span onclick="setRating(3)">☆</span>
						<span onclick="setRating(4)">☆</span>
						<span onclick="setRating(5)">☆</span>
					</div>
				</div>
				<div class="col-md-12">
					<label for="rating" class="text-dark"><b>Title</b> * </label>
					<input name="title" class="form-control mb-4" placeholder="Review Title" required>
					<label for="rating" class="text-dark"><b>Add a written review</b> * </label>
					<textarea name="comment" id="reply-message" cols="30" rows="6" class="form-control mb-4" placeholder="What did you like or dislike? What did you use this product for? *" required></textarea>
					<div class="review-medias">
						<label for="rating" class="text-dark"><b>Add a photo or video</b></label>
					</div>
					<p>Upload images. Maximum count: 2, size: 2MB</p>
					<div class="row">
						<div class="col-sm-6">
							<input name="image" id="ImageMedias" class="form-control" type='file' accept="image/png, image/gif, image/jpeg"/>
							<div id="divImageMediaPreview"></div>
						</div>
						<div class="col-sm-6">
							<input id="ImageMedias_1" name="image1" class="form-control" type='file' accept="image/png, image/gif, image/jpeg"/>
							<div id="divImageMediaPreview_1"></div>
						</div>
					</div>
					<button type="submit" class="btn btn-success btn-rounded">Submit<i class="d-icon-arrow-right"></i></button>
					<div class="clear append_msg"></div>
				</div>
			</div>
		</div>
	</div>
</form>
<br>
<style type="text/css">
	.post-title{
		margin-bottom:0px;
	}
	.center_div
	{
		list-style: none;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	#ImageMedias_1
	{
		margin-bottom: 10px;
	}
	.product-media img {
		filter: brightness(90%);
	}
	.category-dropdown.has-border .dropdown-box {
		z-index: 999999;
	}
	.btn-primary.btn-link {
		background-color: transparent;
		color: #ff802b;
	}
	.back_detail {
		float: right;
		margin-top: 20px;
		margin-right: 20px;
	}
	.rating_div span {
		font-size: 25px;
		cursor: pointer;
	}
	.text-dark {
		color: #222 !important;
	}
	img.rating_upload_img {
		/* width: 100%; */
		margin-top: 10px;
		border: 1px solid #cdcdcd;
		border-radius: 5px;
		height: 100px;
		margin-bottom: 10px;
	}
</style>