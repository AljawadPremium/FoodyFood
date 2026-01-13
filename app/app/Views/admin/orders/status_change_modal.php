<div class="modal" id="status_c_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order status change</h4>
                <button type="button" class="close clost_btn" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" class="a_display_order_id">
                        <select class="a_o_status o_status form-control" name="a_order_status" >
                            <option value="Pending">Pending</option>
                            <option value="Accepted">Accepted</option>
                            <option value="Packed">Packed</option>
                            <option value="Ready to ship">Ready to ship</option>
                            <option value="Dispatched">Dispatched</option>
                            <option value="delivered">Delivered</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='<?php echo base_url(); ?>public/admin/main_js/order_status_change.js'></script>