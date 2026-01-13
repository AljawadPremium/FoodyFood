<?php include(ROOTPATH."/app/Views/frontend/header_1.php"); ?>
<style type="text/css">
    .wishlist i {
    color: #ff802b;
}
.menu .active a{
    color: white!important;
}
</style>
<div class="<?php echo $container_class; ?>">
    <main class="main">
        <div class="page-header w_header" style="background-image: url('images/shop/page-header-back.jpg'); background-color: #3C63A4;">
            <h3 class="page-subtitle"></h3>
            <h1 class="page-title">Wishlist</h1>
        </div>
        <div class="page-content mb-10 pb-6">
            <div class="<?php echo $container_class; ?> wishlist_page">
                <div class="row gutter-lg main-content-wrap">
                    <div class="col-lg-12 main-content centerrr">
                        <?php if (empty($wishlist_data)): ?>
                        <style type="text/css">
                            .centerrr{text-align: center;}
                        </style>
                        <img class="empty_wish" src="https://i.pinimg.com/originals/f6/e4/64/f6e464230662e7fa4c6a4afb92631aed.png">
                        <?php endif ?>
                        <?php if (!empty($wishlist_data)): ?>
                        <div class="row cols-2 cols-sm-5 product-wrapper">
                            <?php foreach ($wishlist_data as $pkey => $pvalue): ?>
                            <div class="product-wrap">
                                <div class="product">
                                    <figure class="product-media">
                                        <a href="<?php echo base_url('product/'.$pvalue['id']) ?>">
                                        <img src="<?php echo $pvalue['product_image']; ?>" alt="product" width="280" height="315">
                                        </a>
                                        <div class="product-label-group">
                                            <label class="product-label label-new">new</label>
                                        </div>
                                        <div class="product-action-vertical">
                                            <?php if ($pvalue['price_select'] == '1' || $pvalue['price_select'] == '3'): ?>
                                            <a href="#" class="btn-product-icon btn-cart add_to_cart product_<?php echo $pvalue['id']; ?>" data-id="<?php echo $pvalue['id']; ?>" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                            <?php endif ?>
                                            <?php if ($pvalue['price_select'] == '2'): ?>
                                            <a href="javascript:void(0);" data-id="<?php echo $pvalue['id']; ?>" class="btn_quickview btn-product-icon btn-cart" data-toggle="modal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                            <?php endif ?>
                                            <?php 
                                                if ($pvalue['is_in_wish_list'] == '') {
                                                	$wclass = '';
                                                	$wicon = 'd-icon-heart';
                                                	$wtitle = 'Add to wishlist';
                                                }
                                                else
                                                {
                                                	$wtitle = 'Remove from wishlist';
                                                	$wclass = 'added';
                                                	$wicon = 'd-icon-heart-full';
                                                }
                                                ?>
                                            <a href="javascript:void(0);" class="btn-product-icon btn-wishlist <?php echo $wclass; ?>" title="<?php echo $wtitle; ?>" data-id="<?php echo $pvalue['id']; ?>" ><i class="<?php echo $wicon; ?>"></i></a>
                                        </div>
                                        <div class="product-action">
                                            <a data-id="<?php echo $pvalue['id']; ?>" class="btn-product btn-quickview btn_quickview" title="Quick View">Quick View</a>
                                        </div>
                                    </figure>
                                    <div class="product-details">
                                        <div class="product-cat">
                                            <a href="<?php echo base_url('category/'.$pvalue['category']) ?>"><?php echo $pvalue['category_name']; ?></a>
                                        </div>
                                        <h3 class="product-name">
                                            <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <span class="price">$<?php echo $pvalue['price']; ?></span>
                                        </div>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width:<?php echo $pvalue['avg_rating']*20; ?>%"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#" class="rating-reviews">( <span class="review-count"><?php echo $pvalue['user_rating_count']; ?></span>
                                            reviews
                                            )</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="bottom-block">
                    <section class="mt-5">
                        <h4 class="title title-custom title-center text-normal border-no mb-6">Top Categories</h4>
                        <div class="owl-carousel owl-theme cols-xl-6 cols-lg-4 cols-md-3 cols-2" data-owl-options="{
                            'nav': false,
                            'margin': 20,
                            'dots': true,
                            'loop': false,
                            'responsive': {
                            '1200': {
                            'items': 6
                            },
                            '992': {
                            'items': 4
                            },
                            '768': {
                            'items': 3
                            },
                            '0': {
                            'items': 2
                            }
                            }
                            }">

                            <?php if (!empty($c_listing)): ?>
                            <?php foreach ($c_listing as $key => $value): ?>
                            <div class="category category-icon">
                                <a href="<?php echo base_url('products/') ?><?php echo $value['id'] ?>">
                                    <figure class="categroy-media">
                                        <i class="<?php echo $value['category_icon'] ?>"></i>
                                    </figure>
                                    <div class="category-content">
                                        <h4 class="category-name font-weight-normal ls-normal"><?php echo $value['display_name'] ?></h4>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </section>
                    <section class="mt-10 pt-3 appear-animate">
		                <h4 class="title title-custom title-center text-normal border-no mb-6">Best of the week</h4>
		                <div class="owl-carousel owl-theme" data-owl-options="{
		                    'items': 4,
		                    'margin': 20,
		                    'nav': true,
		                    'dots': true,
		                    'loop': true,
		                    'responsive': {
		                    '0': {
		                    'nav': false,
		                    'items': 2
		                    },
		                    '768': {
		                    'items': 3
		                    },
		                    '992': {
		                    'items': 5
		                    }
		                    }
		                    }">
		                    <?php if (!empty($best_seller)): ?>
		                    <?php foreach ($best_seller as $pkey => $pvalue): ?>
		                    <div class="product shadow-media">
		                        <figure class="product-media">
		                            <a href="<?php echo base_url('product/'.$pvalue['id']) ?>">
		                            <img src="<?php echo $pvalue['product_image']; ?>" alt="product" width="280" height="315">
		                            </a>
		                            <div class="product-label-group">
		                                <label class="product-label label-new">new</label>
		                            </div>
		                            <div class="product-action-vertical">
		                                <?php if ($pvalue['price_select'] == '1' || $pvalue['price_select'] == '3'): ?>
		                                    <a href="#" class="btn-product-icon btn-cart add_to_cart product_<?php echo $pvalue['id']; ?>" data-id="<?php echo $pvalue['id']; ?>" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
		                                <?php endif ?>
		                                <?php if ($pvalue['price_select'] == '2'): ?>
		                                    <a href="javascript:void(0);" data-id="<?php echo $pvalue['id']; ?>" class="btn_quickview btn-product-icon btn-cart" data-toggle="modal" title="Add to cart"><i class="d-icon-bag"></i></a>
		                                <?php endif ?>
		                                <?php 
		                                    if ($pvalue['is_in_wish_list'] == '') {
		                                        $wclass = '';
		                                        $wicon = 'd-icon-heart';
		                                        $wtitle = 'Add to wishlist';
		                                    }
		                                    else
		                                    {
		                                        $wtitle = 'Remove from wishlist';
		                                        $wclass = 'added';
		                                        $wicon = 'd-icon-heart-full';
		                                    }
		                                ?>
		                                <a href="javascript:void(0);" class="btn-product-icon btn-wishlist <?php echo $wclass; ?>" title="<?php echo $wtitle; ?>" data-id="<?php echo $pvalue['id']; ?>" ><i class="<?php echo $wicon; ?>"></i></a>
		                            </div>
		                            <div class="product-action">
		                                <a data-id="<?php echo $pvalue['id']; ?>" class="btn-product btn-quickview btn_quickview" title="Quick View">Quick View</a>
		                            </div>
		                        </figure>
		                        <div class="product-details">
		                            <div class="product-cat">
		                                <a href="<?php echo base_url('category/'.$pvalue['category']) ?>"><?php echo $pvalue['category_name']; ?></a>
		                            </div>
		                            <h3 class="product-name">
		                                <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
		                            </h3>
		                            <div class="product-price">
		                                <span class="price">$<?php echo $pvalue['price']; ?></span>
		                            </div>
		                            <div class="ratings-container">
		                                <div class="ratings-full">
		                                    <span class="ratings" style="width:<?php echo $pvalue['avg_rating']*20; ?>%"></span>
		                                    <span class="tooltiptext tooltip-top"></span>
		                                </div>
		                                <a href="#" class="rating-reviews">( <span class="review-count"><?php echo $pvalue['user_rating_count']; ?></span>
		                                reviews
		                                )</a>
		                            </div>
		                        </div>
		                    </div>
		                    <?php endforeach ?>
		                    <?php endif ?>
		                </div>
		            </section>
                </div>
            </div>
        </div>
    </main>
</div>
<style type="text/css">
	a.wishlist-toggle {
    	color: red;
	}
</style>
<?php include(ROOTPATH."/app/Views/frontend/footer_1.php"); ?>
<script type="text/javascript">
	$(".dropdown.category-dropdown.has-border").removeClass("menu-fixed");
</script>