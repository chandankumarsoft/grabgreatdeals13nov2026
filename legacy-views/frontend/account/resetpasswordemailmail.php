<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/util.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/fonts/iconic/css/material-design-iconic-font.min.css">
<style>
  .input100 {
      font-family: Poppins-Medium;
      font-size: 16px;
      color: #333333;
      line-height: 1.2;
      display: block;
      width: 100%;
      height: 40px;
      background: transparent;
      padding: 20px 7px 0 43px;
   }
</style>
<section class="main-container col1-layout" style="padding:0px;">
   <div class="main container">
      <div class="limiter">
         <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-5 p-b-54">
               <form class="login100-form validate-form" id="accountResetPasswordMail">
                  <span class="login100-form-title p-b-5">
                  Reset Password
                  </span>
                  <div id="form_credentials_error"></div>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="password" name="newPassword" id="newPassword" autocomplete="new-password" placeholder="New Password">
                     <input type="hidden" name="reset_key" value="<?php echo esc((string) $this->input->get('reset'), 'attr'); ?>">
                     <span class="focus-input100" id="newPasswordError" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="wrap-input100 validate-input">
                     <input class="input100" type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirm New Password">
                     <span class="focus-input100" id="confirmNewPasswordError" data-symbol="&#xf190;"></span>
                     <span class="focus-input100" id="confirmNewPasswordErrorMatch" data-symbol="&#xf190;"></span>
                  </div>
                  <div class="container-login100-form-btn p-t-15">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fed700;"></div>
                        <button class="login100-form-btn" type="submit" style="color:#ffffff;font-weight:600;background-color: #333e48;">
                        Reset
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<script>
   $("#newPassword").keyup(function () {
      conPass();
   });

   function conPass() {
      let newPassword = $.trim($("#newPassword").val());
      if (newPassword.length == '') {
         $("#newPasswordError").show();
         $("#newPasswordError").html("New Password can't blank");
         $("#newPasswordError").focus();
         $("#newPasswordError").css("color", "red");
         $("#newPassword").css("background-color", "white");
         $("#newPassword").css("color", "black");
         return false;
      } else {
         $('#newPasswordError').show();
         $("#newPasswordError").html("");
         return true;
      }
   }

   $("#confirmNewPassword").keyup(function () {
      conNewPass();
   });

   function conNewPass() {
      let confirmNewPassword = $.trim($("#confirmNewPassword").val());
      if (confirmNewPassword.length == '') {
         $("#confirmNewPasswordError").show();
         $("#confirmNewPasswordError").html("Confirm Password can't blank");
         $("#confirmNewPasswordError").focus();
         $("#confirmNewPasswordError").css("color", "red");
         $("#confirmNewPassword").css("background-color", "white");
         $("#confirmNewPassword").css("color", "black");
         return false;
      } else {
         $('#confirmNewPasswordError').show();
         $("#confirmNewPasswordError").html("");
         return true;
      }
   }

   function conNewPassMatch() {
      let newPassword = $.trim($("#newPassword").val());
      let confirmNewPassword = $.trim($("#confirmNewPassword").val());
      if (newPassword != confirmNewPassword) {
         $("#confirmNewPasswordErrorMatch").show();
         $("#confirmNewPasswordErrorMatch").css("color", "red");
         $("#confirmNewPasswordErrorMatch").html("Confirm Password doesn't match");
         return false;
      } else {
         $('#confirmNewPasswordErrorMatch').show();
         $("#confirmNewPasswordErrorMatch").html("");
         return true;
      }
   }

   $("#accountResetPasswordMail").submit(function (e) {
      e.preventDefault();
      conPass();
      conNewPass();
      conNewPassMatch();
      if (conPass() && conNewPass() && conNewPassMatch() == true) {
         $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url(); ?>reset-account-password-mail-update',
            data: $(this).serialize(),
            success: function (data) {
               if (data.emailDataError) {
                  swal(data.emailDataError, "", "error");
               }
               if (data.emailDataSuccess) {
                  swal(data.emailDataSuccess, "", "success");
                  $('#accountResetPasswordMail')[0].reset();
                  $
               }
            }
         });
      } else {
      }
   }); 
</script>