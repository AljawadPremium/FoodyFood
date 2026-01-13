<div class="modal" id="notification_customer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h4 class="modal-title">Notification Send To -  <span class="add_name"></span></h4>
                <button type="button" class="close clost_btn" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <form class="send_notification_to_single_user" method="post">
                    <input type="hidden" name="n_cust_id" class="n_cust_id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <textarea class="c_not" name="title" placeholder="Enter Title" rows="2"></textarea>
                            <button style="border: none;background: #272e48;color: white;padding: 10px;border-radius: 5px;" type="submit" class="col-sm-12">Send</button>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="c_not" name="description" placeholder="Enter Description" rows="2"></textarea>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>