<?php 
    $currency = '$';
    $acc_holder_name = $admin_data[0]['first_name'].' '.$admin_data[0]['last_name'];
?>
<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Welcome</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                            <!-- <li class="breadcrumb-item active"></li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">
                                        <?php $time = date("H");
                                            $timezone = date("e");
                                            if ($time < "12") { echo "Good morning";} 
                                            else if ($time >= "12" && $time < "17") { echo "Good afternoon"; } 
                                            else if ($time >= "17" && $time < "19") { echo "Good evening"; } 
                                            elseif ($time >= "19") { echo "Good night";} ?>,
                                        <?php echo $acc_holder_name; ?>!
                                    </h4>
                                    <p class="text-muted mb-0">Here's what's happening with your dashboard today.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Sales - Day
                                            </p>
                                            <div class="widget-subheading"><i class="custome_date fa fa-calendar" aria-hidden="true"></i>
                                            <span class="sales_day"></span></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 sales_day_no">
                                            <span class="counter-value" data-target="100"></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Sales - Month
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="sales_month fa fa-calendar" aria-hidden="true"></i>
                                                <span class="sal_month"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 sales_month_no">
                                            <span class="counter-value" data-target="100"></span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Sales - Total
                                            </p>
                                            <span style="margin-top: 29px;display: block;"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between" style="position: absolute;left: 15px;top: 40px;">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 total_s_no">
                                            <span class="counter-value" data-target="100"></span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Delivered order
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="delivered_order fa fa-calendar" aria-hidden="true"></i>
                                                <span class="del_order"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 delivered_no">
                                            <span class="counter-value" data-target="100"></span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Canceled order
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="canceled_order fa fa-calendar" aria-hidden="true"></i>
                                                <span class="canc_order"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 canceled_no">
                                            <span class="counter-value" data-target="100"></span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Pending order
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="pending_order fa fa-calendar" aria-hidden="true"></i>
                                                <span class="pend_order"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0 pending_no">
                                            <span class="counter-value" data-target="100"></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Customers
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="total_cus fa fa-calendar" aria-hidden="true"></i>
                                                <span class="t_cus"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary m-0">
                                            <span class="counter-value customer_no">
                                                <span class="counter-value" data-target="100"></span>
                                            </span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                Total Orders
                                            </p>
                                            <div class="widget-subheading">
                                                <i class="total_order fa fa-calendar" aria-hidden="true"></i>
                                                <span class="to_order"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <h4 class="fs-22 fw-semibold ff-secondary total_order_no">
                                            <span class="counter-value" data-target="100"></span> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Undelivered Orders</h4>
                                </div>

                                <div class="card-body">
                                    <div class="chart-holder">
                                        <div class="table">
                                            <table id="dashboard_order_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Name</th>
                                                        <th>phone</th>
                                                        <th>Payment</th>
                                                        <th>Amount</th>
                                                        <th>Order status</th>
                                                        <th>Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                    <?php if (!empty($un_orders)): ?>
                                                    <?php foreach ($un_orders as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value['order_master_id']; ?></td>
                                                        <td>
                                                            <?php $out = mb_strimwidth($value['name'], 0, 13, "..."); ?>
                                                            <a href="<?php echo base_url('admin/orders/view/') ?><?php echo $value['order_id']; ?>" target="_blank"><?php echo $out; ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $value['mobile_no']; ?></td>
                                                        <td>
                                                            <?php
                                                            $color = 'badge-primary';
                                                            if ($value['payment_status'] == 'Unpaid')
                                                            {
                                                            $color = 'badge-warning';
                                                            }
                                                            ?>
                                                            <label class="mb-0 badge <?php echo $color ?>">
                                                                <?php echo $value['payment_status']; ?>
                                                            </label>
                                                        </td>
                                                        <td><?php echo $currency; ?> <?php echo $value['net_total']; ?></td>
                                                        <td><?php echo $value['order_status']; ?></td>
                                                        <td><?php echo mb_strimwidth($value['order_datetime'] , 0, 11, ""); ?></td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Check Month/Yearwise Sold / Unsold Product Count</h4>
                                </div>

                                <div class="card-body">
                                    <div class="chart-holder">
                                        <div class="table">
                                            <form method="get" class="row">
                                        <div class="col-sm-3">
                                            <p class="pt-0 text-uppercase fw-medium text-muted text-truncate mb-0 pb-1">Year Listing</p>

                                            <?php $year_listing[0] = date("Y",strtotime("-0 year")); ?>
                                            <?php $year_listing[1] = date("Y",strtotime("-1 year")); ?>
                                            <?php $year_listing[2] = date("Y",strtotime("-2 year")); ?>
                                            <select class="form-control" name="year" >
                                                <?php if ($year_listing): ?>
                                                <?php foreach ($year_listing as $skey => $vaslue): ?>
                                                    <option <?php if($year=== $vaslue) echo 'selected="selected"';?> value="<?php echo $vaslue; ?>"><?php echo $vaslue; ?></option>
                                                <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="pt-0 text-uppercase fw-medium text-muted text-truncate mb-0 pb-1">Month Listing</p>
                                            <?php $year_listing[0] = date("Y",strtotime("-0 year")); ?>
                                            <?php $year_listing[1] = date("Y",strtotime("-1 year")); ?>
                                            <?php $year_listing[2] = date("Y",strtotime("-2 year")); ?>
                                            <select class="form-control" name="month" >
                                                <option value="0">Select Month</option>
                                                <?php for($i = 1 ; $i <= 12; $i++) {
                                                $amonth =  date("F",strtotime(date("Y")."-".$i."-01")); ?>
                                                <option <?php if($month == $i) { echo "selected = 'selected' ";} ?> value="<?php echo $i; ?>"><?php echo $amonth; ?></option>';
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="pt-0 text-uppercase fw-medium text-muted text-truncate mb-0 pb-1">Type</p>
                                            <select class="form-control" name="type" >
                                                <option <?php if($type=== 'sold') echo 'selected="selected"';?> value="sold">Sold Product</option>
                                                <option <?php if($type=== 'not_sold') echo 'selected="selected"';?> value="not_sold">Not Sold Product</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input style="margin-top: 23px;" type="submit" value="Submit" class="ad-btn form-control">
                                        </div>
                                    </form>
                                    <br>
                                    <table id="dashboard_un_sold_listing" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <!-- <th>Month</th> -->
                                                <th>Product name</th>
                                                <th>Sell Count</th>
                                                <th>Product id</th>
                                                <th>Year & Month</th>
                                                <!-- <th>Month name</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            <?php if ($top_sold_monthwise): ?>
                                            <?php foreach ($top_sold_monthwise as $skey => $vsalue): ?>
                                            <tr>
                                                <!-- <td><?php echo $vsalue['month']; ?></td> -->
                                                <td><?php echo $vsalue['product_name']; ?></td>
                                                <td><?php echo $vsalue['count']; ?></td>
                                                <td><?php echo $vsalue['product_id']; ?></td>
                                                <td><?php echo $vsalue['month_name']; ?>/<?php echo $vsalue['year']; ?></td>
                                                <!-- <td><?php echo $vsalue['month_name']; ?></td> -->
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Top selling products</h4>
                                </div>

                                <div class="card-body">
                                    <div class="chart-holder">
                                        <div class="row">
                                            <?php if (!empty($top_selled)): ?>
                                            <?php foreach ($top_selled as $tkey => $tvalue): ?>
                                            <div class="col-xl-2 col-md-3 col-sm-3 mb-10">
                                                <div class="grid_card_dashboard">
                                                    <div class="label_1">
                                                        <div>Sold : <?php echo $tvalue['pro_count']; ?></div>
                                                    </div>
                                                    <div class="center_100">
                                                        <a target="_blank" href="<?php echo base_url('admin/product/edit/') ?><?php echo en_de_crypt($tvalue['product_id']); ?>">
                                                            <img style="height: 80px;margin-top: 10px;border-radius: 60px" src="<?php echo $tvalue['p_image']; ?>" onerror="this.src='https://6valley.6amtech.com/public/assets/back-end/img/160x160/img2.jpg'" alt="<?php echo $tvalue['product_name']; ?>">
                                                            <span class="center_100_span"><?php echo mb_strimwidth($tvalue['product_name'] , 0, 15, "..."); ?>
                                                            </span>
                                                        </a>
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

                    <div class="row" style="display:none;">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Top customer</h4>
                                </div>

                                <div class="card-body">
                                    <div class="chart-holder">
                                        <div class="row">
                                            <?php if (!empty($top_customer)): ?>
                                            <?php foreach ($top_customer as $tkey => $tvalue): ?>
                                            <div class="col-xl-2 col-md-3 col-sm-3 mb-10">
                                                <div class="grid_card_dashboard">
                                                    <div class="label_1">
                                                        <div>Orders : <?php echo $tvalue['order_count']; ?></div>
                                                        <div>Amt : <?php echo $currency; ?> <?php echo round($tvalue['total_sum']); ?></div>
                                                    </div>
                                                    <div class="center_100">
                                                        <a target="_blank" href="<?php echo base_url('admin/customer/view/') ?><?php echo en_de_crypt($tvalue['user_id'] ?? ''); ?>">
                                                            <span class="top_customer">
                                                                <img src="<?php echo $tvalue['logo']; ?>" onerror="this.src='<?php echo base_url('public/admin/empty.png') ?>'" alt="<?php echo $tvalue['fname']; ?>">
                                                            </span>
                                                            <span class="center_100_span">
                                                                <?php echo mb_strimwidth($tvalue['fname'] , 0, 15, "..."); ?>
                                                            </span
                                                            >
                                                        </a>
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

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Total Revanue</h4>
                                </div>

                                <div class="card-body">
                                    <div class="chart-holder">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="chart-holder">
                                                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .align-items-end {
    position: absolute;
    text-align: right;
    right: 20px;
    top: 25px;
    }
</style>
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/buttons.dataTables.min.css">

<script src="<?php echo base_url();?>/public/admin/main_js/dashboard.js"></script>

<script type="text/javascript">
window.onload = function () 
{
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        animationEnabled: true, // change to true      
        title:{
            text: ""
        },
        data: [
        {
            // Change type to "column","bar", "area", "spline", "pie",etc.
            type: "spline",
            dataPoints: [
                <?php echo $chart_data; ?>
            ]
        }
        ]
    });
    chart.render();
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>