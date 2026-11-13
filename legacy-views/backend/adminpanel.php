<?php 
if(isset($other_content) && $other_content!=NULl){?>
<?php echo $other_content ?>
<?php }else{?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Grab Great Deals</title>
      <!-- Core CSS - Include with every page -->
      <script src="<?php echo base_url()?>assets/back/plugins/jquery-1.10.2.js"></script>
      <link href="<?php echo base_url()?>assets/back/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/css/font-awesome.min.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/css/style.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/css/main-style.css" rel="stylesheet" />
      <!-- Page-Level CSS -->
      <link href="<?php echo base_url()?>assets/back/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/plugins/dataTables/dataTables.bootstrap.css?v=20261105" rel="stylesheet" />
      <link href="<?php echo base_url()?>assets/back/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />    
      <link href="<?php echo base_url(); ?>/assets/back/multiselect/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   </head>
   <body style="font-size: 16px;">
      <!--  wrapper -->
      <div id="wrapper">
         <!-- navbar top -->
         <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" target="_blank" href="<?php echo base_url(); ?>">
                  <h1 style="margin: auto;">
                     <img alt="responsive theme logo" src="<?php echo base_url(); ?>assets/front/images/logo/sssssssss.png" style="height: 65px;">
                  </h1>
               </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
               <!-- main dropdown -->
               <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                     <i class="fa fa-user fa-3x"></i>
                  </a>
                  <!-- dropdown user-->
                  <ul class="dropdown-menu dropdown-user">
                  <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i>User Profile</a></li>
                  <li><a href="#"><i class="fa fa-gear fa-fw"></i>Settings</a></li> -->
               <li class="divider"></li>
               <li><form method="post" action="<?php echo base_url();?>admin/logoutadmin" style="display:inline;"><button type="submit" class="btn btn-link"><i class="fa fa-sign-out fa-fw"></i>Logout</button></form>
            </li>
         </ul>
         <!-- end dropdown-user -->
      </li>
      <!-- end main dropdown -->
   </ul>
   <!-- end navbar-top-links -->
</nav>
<!-- end navbar top -->
<!-- navbar side -->
<nav class="navbar-default navbar-static-side" role="navigation">
   <!-- sidebar-collapse -->
   <div class="sidebar-collapse">
      <!-- side-menu -->
      <ul class="nav" id="side-menu">
         <li>
            <!-- user image section-->
            <div class="user-section">
               <div class="user-section-inner">
                  <img src="<?php echo base_url()?>assets/back/img/user.jpg" alt="">
               </div>
               <div class="user-info">
                  <div><?php echo $this->session->username;?></div>
                  <div class="user-text-online">
                     <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
                  </div>
               </div>
            </div>
            <!--end user image section-->
         </li>
         <!-- <li class="sidebar-search"> -->
            <!-- search section-->
            <!-- <div class="input-group custom-search-form">
               <input type="text" class="form-control" placeholder="Search...">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="button">
                  <i class="fa fa-search"></i>
                  </button>
               </span>
            </div> -->
            <!--end search section-->
         <!-- </li> -->
         <?php if ($this->session->userrole==1) { ?>
         <li class="selected">
            <a href="<?php echo base_url();?>admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
         </li>
         <li>
            <a href="<?php echo base_url();?>admin/contact-message-list"><i class="fa fa-address-book"></i> Contact</a>
         </li>
         <li>
            <a href="<?php echo base_url();?>admin/customer-details"><i class="fa fa-address-book"></i> Customer</a>
         </li>
<!--          <li>
            <a href="<?php //echo base_url();?>admin/complaints-message-list"><i class="fa fa-address-book"></i> Complaints</a>
         </li> -->
         <li>
            <a href="<?php echo base_url();?>admin/discount-email-list"><i class="fa fa-envelope"></i> Email List</a>
         </li>
         <li>
            <a href="<?php echo base_url();?>admin/sms-details"><i class="fa fa-comment"></i> Sms List</a>
         </li>
         <li>
            <a href="<?php echo base_url();?>admin/applicants-message-list"><i class="fa fa-address-book"></i> Applicants</a>
         </li>
         <li>
            <a href="<?php echo base_url();?>admin/register-form"><i class="fa fa-user-plus fa-fw"></i> Register User</a>
         </li>
         <?php } ?>
         <?php if ($this->session->userrole==6) { ?>
         <li>
            <a href="<?php echo base_url();?>admin/contact-message-list"><i class="fa fa-address-book"></i> Contact</a>
         </li>
<!--          <li>
            <a href="<?php //echo base_url();?>admin/complaints-message-list"><i class="fa fa-address-book"></i> Complaints</a>
         </li> -->
         <li>
            <a href="<?php echo base_url();?>admin/discount-email-list"><i class="fa fa-envelope"></i> Email List</a>
         </li>
         <?php } ?>
         <?php if (($this->session->userrole==1) || ($this->session->userrole==4) || ($this->session->userrole==6)) { ?>
            <li>
            <a href="#"><i class="fa fa-newspaper-o fa-fw"></i> Blog<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-blog "><i class=""></i>Add Blog</a>
               </li>               
               <li>
                  <a href="<?php echo base_url();?>admin/blog-list "><i class=""></i>Blog List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-sliders">&nbsp;</i> Slider<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-baner">Add Slider</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/baner-list">Slider List</a>
               </li>
            </ul>
            <!-- second-level-items -->
         </li>
         <li>
            <a href="#"><i class="fa fa-list-alt"></i> Product Category<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-category"><i class=""></i>Add Category</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/category-list"><i class=""></i>Category List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/sub-category-list"><i class=""></i>Sub Category List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/sub-of-sub-category-list"><i class=""></i>Additional Sub Category List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-tag"></i> Product Tags<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-product-tags"><i class=""></i>Add Tags</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-tags-list"><i class=""></i>Tags List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-list"></i>Product Attributes<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-product-sizes"><i class=""></i>Add Product Size</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-sizes-list"><i class=""></i>Product Size List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/add-product-color"><i class=""></i>Add Product Color</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-color-list"><i class=""></i>Product Color List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/add-product-type"><i class=""></i>Add Product Type</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-type-list"><i class=""></i>Product Type List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/add-product-search_keywords"><i class=""></i>Add Product Search Keywords</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-search_keywords-list"><i class=""></i>Product Search Keywords List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-500px"></i> Product Brand<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-brand">Add Brand</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/brand-list">Brand List</a>
               </li>
            </ul>
            <!-- second-level-items -->
         </li>
         <li>
            <a href="#"><i class="fa fa-product-hunt fa-fw"></i> Products<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-product"><i class=""></i>Add Product</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/product-list"><i class=""></i>Product List</a>
               </li>
            </ul>
         </li>         
         <?php } ?>
         <?php if ($this->session->userrole==5) { ?>
         <li>
            <a href="#"><i class="fa fa-product-hunt fa-fw"></i> Products<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/product-list"><i class=""></i>Product List</a>
               </li>
            </ul>
         </li>
         <?php } ?>
         <?php if (($this->session->userrole==1) || ($this->session->userrole==5) || ($this->session->userrole==4)) { ?>
         <li>
            <a href="#"><i class="fa fa-film"></i> Video<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-video"><i class=""></i>Add Video</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/video-list"><i class=""></i>Video List</a>
               </li>
            </ul>
         </li>
         <?php } ?>
         <?php if ($this->session->userrole==1) { ?>
         <li>
            <a href="#"><i class="fa fa-gift"></i> Coupon<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-coupon"><i class=""></i>Add coupon</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/coupon-record-list"><i class=""></i>Coupon List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-truck"></i> Shipping Charge<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
               <li>
                  <a href="<?php echo base_url();?>admin/add-shipping-charge"><i class=""></i>Add Shipping Charge</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/shipping-charge-record-list"><i class=""></i>Shipping Charge List</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/add-shipping-charge-to-products"><i class=""></i>Add Shipping Charge to Products</a>
               </li>
               <li>
                  <a href="<?php echo base_url();?>admin/shipping-charge-products-list"><i class=""></i>Shipping Charge Product List</a>
               </li>
            </ul>
         </li>
         <li>
            <a href="<?php echo base_url()?>admin/manage-order"><i class="fa fa-flask fa-fw"></i>Manage Order</a>
         </li>
         <?php } ?>

      </ul>
      <!-- end side-menu -->
   </div>
   <!-- end sidebar-collapse -->
</nav>
<!-- end navbar side -->
<?php if(isset($main_content)){
echo $main_content;
} ?>
<!-- Core Scripts - Include with every page -->
<script src="<?php echo base_url()?>assets/back/plugins/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/pace/pace.js"></script>
<script src="<?php echo base_url()?>assets/back/scripts/siminta.js?v=2"></script>
<!-- Page-Level Plugin Scripts-->
<script src="<?php echo base_url()?>assets/back/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/morris/morris.js"></script>
<!--Code for data table-->
<script src="<?php echo base_url()?>assets/back/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/dataTables/dataTables.bootstrap.js"></script>
</body>
</html>
<?php }?>