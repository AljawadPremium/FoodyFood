<div class="modal" id="o_edit_model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h4 class="modal-title">Notification send</h4>
                <button type="button" class="clost_btn close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <form class="order_c_form" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <textarea name="order_comment" placeholder="This comment will send user as notification" class="order_comment textarea" rows="2"></textarea>
                            <button type="submit" class="order_comment_button col-sm-12">Add</button>
                        </div>
                        <div class="col-md-6">
                            <table class="co_table table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="comment_body">
                                    <?php if (!empty($o_comment)): ?>
                                    <?php foreach ($o_comment as $key => $value): ?>
                                    <tr class="remove_<?php echo $value['id']; ?>">
                                        <td><?php echo $value['order_comment']; ?></td>
                                        <td><?php echo date("D, d F ",strtotime($value['created_date'])); ?></td>
                                        <td><a class="order_comment_delete" data-iid = "<?php echo $value['id']; ?>" data-id = "<?php echo en_de_crypt($value['oid']); ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>