<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/buttons.dataTables.min.css">

<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboards</a></li>
                            <li class="breadcrumb-item active">Payment Link</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0"><a href="javascript:void(0);" onclick="openModal()" >Create New Link</a></h4>
                            </div>
                            <div class="card-body">
                                
                                <table id="example_25" class="table table-striped table-bordered dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Id</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Amount</th>
                                            <th style="width: 30%;">Message</th>
                                            <th>Link</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($p_data)): ?>
                                        <?php foreach ($p_data as $key => $value): ?>
                                        
                                        <tr>
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['name']; ?></td>
                                            <td><?php echo $value['mobile']; ?></td>
                                            <td>$ <?php echo $value['amount']; ?> </td>
                                            <td>
                                                <p style="margin-top: 3px;" class="more"><?php echo $value['message']; ?></p>
                                                
                                            </td>
                                            <td><?php echo $value['payment_url']; ?></td>
                                            <td><?php echo $value['created_date']; ?></td>
                                            <td><?php echo $value['response_status']; ?></td>
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
    </div>
</div>

<div class="modal" id="payment_link_model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h4 class="modal-title">Create new link</h4>
                <button type="button" class="close clost_btn" onclick="closeModal()">&times;</button>
            </div>
            <form class="payment_link_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="col-form-label">Customer name</label>
                            <input class="form-control" type="text" placeholder="Customer name" id="name" name="name" required>
                            <label class="error_show name"></label>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Mobile number</label>
                            <input class="form-control" type="number" placeholder="Mobile number" id="mobile" name="mobile" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                            <label class="error_show mobile"></label>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Email</label>
                            <input class="form-control" type="email" placeholder="Email address" id="email" name="email">
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Amount</label>
                            <input class="form-control" type="number" placeholder="Enter amount" id="amount" name="amount" required>
                            <label class="error_show amount"></label>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Message</label>
                            <textarea  class="form-control" type="text" placeholder="message" id="message" name="message"></textarea>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            <button type="submit" class="btn-primary" style="border: 1px solid;padding: 5px;width: 15%;">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("document").ready(function() { 
        $(".setting_tab").trigger('click');
        $(".payment_link_add").css({"color": "white"});
    });
</script>
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/razorpay_payment_link_listing_create.js"></script>