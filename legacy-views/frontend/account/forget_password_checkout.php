<!-- Main Container -->
<section class="main-container col1-layout">
   <div class="main container">
      <div class="page-content">
         <div class="account-login">
            
            <div class="box-authentication" id="account_forget">
               <?php if($this->session->flashdata('error_message')!=null) {
               echo "<div id='errormessage' style='color:red;''>{$this->session->flashdata('error_message')}</div>";
               }?>
               <form action="<?php base_url();?>forget_account_password_checkout"  method="post" id="otpmatchform">
                  <h4>OTP send</h4>
                  <p class="before-login-text">OTP send Your account Email</p>
                  <label for="cus_email">Email address<span class="required">*</span></label>
                  <input id="cus_email"  name="cus_email" type="text" value="<?php echo set_value('cus_email'); ?>"  class="form-control">
                  <span style="color: red;"><?php echo form_error('cus_email'); ?></span>


                  
                  <button class="button" id="btnsubmitotpmatch" type="submit"><i class="fa fa-lock"></i>&nbsp; <span>Send</span></button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</section>
<!-- Main Container End -->