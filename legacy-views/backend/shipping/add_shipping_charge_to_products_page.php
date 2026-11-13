<script src="<?php echo base_url(); ?>assets/back/multiselect/js/multiselect-checkbox/jquery.multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/multiselect/css/jquery.multiselect.css">
<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Add Shipping Charge To Products</h1>
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
               Add Shipping Charge To Products
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php echo form_open_multipart('admin/save-shipping-charge-to-products'); ?>
                     <div class="form-group">
                        <label>Shipping Charge Details</label>
                        <select name="shippingchargelist[]" multiple id="shippingchargelist">
                           <?php foreach ($shippingchargedetails as $shippingchargedetailsvalue) { ?>
                              <option value="<?php echo esc($shippingchargedetailsvalue->id); ?>"><?php echo esc($shippingchargedetailsvalue->shipping_description); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Products Name Details </label> <span>(select product ID)</span>
                        <select name="productsnamedetails[]" multiple="multiple" id="productsnamedetails">
                           <?php foreach ($productsnamedetails as $productsnamedetailsvalue) { ?>
                              <option value="<?php echo esc($productsnamedetailsvalue->pro_id); ?>"><?php echo esc($productsnamedetailsvalue->pro_id); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <button type="submit" class="btn btn-primary">Add</button>
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
   $('#shippingchargelist').multiselect({
    columns: 1,
    placeholder: 'Select shipping charge details',
    search: true,
    selectAll: false
});

   $('#productsnamedetails').multiselect({
    columns: 1,
    placeholder: 'Select products name details',
    search: true,
    selectAll: false
});
</script>