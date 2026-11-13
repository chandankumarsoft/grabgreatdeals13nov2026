<section class="main-container col1-layout">
   <div class="main container">
      <div class="page-content">
         <div class="account-login">
            <div class="box-authentication" id="account_forget">
               <?php if($this->session->flashdata('error_message')!=null) {
                  echo "<div id='errormessage' style='color:red;''>{$this->session->flashdata('error_message')}</div>";
                  }?>
               <form action="<?php base_url();?>verify_registration_account"  method="post" id="otpmatchform">
                  <h4>Verify Account</h4>
                  <p class="before-login-text">verify your account Email</p>
                  <label for="cus_email">Email address<span class="required">*</span></label>
                  <input id="cus_email"  name="cus_email" type="text" value="<?php echo $this->session->userdata('customer_registration_email') ?>"  class="form-control">
                  <span style="color: red;"><?php echo form_error('cus_email'); ?></span>
                  <input type="hidden" name="verification_page_name" value="<?php echo $verification_redirection_page; ?>">
                  <label for="cus_otp">OTP<span class="required">*</span></label>
                  <input id="cus_otp" name="cus_otp" type="text" value="" class="form-control">
                  <span style="color: red;"><?php echo form_error('cus_otp'); ?></span>                  
                  <button class="button" id="btnsubmitotpmatch" type="submit"><i class="fa fa-lock"></i>&nbsp; <span>verify</span></button>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>