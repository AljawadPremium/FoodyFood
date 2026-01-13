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
						Payment fail
					</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<main>
	<section class="cart-area pt-110 pb-130">
		<div class="container small-container">
			<div class="row">
				<div class="col-12">

					<?php if (empty($card_total)): ?>
						<p>Payment cancelled successfully kindly try again</p>
					<?php endif ?>
				</div>
			</div>
		</div>
	</section>
</main>