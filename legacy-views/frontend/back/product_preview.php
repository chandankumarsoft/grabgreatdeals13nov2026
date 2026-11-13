<style>
.myButton {
box-shadow: 1px 0px 0px 0px #3dc21b;
background-color:#c9c92f;
border-radius:42px;
border:2px solid #aba619;
display:inline-block;
cursor:pointer;
color:#ffffff;
font-family:Arial;
font-size:28px;
font-weight:bold;
padding:32px 76px;
text-decoration:none;
text-shadow:0px 1px 0px #2f6627;
}
.myButton:hover {
background-color:#e6cf25;
}
.myButton:active {
position:relative;
top:1px;
}
</style>
<!--  page-wrapper -->
<div id="page-wrapper">
   <div class="row">
      <!-- page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Product Details</h1>
      </div>
      <!--end page header -->
   </div>
   <div class="row">
      <div class="jumbotron text-center">
         <h3 class="display-3"><strong><?php echo $this->session->flashdata('flsh_msg'); ?></strong></h3>
         <h4 class="error">
         <?php $msg = $this->session->userdata('error_image');
         echo $msg;
         $this->session->unset_userdata('error_image');
         ?>
         </h4>
         <p class="lead"><strong>We are checking your details</strong> if everything ok then it will be live on site.</p>
         <hr>
         <p>
            Having trouble? <a href="<?php echo base_url(); ?>contact-us" target="_blank">Contact us</a>
         </p>
         <?php
         $product_title_slug=$this->db->select('pro_title,pro_title_slug')->from('tbl_product')->where('pro_id',$this->input->get('pro_id'))->get()->row();
         ?>
         <div>
            <p class="lead">
               <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>add-product" role="button" style="background-color: #404a54">Add New Product</a>
               <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>product-list" role="button" style="background-color: #404a54">Product List</a>
               <a class="btn btn-primary btn-lg" href="<?php echo base_url(); ?>edit-product?pro_id=<?php echo $this->input->get('pro_id'); ?>" role="button" style="background-color: #404a54">Edit Product</a>
               <a class="btn btn-primary btn-lg" target="_blank" href="<?php echo base_url(); ?>product-details/<?php echo $product_title_slug->pro_title_slug; ?>" role="button" style="background-color: #404a54">Preview Product</a>
            </p>
         </div>
      </div>
   </div>
</div>