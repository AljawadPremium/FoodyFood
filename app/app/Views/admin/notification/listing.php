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
                            <li class="breadcrumb-item active">Notification listing</li>
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
                                <h4 class="card-title mb-0">Fire Notification</h4>
                            </div>
                            <div class="card-body">
                                <form class="f_notifi_submit" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="col-form-label">Title</label>
                                            <input class="form-control" type="text" placeholder="Title" name="n_title" value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label">Message</label>
                                            <input class="form-control" type="text" placeholder="Message" name="n_message" value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label">Profile Image</label>
                                            <input class="form-control" type="file" name="n_image">
                                        </div>
                                        <div class="col-md-4" style="margin-top: 15px;">
                                            <button class="col-sm-12 ad-btn btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Fired Notification Listing</h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Image</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data): ?>
                                    <?php foreach ($data as $key => $value): ?>
                                    
                                    <tr class="not_<?php echo en_de_crypt($value['id']); ?>">
                                        <td><?php echo $value['id'] ; ?></td>
                                        <td style="width: 30%;"><?php echo $value['title']; ?></td>
                                        <td style="width: 30%;"><?php echo $value['message']; ?></td>
                                        <td>
                                            <?php if ($value['image']): ?>
                                                <img style="width: 50px;" src="<?php echo $value['image']; ?>" alt="">
                                            <?php endif ?>
                                        </td>
                                        <td><?php $edate = date('M j, Y g:i A', strtotime($value['created_date'])); echo $edate; ?></td>
                                        <td>
                                            <?php echo $value['action_url']; ?>
                                            
                                        </td>
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

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/fire_notification_listing.js"></script>