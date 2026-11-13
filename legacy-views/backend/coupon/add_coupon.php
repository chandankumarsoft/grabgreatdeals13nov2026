<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Add New Coupon</h1>
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
               Add New coupon
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php echo form_open_multipart('admin/add-coupon-record',['id' => 'addCoupon']); ?>
                     <div class="form-group">
                        <label for="coupon_name">Coupon Name</label>
                        <input type="text" name="coupon_name" id="coupon_name" data-error="coupon name" class="form-control" placeholder="coupon name" value="<?php echo esc(set_value('coupon_name')); ?>">
                     </div>
                     <div class="form-group">
                        <label for="coupon_description">Coupon Description</label>
                        <textarea class="form-control" rows="5" name="coupon_description" placeholder="coupon description" id="coupon_description" data-error="coupon description"><?php echo esc(set_value('coupon_description')); ?></textarea>
                     </div>
                     <div class="form-group">
                        <label for="coupon_type">Coupon Type</label>
                        <select class="form-control" name="coupon_type" id="coupon_type" data-error="coupon type">
                           <option value="">--select--</option>
                           <option value="percentage">percentage</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="coupon_amount">Coupon Amount</label>
                        <input type="number" name="coupon_amount" id="coupon_amount" data-error="coupon amount" placeholder="coupon amount" class="form-control" value="<?php echo esc(set_value('coupon_amount')); ?>">
                     </div>
                     <div class="form-group">
                        <label for="coupon_expiry_date">Coupon Expiry Date</label>
                        <input type="text" name="coupon_expiry_date" id="coupon_expiry_date" data-error="coupon expiry date" placeholder="coupon expiry date" class="form-control" value="<?php echo esc(set_value('coupon_expiry_date')); ?>" autocomplete="off">
                     </div>
                     <button type="button" id="addCouponSubmit" class="btn btn-primary">Add</button>
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
   $("#coupon_expiry_date").datepicker({
      dateFormat:'yy-mm-dd'
   });
});

$(function () {
   $('#addCouponSubmit').click(function (e) {
      e.preventDefault();
      var addCouponTrueVal = 0;
      var $inputs = $('#addCoupon');
      $inputs.find("input, textarea,select").each(function () {
         var data = $(this).val();
         if (data == "") {
            addCouponTrueVal = 1;
            $(this).next("span").remove();
            $(this).after("<span style='color:red;'>" + $(this).attr('data-error') + " is required" + "</span>");
         } else {
            $(this).next("span").remove();
         }
      });
      if (addCouponTrueVal == 0) {
         $("#addCoupon").submit();
      }
   });
});
</script>