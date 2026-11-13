<style type="text/css">
   .form-style-2{
   max-width: 500px;
   padding: 20px 12px 10px 20px;
   font: 13px Arial, Helvetica, sans-serif;
   }
   .form-style-2-heading{
   font-weight: bold;
   font-style: italic;
   border-bottom: 2px solid #ddd;
   margin-bottom: 20px;
   font-size: 15px;
   padding-bottom: 3px;
   }
   .form-style-2 label{
   display: block;
   margin: 0px 0px 15px 0px;
   }
   .form-style-2 label > span{
   width: 100px;
   font-weight: bold;
   float: left;
   padding-top: 8px;
   padding-right: 5px;
   }
   .form-style-2 span.required{
   color:red;
   }
   .form-style-2 .tel-number-field{
   width: 40px;
   text-align: center;
   }
   .form-style-2 input.input-field, .form-style-2 .select-field{
   width: 48%;
   }
   .form-style-2 input.input-field,
   .form-style-2 .tel-number-field,
   .form-style-2 .textarea-field,
   .form-style-2 .select-field{
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
   border: 1px solid #C2C2C2;
   box-shadow: 1px 1px 4px #EBEBEB;
   -moz-box-shadow: 1px 1px 4px #EBEBEB;
   -webkit-box-shadow: 1px 1px 4px #EBEBEB;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   padding: 7px;
   outline: none;
   }
   .form-style-2 .input-field:focus,
   .form-style-2 .tel-number-field:focus,
   .form-style-2 .textarea-field:focus,
   .form-style-2 .select-field:focus{
   border: 1px solid #0C0;
   }
   .form-style-2 .textarea-field{
   height:100px;
   width: 55%;
   }
   .form-style-2 input[type=submit],
   .form-style-2 input[type=button]{
   border: none;
   padding: 8px 15px 8px 15px;
   background: #FF8500;
   color: #fff;
   box-shadow: 1px 1px 4px #DADADA;
   -moz-box-shadow: 1px 1px 4px #DADADA;
   -webkit-box-shadow: 1px 1px 4px #DADADA;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   }
   .form-style-2 input[type=submit]:hover,
   .form-style-2 input[type=button]:hover{
   background: #EA7B00;
   color: #fff;
   }

</style>
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="shop-inner">
               <!-- <div class="page-title">
                  <h2>My Profile</h2>
                  </div> -->
                  <?php 
                  $selected_profile_value=$this->db->select('cus_name,cus_gender,cus_email,cus_mobile')->from(' tbl_customer')->where('cus_id',$this->session->userdata('cus_id'))->get()->row(); ?>
                  <div class="form-style-2-heading">My Profile</div>
                  <div class="container">
                  <div class="row" style="margin-top:10px;">
                     <div class="col-lg-6">
                     <div class="col-lg-6"><strong>Name</strong></div>
                     <div class="col-lg-6"><?php echo $selected_profile_value->cus_name; ?></div>
                     </div>
                  </div>                   
                  <div class="row" style="margin-top:10px;">
                     <div class="col-lg-6">
                     <div class="col-lg-6"><strong>Email</strong></div>
                     <div class="col-lg-6"><?php echo $selected_profile_value->cus_email; ?></div>
                     </div>
                  </div>                   
                  <div class="row" style="margin-top:10px;">
                     <div class="col-lg-6">
                     <div class="col-lg-6"><strong>Mobile</strong></div>
                     <div class="col-lg-6"><?php echo $selected_profile_value->cus_mobile; ?></div>
                     </div>
                  </div>
                  <div class="row" style="margin-top:10px;">
                     <div class="col-lg-6">
                     <div class="col-lg-12 text-center">
                        <a href="<?php echo base_url(); ?>edit-my-profile">
                        <button class="btn btn-primary" style="background-color: #333e48;border-color: #333e48;">Edit Details</button>
                        </a>
                     </div>
                     </div>
                  </div>                  
                  </div>                 
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>