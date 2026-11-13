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
              <?php echo form_open_multipart('admin/edit-save-shipping-charge-to-products'); ?>
              <div class="form-group">
                <label>Products Name Details</label>
                <select name="productsnamedetails[]" multiple="multiple" id="productsnamedetails">
                  <?php foreach ($productsnamedetails as $productsnamedetailsvalue) { ?>
                  <option value="<?php echo esc($productsnamedetailsvalue->pro_id); ?>"
                    <?php
                    foreach ($productinblrel as $productinblrelvalue) {
                      $selected_pro_id=$productsnamedetailsvalue->pro_id;
                    echo ($productsnamedetailsvalue->pro_id==$productinblrelvalue->pro_id) ? 'selected' : '';
                    }
                    ?>>
                  <?php echo esc($productsnamedetailsvalue->pro_title); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Shipping Charge Details</label>
                <select name="shippingchargelist[]" multiple id="shippingchargelist">
                  <?php
                  foreach ($shippingcharge as $shippingchargevalue) {
                  
                  ?>
                  <option value="<?php echo esc($shippingchargevalue->id); ?>"
                    <?php
                    foreach ($shippingchargedetails as $shippingchargedetailsvalue) {
                    echo ($shippingchargevalue->id==$shippingchargedetailsvalue->ship_charge_id) ? 'selected' : '';
                    }
                    ?>>
                  <?php echo esc($shippingchargevalue->shipping_description); ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Edit</button>
              <button type="button" class="btn btn-danger" onclick="deleteFromShipCharge(<?php echo esc($selected_pro_id); ?>)">Delete This Product From Shipping</button>
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

function deleteFromShipCharge(product_id){
                   $.ajax({
                    url:'<?php echo base_url(); ?>admin/delete-save-shipping-charge-to-products',
                    type:'POST',
                     dataType:'json',
                    data:{product_id:product_id},
                    success:function(result){
                      if (result.error) {
                        swal(result.error);
                      }
                      if (result.success) {
                        document.location = "<?php echo base_url(); ?>admin/shipping-charge-products-list";
                      }
                    }
                 });
}
</script>