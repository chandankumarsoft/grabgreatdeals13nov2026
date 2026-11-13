<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Add New upsell Product</h1>
      </div>
      <!--end page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Form Elements -->
         <div class="panel panel-default">
            <h4 class="success">
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            </h4>
            <h4 class="error">
            <?php $msg = $this->session->userdata('error_image');
            echo $msg;
            $this->session->unset_userdata('error_image');
            ?>
            </h4>
            <div class="panel-heading">
               Add New upsell Product
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-lg-12">
                     <h5 style='color:red'> <?php echo validation_errors();?></h5>
                     <?php if (! empty($this->session->flashdata('upsell_error'))) { ?>
                        <h5 class="error"><?php echo esc($this->session->flashdata('upsell_error')); ?></h5>
                     <?php } ?>
                     <?php echo form_open_multipart('admin/add-product-to-upsell-insert',['id' => 'addUpsellProductFormId']); ?>
                     <div class="form-group">
                        <label for="coupon_type">Product Name For Choosing</label>
                        <select class="js-example-basic-single form-control" name="upsell_pro_id" id="upsell_pro_id">
                           <option value="">select product name</option>
                           <?php foreach ($all_product_data as $all_product_data_alue) { ?>
                           <option value="<?php echo $all_product_data_alue->pro_id; ?>"><?php echo "(pro id-$all_product_data_alue->pro_id)  $all_product_data_alue->pro_title"; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                      <div class="form-group">
                        <input type="hidden" name="reference_pro_id" value="<?php echo esc($reference_pro_id); ?>">
                        <button type="submit" id="addCouponSubmit" class="btn btn-primary">Add</button>
                        <?php echo form_close();?>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End Form Elements -->
            <?php if (! empty($prev_added_data->upsell_pro_id)) { ?>
            <div class="container">
               <div class="alert alert-info" role="alert">
                  <h2 class="text-center">Delete Product From Upsell Listing.</h2>
               </div>
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="text-center">Product Id</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $prev_added_data->upsell_pro_id; ?></td>
                    <td><img src="<?php echo base_url().'uploads/'.$prev_added_data->pro_image;?>" class="img-rounded" width="120" height="120"/></td>
                    <td><?php echo $prev_added_data->pro_title;?></td>
                    <td><?php echo $prev_added_data->created_at;?></td>
                    <td><?php if ($this->session->userrole!=5) { ?>
                    <form method="post" action="<?php echo base_url()?>admin/add-product-to-upsell-delete/<?php echo (int) $prev_added_data->reference_pro_id?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');"><button class="btn btn-danger" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
                    <?php } ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
   <!-- end page-wrapper -->
   <script type="text/javascript">
   $(document).ready(function() {
   $('.js-example-basic-single').select2();
   });

   $("#addUpsellProductFormId").submit(function(event) {
      let upsell_pro_id = $('#upsell_pro_id').val();
      if (upsell_pro_id=='') {
         alert('select product name');
         event.preventDefault();
      }
   });
   </script>