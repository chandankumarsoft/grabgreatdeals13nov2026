<!-- Main Container -->
<section class="main-container col1-layout">
   <div class="main container">
      <div class="page-content">
         <div class="account-login">
         


              <div class="box-authentication" id="account_forget">
               <?php if($this->session->flashdata('error_message_otp_success')!=null) {
                  echo "<div id='errormessagesuccess' style='color:green;''>{$this->session->flashdata('error_message_otp_success')}</div>";
                  }?>
                  <?php if($this->session->flashdata('error_message')!=null) {
                  echo "<div id='errormessage' style='color:red;''>{$this->session->flashdata('error_message')}</div>";
                  }?>

               <form action="<?php base_url();?>forget_otp_match"  method="post" id="otpmatchform">
                  <h4>Verify Account</h4>
                  <p class="before-login-text">verify your account Email</p>
                  <label for="cus_email">Email address<span class="required">*</span></label>
                  <input id="cus_email"  name="cus_email" type="text" value="<?php echo $this->session->userdata('cus_email_otp') ?>"  class="form-control">
                  <span style="color: red;"><?php echo form_error('cus_email'); ?></span>

                  

                     <label for="cus_otp">OTP<span class="required">*</span></label>
                     <input id="cus_otp" name="cus_otp" type="text" value="<?php echo set_value('cus_otp'); ?>" class="form-control">
                     <span style="color: red;"><?php echo form_error('cus_otp'); ?></span>  

                     <label for="cus_new_password">New Password<span class="required">*</span></label>
                     <input id="cus_new_password" name="cus_new_password" type="password" value="<?php echo set_value('cus_new_password'); ?>" class="form-control">
                     <span style="color: red;"><?php echo form_error('cus_new_password'); ?></span> 


                     <label for="cus_new_password_confirm">Confirm Password<span class="required">*</span></label>
                     <input id="cus_new_password_confirm" name="cus_new_password_confirm" type="password" value="<?php echo set_value('cus_new_password_confirm'); ?>" class="form-control">

                     <span style="color: red;"><?php echo form_error('cus_new_password_confirm'); ?></span>                  
                  
                  <button class="button" id="btnsubmitotpmatch" type="submit"><i class="fa fa-lock"></i>&nbsp; <span>verify</span></button>
               </form>


            </div>


            </div>



         </div>
      </div>
   </div>
</section>
<!-- Main Container End -->