<div class="modal" id="order_payment_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send payment link for order no #<span class="order_id"></span></h4>
                <button type="button" class="clost_btn" onclick="close_Modal_payment_order_link()">&times;</button>
            </div>
            <form class="order_payment_link_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="hidden" class="p_d_order_id" name="display_order_id" value="">
                            <label class="col-form-label">Customer name</label>
                            <input class="form-control mb-0" type="text" placeholder="Customer name" id="pname" name="name" required="">
                            <label class="error_show name"></label>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Mobile number</label>
                            <input class="form-control mb-0" type="text" placeholder="Mobile number" id="pmobile" name="mobile" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="">
                            <span class="error_show mobile"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Email</label>
                            <input class="form-control mb-0" type="email" placeholder="Email address" id="pemail" name="email">
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Amount</label>
                            <input class="form-control mb-0" type="text" placeholder="Enter amount" id="pamount" name="amount" required="">
                            <span class="error_show amount"></span>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Message</label>
                            <input class="form-control mb-0" type="text" placeholder="Enter message" id="pmessage" name="message" required="">
                        </div>
                        <div class="col-md-3 mt-20" >
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src='<?php echo base_url(); ?>public/admin/main_js/razorpay_payment_link_listing_create.js'></script>