<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><strong>Name : </strong><?php echo esc($contact_message_by_id->contact_name); ?></h4>
    <h4 class="modal-title"><strong>Email : </strong><?php echo esc($contact_message_by_id->contact_email); ?></h4>
    <h4 class="modal-title"><strong>Subject : </strong><?php echo esc($contact_message_by_id->contact_subject); ?></h4>
</div>
<div class="modal-body">
    <strong>Message : </strong><hr/>
    <?php echo nl2br(esc($contact_message_by_id->contact_message)); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
