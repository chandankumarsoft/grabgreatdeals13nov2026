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
                  <h2>My Address</h2>
                  </div> -->
               <div class="container">
                  <div><?php echo $this->session->flashdata('error_message'); ?>  </div>
                  <div class="form-style-2">
                     <div class="form-style-2-heading">Change Password</div>
                     <form action="<?php echo base_url(); ?>change-account-password" method="post">                    
                        <label><span> Current Password </span>
                           <input type="password" class="input-field" name="cus_password" value="" autocomplete="current-password" required />
                        </label>
                        <label><span>New Password </span>
                           <input type="password" class="input-field" id="cus_password_new" name="cus_password_new" value="" autocomplete="new-password" required />
                        </label>
                        <label><span>New Confirm Password </span>
                           <input type="password" class="input-field" id="cus_password_new_confirm" name="cus_password_new_confirm" value="" autocomplete="new-password" required />
                        </label>
                        <input type="submit" value="Change Password" style="text-align: center;">
                     </form>
                  </div>
               </div>

            </div>
         </div>
         <script>
   var cus_password_new = document.getElementById("cus_password_new")
  , cus_password_new_confirm = document.getElementById("cus_password_new_confirm");

function validatePassword(){
  if(cus_password_new.value != cus_password_new_confirm.value) {
    cus_password_new_confirm.setCustomValidity("Passwords Don't Match");
  } else {
    cus_password_new_confirm.setCustomValidity('');
  }
}

cus_password_new.onchange = validatePassword;
cus_password_new_confirm.onkeyup = validatePassword;
</script>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>