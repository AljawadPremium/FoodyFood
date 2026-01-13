<style type="text/css">
    #header-sticky .row.align-items-center{
        background: #f9f9f9 !important;
    }
</style>
<main>
    <section class="prdct_list bd-page__banner-area include-bg page-overlay" data-background="<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg" style="background-image: url(&quot;<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg&quot;);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bd-page__banner-content text-center">
                        <h2>
                            <?php echo $cat_name; ?>
                        </h2>
                        <div class="breadcrumb_area_centr breadcrumb-area pt-10 pb-10">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="breadcrumb__list">
                                            <span><a href="<?php echo base_url(''); ?>"><?php echo lang('Validation.Home'); ?></a></span>
                                            <span><i class="fa-regular fa-angle-right"></i></span>
                                            <span><?php echo lang('Validation.Product Listing'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop-area-start -->
    <section class="bd-shop__area pt-110 pb-85">
        <div class="container">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-8">
                    <div class="bd-sidebar__widget-warpper mb-60">
                        <div class="bd-product__filters">
                            <div class="bd-filter__widget child-content-hidden">
                                <h4 class="bd-filter__widget-title drop-btn"><?php echo lang('Validation.Categories') ?></h4>
                                <div class="bd-filter__content">
                                    <div class="bd-product__check">
                                        <input type="hidden" class="cat_id_selected">
                                        <ul>
                                            <?php if (!empty($cat_listing)): ?>
                                            <?php foreach ($cat_listing as $ckey => $cvalue): ?>
                                            <li>
                                                <input class="cat_input_check check-input" type="checkbox" id="s-<?php echo $cvalue['id']; ?>" value="<?php echo $cvalue['id']; ?>">
                                                <label class="check-label" for="s-<?php echo $cvalue['id']; ?>"><?php echo $cvalue['display_name']; ?></label>
                                            </li>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="bd-filter__widget child-content-hidden">
                                <h4 class="bd-filter__widget-title drop-btn"><?php echo lang('Validation.Price') ?></h4>
                                <div class="bd-filter__price">
                                    <div class="slider-range">
                                        <div class="slider-range-bar"></div>
                                        <p>
                                            <label for="s-amount">Price :</label>
                                            <input type="text" id="s-amount" class="amount" readonly>
                                            <span><?php echo lang('Validation.Filter') ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bd-filter__widget child-content-hidden">
                                <h4 class="bd-filter__widget-title drop-btn"><?php echo lang('Validation.Ratings') ?></h4>
                                <div class="bd-filter__content">
                                    <div class="bd-singel__rating">
                                        <input type="hidden" class="rating_selected">
                                        <input value="5" class="pro_radio_btn radio-box" type="radio" id="s-st-1" name="rating">
                                        <label class="radio-star" for="s-st-1">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <span class="radio-item"></span>
                                        </label>
                                    </div>
                                    <div class="bd-singel__rating">
                                        <input value="4" class="pro_radio_btn radio-box" type="radio" id="s-st-2" name="rating">
                                        <label class="radio-star" for="s-st-2">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <span class="radio-item"></span>
                                        </label>
                                    </div>
                                    <div class="bd-singel__rating">
                                        <input value="3" class="pro_radio_btn radio-box" type="radio" id="s-st-3" name="rating">
                                        <label class="radio-star" for="s-st-3">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <span class="radio-item"></span>
                                        </label>
                                    </div>
                                    <div class="bd-singel__rating">
                                        <input value="2" class="pro_radio_btn radio-box" type="radio" id="s-st-4" name="rating">
                                        <label class="radio-star" for="s-st-4">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <span class="radio-item"></span>
                                        </label>
                                    </div>
                                    <div class="bd-singel__rating">
                                        <input value="1" class="pro_radio_btn radio-box" type="radio" id="s-st-5" name="rating">
                                        <label class="radio-star" for="s-st-5">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <i class="fa-light fa-star"></i>
                                        <span class="radio-item"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="bd-filter__widget child-content-hidden">
                                <div class="bd-filter__content">
                                    <a href="<?php echo base_url('products'); ?>">
                                        <div class="bd-flash___banner-item p-relative">
                                            <div class="bd-flash__banner-thumb w-img">
                                                <img src="<?php echo base_url('public/frontend/img/'); ?>/trending/flash/flash-banner-01.jpg" alt="flash-banner">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8 col-lg-8">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="bd-top__filter-search p-relative mb-30">
                                <form class="bd-top__filter-input" action="#">
                                    <input class="search_product_input" type="text" placeholder="<?php echo lang('Validation.Search keyword') ?>...">
                                    <button><i class="fa-regular fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="bd-filter__tab-inner mb-30">
                                <div class="bd-top__filter">
                                    <div class="bd-Product__tab pl-5">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <input type="hidden" class="view_product" >
                                                <button class="view_check_pot nav-link active" id="home-tab" data-bs-toggle="tab"
                                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                                    aria-selected="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15.001"
                                                        viewBox="0 0 15 15.001">
                                                        <path id="Path_12058" data-name="Path 12058"
                                                            d="M-1362.125-3804a.626.626,0,0,1-.625-.625v-2.5a.626.626,0,0,1,.625-.625h2.5a.625.625,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm-5.624,0a.626.626,0,0,1-.626-.625v-2.5a.626.626,0,0,1,.626-.625h2.5a.625.625,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm-5.625,0a.625.625,0,0,1-.625-.625v-2.5a.625.625,0,0,1,.625-.625h2.5a.625.625,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm11.249-5.625a.626.626,0,0,1-.625-.625v-2.5a.626.626,0,0,1,.625-.625h2.5a.626.626,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm-5.624,0a.626.626,0,0,1-.626-.625v-2.5a.626.626,0,0,1,.626-.625h2.5a.626.626,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm-5.625,0a.625.625,0,0,1-.625-.625v-2.5a.626.626,0,0,1,.625-.625h2.5a.626.626,0,0,1,.625.625v2.5a.625.625,0,0,1-.625.625Zm11.249-5.625a.626.626,0,0,1-.625-.625v-2.5a.626.626,0,0,1,.625-.626h2.5a.626.626,0,0,1,.625.626v2.5a.625.625,0,0,1-.625.625Zm-5.624,0a.626.626,0,0,1-.626-.625v-2.5a.627.627,0,0,1,.626-.626h2.5a.626.626,0,0,1,.625.626v2.5a.625.625,0,0,1-.625.625Zm-5.625,0a.625.625,0,0,1-.625-.625v-2.5a.626.626,0,0,1,.625-.626h2.5a.626.626,0,0,1,.625.626v2.5a.625.625,0,0,1-.625.625Z"
                                                            transform="translate(1374 3819)" fill="#777" />
                                                    </svg>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="view_check_land nav-link" id="shop-filter-bar" data-bs-toggle="tab"
                                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                                    aria-selected="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17.3" height="15"
                                                        viewBox="0 0 17.3 15">
                                                        <path id="Path_12057" data-name="Path 12057"
                                                            d="M-2514-4232a1.5,1.5,0,0,1,1.5-1.5,1.5,1.5,0,0,1,1.5,1.5,1.5,1.5,0,0,1-1.5,1.5A1.5,1.5,0,0,1-2514-4232Zm6.179,1.328a1.236,1.236,0,0,1-1.236-1.235,1.236,1.236,0,0,1,1.236-1.236h9.885a1.235,1.235,0,0,1,1.236,1.236,1.235,1.235,0,0,1-1.236,1.235ZM-2514-4238a1.5,1.5,0,0,1,1.5-1.5,1.5,1.5,0,0,1,1.5,1.5,1.5,1.5,0,0,1-1.5,1.5A1.5,1.5,0,0,1-2514-4238Zm6.179,1.15a1.236,1.236,0,0,1-1.236-1.235,1.236,1.236,0,0,1,1.236-1.236h9.885a1.235,1.235,0,0,1,1.236,1.236,1.235,1.235,0,0,1-1.236,1.235ZM-2514-4244a1.5,1.5,0,0,1,1.5-1.5,1.5,1.5,0,0,1,1.5,1.5,1.5,1.5,0,0,1-1.5,1.5A1.5,1.5,0,0,1-2514-4244Zm6.179.971a1.236,1.236,0,0,1-1.236-1.235,1.236,1.236,0,0,1,1.236-1.236h9.885a1.235,1.235,0,0,1,1.236,1.236,1.235,1.235,0,0,1-1.236,1.235Z"
                                                            transform="translate(2514 4245.5)" fill="#777" />
                                                    </svg>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="bd-sort__type-filter">
                                    <select class="sorting-list sort_by" name="orderby" id="sorting-list">
                                        <option value="id,DESC" selected="selected"><?php echo lang('Validation.Most Popular') ?></option>
                                        <option value="id,ASC"><?php echo lang('Validation.Latest') ?></option>
                                        <option value="sale_price,asc"><?php echo lang('Validation.Sort forward price low') ?></option>
                                        <option value="sale_price,desc"><?php echo lang('Validation.Sort forward price high') ?></option>
                                        <option value=""><?php echo lang('Validation.Clear custom sort') ?></option>
                                    </select>
                                </div>
                                <div class="bd-sort__type-filter">
                                    <select class="count_show sorting-list" name="count_show" id="sorting-list">
                                        <option value="15" selected><?php echo lang('Validation.Count Show') ?> 15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                        <option value="60">60</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="bd-shop__wrapper">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="bd-trending__item-wrapper">
                                            <div class="append_search_data row">
                                                
                                                <?php if (empty($info_data)): ?>
                                                    <p><?php echo lang('Validation.No record found') ?></p>
                                                <?php endif ?>

                                                <?php if (!empty($info_data)): ?>
                                                <?php foreach ($info_data as $pkey => $pvalue): ?>
                                                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="bd-trending__item mb-45 text-center">
                                                        <div class="bd-trending__product-thumb">
                                                            <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img class="img_listing" src="<?php echo $pvalue['product_image']; ?>" alt="product-img"></a>
                                                            <div class="bd-product__action">
                                                                <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="bd-trending__content">
                                                            <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                            <h4 class="bd-product__title">
                                                                <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                            </h4>
                                                            <div class="bd-product__price">
                                                                <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span>
                                                                <span class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php endforeach ?>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xxl-12">
                            <?php if ($info_data): ?>
                            <nav class="toolbox toolbox-pagination">
                                <p class="show-info"><?php echo $msg; ?></p>
                                <?php echo $pagination_link; ?>
                            </nav>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop-area-ende -->
</main>

<style type="text/css">
/* Pagination Container */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

/* Pagination List Items */
.pagination li {
    margin: 0 5px;
}

/* Pagination Links */
.pagination li a {
    display: block;
    padding: 10px 15px;
    font-size: 16px;
    font-weight: bold;
    color: #007bff;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Hover Effect */
.pagination li a:hover {
    background-color: #007bff;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

/* Active Page */
.pagination li.active a {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
    pointer-events: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(0);
}

/* Disabled Pagination Links */
.pagination li.disabled a {
    color: #6c757d;
    background-color: #e9ecef;
    border-color: #dee2e6;
    pointer-events: none;
    opacity: 0.6;
}

/* Next and Last Buttons */
.pagination li a[aria-label="Next"],
.pagination li a[aria-label="Last"] {
    background-color: #ffffff;
    color: #007bff;
}

.pagination li a[aria-label="Next"]:hover,
.pagination li a[aria-label="Last"]:hover {
    background-color: #007bff;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .pagination li a {
        padding: 8px 12px;
        font-size: 14px;
    }
}

</style>