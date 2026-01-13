<?php
$label = 'Add';
$day_name = $slot_type = $start_time = $end_time = $status = $t_id = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);

    $slot_type = $edit['slot_type'];
    $day_name = $edit['day_name'];
    $start_time = $edit['start_time'];
    $end_time = $edit['end_time'];
    $status = $edit['status'];

    $label = 'Update';
}
?>
<style type="text/css">
    .timer_<?php echo $t_id; ?>
    {
        background: pink;
    }
</style>


<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?php echo $data['day']; ?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/slot') ?>">Slots</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?></li>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form class="add_slot_timing" method="post">
                                                <input type="hidden" class="timer_id" name="t_id" value="<?php echo $t_id ?>">
                                                <input type="hidden" name="delivery_slot_id" value="<?php echo $data['id'] ?>">
                                                <input type="hidden" name="day_name" value="<?php echo $data['day'] ?>">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label for="category">Start time</label>
                                                        <input type="time" name="start_time" class="start_time form-control" value="<?php echo $start_time; ?>" placeholder="Enter start time">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="category">End time</label>
                                                        <input type="time" name="end_time" class="end_time form-control" value="<?php echo $end_time; ?>" placeholder="Enter end time">
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label>Slot type</label>
                                                        <select class="form-control" name="slot_type">
                                                            <option <?php if($slot_type=== 'morning_slot') echo 'selected="selected"';?> value="morning_slot">Morning slot</option>
                                                            <option <?php if($slot_type=== 'evening_slot') echo 'selected="selected"';?> value="evening_slot">Evening slot</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status">
                                                            <option <?php if($status=== 'active') echo 'selected="selected"';?> value="active">Active</option>
                                                            <option <?php if($status=== 'deactive') echo 'selected="selected"';?> value="deactive">Deactive</option>
                                                        </select>
                                                    </div>

                                                    <div class="clear"></div>
                                                    <div class="col-sm-6">
                                                        <p class="error_show"></p>
                                                        <button class="btn btn-primary" type="submit"><?php echo $label; ?></button>
                                                        <?php if (!empty($t_id)): ?>
                                                            <a class="btn btn-primary" href="<?php echo base_url('admin/slot/add_time') ?>/<?php echo en_de_crypt($edit['delivery_slot_id']); ?>">Add New</a>
                                                        <?php endif ?>

                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <h4 class="card-title mb-0"></h4>
                                </div> -->
                                <div class="card-body">
                                    <table id="timer_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Type</th>
                                            <th>Start time</th>
                                            <th>End time</th>
                                            <th>Status</th>
                                            <th class="action_tab">Add Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($delivery_slot_time): ?>
                                        <?php foreach ($delivery_slot_time as $key => $value): ?>
                                        
                                        <tr class="timer_<?php echo en_de_crypt($value['id']); ?>">
                                            <td><?php echo $key+1; ?></td>
                                            <td>
                                                <?php if ($value['slot_type'] == 'evening_slot'): ?>
                                                    Evening slot
                                                <?php endif ?>
                                                <?php if ($value['slot_type'] == 'morning_slot'): ?>
                                                    Morning slot
                                                <?php endif ?>
                                                
                                            </td>
                                            <td><?php echo $value['start_time']; ?></td>
                                            <td><?php echo $value['end_time']; ?></td>
                                            <td><?php echo $value['status']; ?></td>
                                            <td class="action_tab">
                                                <a href="<?php echo base_url('admin/slot/add_time') ?>/<?php echo en_de_crypt($value['delivery_slot_id']); ?>?route=<?php echo en_de_crypt($value['id']); ?>"><i class="fa fa-edit"></i></a>

                                                <a href="javascript:void(0);" data-id="<?php echo en_de_crypt($value['id']); ?>" class="delete_time"><i class="action_tab fa fa-trash"></i></a>

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

<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/buttons.dataTables.min.css">
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src='<?php echo base_url(); ?>/public/admin/main_js/slot_time_add.js'></script>