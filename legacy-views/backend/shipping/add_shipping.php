<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Add New Shipping Charge</h1>
      </div>
      <!--end page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Form Elements -->
         <div class="panel panel-default">
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <h4 class="error">
            <?php $msg = $this->session->userdata('error_image');
            echo $msg;
            $this->session->unset_userdata('error_image');
            ?>
            </h4>
            <div class="panel-heading">
               Add New Shipping Charge
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php echo form_open_multipart('admin/add-shipping-charge-record',['id' => 'addShipping']); ?>
                     <div class="form-group">
                        <label for="start_day">From Day</label>
                        <input type="number" name="start_day" id="start_day" data-error="start day" class="form-control" placeholder="start day" value="<?php echo esc(set_value('start_day')); ?>">
                     </div>
                     <div class="form-group">
                        <label for="till_day">Till Day</label>
                        <input type="number" name="till_day" id="till_day" data-error="Till day" class="form-control" placeholder="till day" value="<?php echo esc(set_value('till_day')); ?>">
                     </div>
                     <div class="form-group">
                        <label for="shipping_description">Shipping Description</label>
                        <textarea class="form-control" rows="5" name="shipping_description" placeholder="shipping description" id="shipping_description" data-error="shipping description"><?php echo esc(set_value('shipping_description')); ?></textarea>
                     </div>
                     <div class="form-group">
                        <label for="shipping_amount">Shipping Amount</label>
                        <input type="number" name="shipping_amount" id="shipping_amount" data-error="shipping amount" placeholder="shipping amount" class="form-control" value="<?php echo esc(set_value('shipping_amount')); ?>">
                     </div>
                     <button type="button" id="addShippingSubmit" class="btn btn-primary">Add</button>
                     <?php echo form_close();?>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Form Elements -->
      </div>
   </div>
</div>
<!-- end page-wrapper -->
<script>
$(function () {
   $('#addShippingSubmit').click(function (e) {
      e.preventDefault();
      var addShippingTrueVal = 0;
      var $inputs = $('#addShipping');
      $inputs.find("input, textarea,select").each(function () {
         var data = $(this).val();
         if (data == "") {
            addShippingTrueVal = 1;
            $(this).next("span").remove();
            $(this).after("<span style='color:red;'>" + $(this).attr('data-error') + " is required" + "</span>");
         } else {
            $(this).next("span").remove();
         }
      });
      if (addShippingTrueVal == 0) {
         $("#addShipping").submit();
      }
   });
});
</script>