<link rel="stylesheet" href="https://demos.codexworld.com/international-telephone-input-with-country-flags-dial-codes-jquery/css/intlTelInput.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/util.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/fonts/iconic/css/material-design-iconic-font.min.css">
<style>
   .separate-dial-code{
   width:100%;
   }
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
<script>
   function RememberPasswordSaveLocal() {
      if ($('#rememberme').is(':checked')) {
         localStorage.usrname = $('#login_username_field').val();
         localStorage.pass = $('#login_password_field').val();
         localStorage.chkbx = $('#rememberme').val();
      } else {
         localStorage.usrname = '';
         localStorage.pass = '';
         localStorage.chkbx = '';
      }
   }
      $(function() {
      if (localStorage.chkbx && localStorage.chkbx != '') {
         $('#rememberme').attr('checked', 'checked');
         $('#login_username_field').val(localStorage.usrname);
         $('#login_password_field').val(localStorage.pass);
      } else {
         $('#rememberme').removeAttr('checked');
         $('#login_username_field').val('');
         $('#login_password_field').val('');
      }
   });
</script>
<section class="main-container col1-layout" style="padding:0px;">
   <div class="main container">
      <div class="limiter">
         <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-5 p-b-54">
               <form class="login100-form validate-form" id="loginformdetails">
                  <span class="login100-form-title p-b-5">
                  Login
                  </span>
                  <div id="form_credentials_error"></div>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="text" id="login_username_field" placeholder="Type your Email or mobile">
                     <span class="focus-input100" id="login_username_field_error" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Password is required">
                     <input class="input100" type="password" id="login_password_field" placeholder="Type your password">
                     <span class="focus-input100" id="login_password_field_error" data-symbol="&#xf190;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                     <label class="inline" for="rememberme" style="float: left;">
                     <input type="checkbox" value="forever" id="rememberme"> Remember me
                     </label>
                     <a href="javascript:void(0);" id="forgetpasswordbutton" style="font-weight: 600;color:#739fb6;">
                     Forgot password ?
                     </a>
                  </div>
                  <div class="container-login100-form-btn">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fed700;"></div>
                        <button class="login100-form-btn" style="color:#373737;font-weight:600;">
                        Login
                        </button>
                     </div>
                  </div>
                  <div class="flex-col-c p-t-5">
                     <a href="javascript:void(0);" id="signupbutton" class="txt2 btn btn-default" style="width: 100%;background-color:#333e48;color:#ffffff;border-radius: 20px;height: 50px;align-items: center;padding: 13px;font-weight:600;">
                     Sign Up
                     </a>
                  </div>
               </form>
               <script>
                  $('#loginformdetails').on('submit', function (event) {
                     event.preventDefault();
                     RememberPasswordSaveLocal();
                     let login_username_field = $('#login_username_field').val();
                     let login_password_field = $('#login_password_field').val();
                     let login_signcheck = '<?php echo $this->input->get('signin') ?>';
                     $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>userlogin',
                        data:{login_username_field:login_username_field,login_password_field:login_password_field,login_signcheck:login_signcheck},
                        success:function(response)
                        {
                           if (response.login_username_field_error!='') {
                              $('#login_username_field_error').html(response.login_username_field_error).css('color','red');
                           }else{
                              $('#login_username_field_error').html('');
                           }
                  
                           if (response.login_password_field_error!='') {
                              $('#login_password_field_error').html(response.login_password_field_error).css('color','red');
                           }else{
                              $('#login_password_field_error').html('');
                           }
                  
                           if (response.credentials_error) {
                              $('#login_username_field_error').html('');
                              $('#login_password_field_error').html('');
                               $('#form_credentials_error').html('<div class="alert alert-danger" role="alert">'+response.credentials_error+'</div>');
                           }                              
                           if (response.credentials_success) {
                               $('#form_credentials_error').html('<div class="alert alert-success" role="alert">'+response.credentials_success+'</div>');
                               $('#loginformdetails')[0].reset();
                               window.location="<?php echo base_url(); ?>";
                           }
                           
                           if (response.credentials_success_signin) {
                               $('#form_credentials_error').html('<div class="alert alert-success" role="alert">'+response.credentials_success+'</div>');
                               $('#loginformdetails')[0].reset();
                               window.location="<?php echo base_url(); ?>checkout";
                           }
                        }
                     });
                  });
               </script>
               <form class="login100-form validate-form" id="otpvalidationmatch">
                  <span class="login100-form-title p-b-5">
                  Verify mobile number
                  </span>
                  <p>A text with a One Time Password (OTP) has been sent to your mobile number:<span><strong id="reg_otp_mobile_no"></strong></span> <a class="text-primary" href="javascript:void(0)" id="changemobileregotp"> Change </a></p>
                  <div class="wrap-input100 validate-input">
                     <span class="label-input100 text-danger" id="reg_verify_form_otp_error">Password</span>
                     <input class="input100" type="password" id="reg_verify_form_otp" placeholder="Enter OTP">
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                     <a href="javascript:void(0);" id="reg_otp_resend" style="font-weight:600;color:#739fb6;">
                     Resend OTP?
                     </a>
                  </div>
                  <div class="container-login100-form-btn">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fe0100;"></div>
                        <button type="submit" class="login100-form-btn">
                        Verify 
                        </button>
                     </div>
                  </div>
                  <div class="flex-col-c p-t-5">
                     <span class="txt1 p-b-17">
                     Or Sign Up
                     </span>
                     <div class="row" style="display: inline-flex;width:100%;">
                        <a href="javascript:void(0);" id="resetsignupbutton" class="txt2 btn btn-default" style="width:100%;background-color:#0083c1;color:#ffffff">
                        Sign Up
                        </a>
                        <a href="javascript:void(0);" id="resetloginbutton" class="txt2 btn btn-default" style="width:100%;background-color:#0083c1;color:#ffffff">
                        Login
                        </a>
                     </div>
                  </div>
               </form>
               <script>
                  $('#otpvalidationmatch').on('submit', function (event) {
                     event.preventDefault();
                     let reg_verify_form_otp = $('#reg_verify_form_otp').val();
                     let sign_up_check_redirect = '<?php echo $this->input->get('signin') ?>';
                     $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>regotpmatch',
                        data:{reg_verify_form_otp:reg_verify_form_otp,sign_up_check_redirect:sign_up_check_redirect},
                        success:function(response)
                        {
                          $('#reg_verify_form_otp_error').html(response.reg_verify_form_otp).css('color','#ff0000');
                  
                          if (response.registration_status) {                                 
                              $('#reg_verify_form_otp_error').html('<div class="alert alert-success" role="alert">'
                                +response.registration_status+
                              '</div>');
                           $('#otpvalidationmatch')[0].reset();
                            window.location="<?php echo base_url(); ?>";
                           }
                           if (response.credentials_signin_success_redirect) {
                                $('#otpvalidationmatch')[0].reset();
                               window.location="<?php echo base_url(); ?>checkout";
                           }
                  
                        }
                     });
                  });
               </script>
               <script>
                  $('#reg_otp_resend').on('click', function () {                  
                     $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>reg_resend_otp',
                        data:{reg_otp_success:true},
                        success:function(response)
                        {
                           if (response.resend_otp_sent_success) {                                 
                              $('#reg_verify_form_otp_error').html('<div class="alert alert-success" role="alert">'
                                +response.resend_otp_sent_success+
                              '</div>');
                           }
                        }
                     });
                  });
               </script>
               <form class="login100-form validate-form" id="resetformdetails">
                  <span class="login100-form-title p-b-5">
                  Reset Password
                  </span>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="text" id="reset_mobileno_field" placeholder="Enter Mobile Number">
                     <span class="focus-input100" id="reset_mobileno_field_error" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                  </div>
                  <div class="container-login100-form-btn">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fed700;"></div>
                        <button class="login100-form-btn" style="color:#373737;font-weight:600;">
                        Continue 
                        </button>
                     </div>
                  </div>
                  <div class="flex-col-c p-t-5">
                     <div class="row" style="display: inline-flex;width:100%;">
                        <a href="javascript:void(0);" id="resetsignupbuttonreset" class="txt2 btn btn-default" style="width: 100%;background-color:#333e48;color:#ffffff;border-radius: 20px;height: 50px;align-items: center;padding: 13px;font-weight:600;">
                        Sign Up
                        </a>
                        <a href="javascript:void(0);" id="resetloginbuttonreset" class="txt2 btn btn-default" style="width: 100%;background-color:#333e48;color:#ffffff;border-radius: 20px;height: 50px;align-items: center;padding: 13px;font-weight:600;">
                        Login
                        </a>
                     </div>
                  </div>
               </form>
               <script>
                  $('#resetformdetails').on('submit', function (event) {
                     event.preventDefault();
                     let reset_mobileno_field = $('#reset_mobileno_field').val();
                        $.ajax({
                           type:'post',
                           dataType:'json',
                           url:'<?php echo base_url(); ?>forget_account_password',
                           data:{reset_mobileno_field:reset_mobileno_field},
                           success:function(response)
                           {
                              if (response.reset_mobileno_field_error!='') {
                               $('#reset_mobileno_field_error').html(response.reset_mobileno_field_error).css('color','#ff0000');
                              }else{
                                $('#reset_mobileno_field_error').html('');
                              }
                  
                              if (response.reset_mobileno_field_error_not_reg!='') {
                               $('#reset_mobileno_field_error').html(response.reset_mobileno_field_error_not_reg).css('color','#ff0000');
                              }else{
                                $('#reset_mobileno_field_error').html('');
                              }
                  
                              if (response.pass_reset_otp_sent) {
                                 $('#resetformdetails').hide();
                                 $('#resetpasswordotpform').show();
                              }
                           },
                           error:function(xhr) {
                              var response = xhr.responseJSON || {};
                              $('#reset_mobileno_field_error').text(response.error || 'Unable to send a verification code. Please try again.').css('color','#ff0000');
                           }
                        });
                  });
               </script>
               <form class="login100-form validate-form" id="resetpasswordotpform">
                  <span class="login100-form-title p-b-5">
                  Reset Password
                  </span>
                  <span id="reset_otp_pass_send_success"></span>
                  <div class="wrap-input100 validate-input">
                     <input class="input100" type="text" id="reset_password_otp_field" placeholder="Enter OTP">
                     <span class="focus-input100" id="reset_password_otp_field_error" data-symbol="&#xf190;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                     <a href="javascript:void(0);" id="reset_otp_pass_send" style="font-weight: 600;color:#739fb6;">
                     Resend OTP?
                     </a>
                  </div>
                  <div class="wrap-input100 validate-input">
                     <input class="input100" type="password" id="otp_password_new_number" autocomplete="new-password" placeholder="Type your New password">
                     <span class="focus-input100" id="otp_password_new_number_error" data-symbol="&#xf190;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                  </div>
                  <div class="container-login100-form-btn">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fe0100;"></div>
                        <button class="login100-form-btn">
                        Continue 
                        </button>
                     </div>
                  </div>
                  <div class="flex-col-c p-t-5">
                     <span class="txt1 p-b-17">
                     Or Sign Up
                     </span>
                     <div class="row" style="display: inline-flex;width:100%;">
                        <a href="javascript:void(0);" id="resetsignupbuttonotp" class="txt2 btn btn-default" style="width:100%;background-color:#0083c1;color:#ffffff">
                        Sign Up
                        </a>
                        <a href="javascript:void(0);" id="resetloginbuttonotp" class="txt2 btn btn-default" style="width:100%;background-color:#0083c1;color:#ffffff">
                        Login
                        </a>
                     </div>
                  </div>
               </form>
               <script>
                  $('#resetpasswordotpform').on('submit', function (event) {
                     event.preventDefault();
                     let reset_password_otp_field = $('#reset_password_otp_field').val();
                     let otp_password_new_number  = $('#otp_password_new_number').val();
                     $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>forget_account_reset_new',
                        data:{reset_password_otp_field:reset_password_otp_field,otp_password_new_number:otp_password_new_number},
                        success:function(response)
                        {
                           if (response.reset_password_otp_field_error!='') {
                            $('#reset_password_otp_field_error').html(response.reset_password_otp_field_error).css('color','#ff0000');
                           }else{
                             $('#reset_password_otp_field_error').html('');
                           }                           
                  
                           if (response.otp_password_new_number_error!='') {
                            $('#otp_password_new_number_error').html(response.otp_password_new_number_error).css('color','#ff0000');
                           }else{
                             $('#otp_password_new_number_error').html('');
                           }
                  
                           if (response.otp_password_new_number_success) {                                 
                              $('#reset_otp_pass_send_success').html('<div class="alert alert-success" alert-dismissible role="alert">'
                                +response.otp_password_new_number_success+
                              '</div>');
                              $('#resetpasswordotpform')[0].reset();                              
                           }
                        },
                        error:function(xhr) {
                           var response = xhr.responseJSON || {};
                           $('#reset_password_otp_field_error').text(response.error || 'Unable to reset the password. Please try again.').css('color','#ff0000');
                        }
                     });
                  });
               </script>
               <script>
                  $('#reset_otp_pass_send').on('click', function () {                  
                     $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'<?php echo base_url(); ?>reset_resend_otp',
                        data:{reset_otp_success:true},
                        success:function(response)
                        {
                           if (response.resend_otp_sent_success) {                                 
                              $('#reset_otp_pass_send_success').html('<div class="alert alert-success" alert-dismissible role="alert">'
                                +response.resend_otp_sent_message+
                              '</div>');
                           }
                        },
                        error:function(xhr) {
                           var response = xhr.responseJSON || {};
                           $('#reset_otp_pass_send_success').text(response.error || 'Unable to resend the verification code. Please try again.').css('color','#ff0000');
                        }
                     });
                  });
               </script>
               <form class="login100-form validate-form" id="registerformdetails">
                  <span class="login100-form-title p-b-5">
                  Create Account
                  </span>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="text" id="register_cus_name" placeholder="Your name">
                     <span class="focus-input100" id="register_cus_name_error" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="wrap-input100 validate-input m-b-23" style="width:100%">
                     <span id="valid-msg" class="hide"></span>
                     <span id="error-msg" class="hide" style="color:red;"></span>
                     <span data-symbol="&#xf206;" id="register_cus_mobile_error"></span>
                     <input id="phone" type="tel" class="input100" placeholder="Mobile number" style="width:100%">
                  </div>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="email" id="register_cus_email" placeholder="Email (optional)">
                     <span class="focus-input100" id="register_cus_email_error" data-symbol="&#xf15a;"></span>
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Password is required">
                     <input class="input100" type="password" id="register_cus_password" placeholder="password at least 6 characters">
                     <span class="focus-input100" id="register_cus_password_error" data-symbol="&#xf190;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                  </div>
                  <div class="container-login100-form-btn">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fed700;"></div>
                        <button class="login100-form-btn" style="color:#373737;font-weight:600;">
                        Sign Up
                        </button>
                     </div>
                  </div>
                  <div class="flex-col-c p-t-5">
                     <a href="javascript:void(0);" id="loginbutton" class="txt2 btn btn-default" style="width: 100%;background-color:#333e48;color:#ffffff;border-radius: 20px;height: 50px;align-items: center;padding: 13px;font-weight:600;">
                     Already have an account? Sign in
                     </a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/countrylist/js/intlTelInput.js"></script>
<script src="https://demos.codexworld.com/international-telephone-input-with-country-flags-dial-codes-jquery/js/intlTelInput.js"></script>
<script>
   $(document).ready(function(){
      $('#loginformdetails').show();
      $('#resetformdetails').hide();
      $('#registerformdetails').hide();
      $('#otpvalidationmatch').hide();
      $('#resetpasswordotpform').hide();
   
      $('#signupbutton').click(function(){
         $('#loginformdetails').hide();
         $('#resetformdetails').hide();
         $('#registerformdetails').show();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#loginbutton').click(function(){
         $('#loginformdetails').show();
         $('#resetformdetails').hide();
         $('#registerformdetails').hide();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#changemobileregotp').click(function(){
         $('#loginformdetails').hide();
         $('#resetformdetails').hide();
         $('#registerformdetails').show();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#forgetpasswordbutton').click(function(){
        $('#loginformdetails').hide();
         $('#resetformdetails').show();
         $('#registerformdetails').hide();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetsignupbutton').click(function(){
         $('#loginformdetails').hide();
         $('#resetformdetails').hide();
         $('#registerformdetails').show();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetsignupbuttonreset').click(function(){
         $('#loginformdetails').hide();
         $('#resetformdetails').hide();
         $('#registerformdetails').show();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetsignupbuttonotp').click(function(){
         $('#loginformdetails').hide();
         $('#resetformdetails').hide();
         $('#registerformdetails').show();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetloginbutton').click(function(){
         $('#loginformdetails').show();
         $('#resetformdetails').hide();
         $('#registerformdetails').hide();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetloginbuttonreset').click(function(){
         $('#loginformdetails').show();
         $('#resetformdetails').hide();
         $('#registerformdetails').hide();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
      $('#resetloginbuttonotp').click(function(){
         $('#loginformdetails').show();
         $('#resetformdetails').hide();
         $('#registerformdetails').hide();
         $('#otpvalidationmatch').hide();
         $('#resetpasswordotpform').hide();
      });
   });
</script>
<script>
   $("#register_cus_name").keyup(function () {
   register_name_fun();
   });   
   function register_name_fun() {
      var register_name_value = $("#register_cus_name").val();
      if (register_name_value.length == '') {
         $('#register_cus_name_error').show();
         $("#register_cus_name_error").html("Enter Your Name");
         $('#register_cus_name_error').focus();
         $("#register_cus_name_error").css("color", "red");
         $("#register_cus_name").css("background-color", "white");
         $("#register_cus_name").css("color", "black");
         return false;
      } else {
   
      }
      if ((register_name_value.length < 3) || (register_name_value.length > 50)) {
         $('#register_cus_name_error').show();
         $("#register_cus_name_error").html("Name Must be 3 to 50 character");
         $('#register_cus_name_error').focus();
         $("#register_cus_name_error").css("color", "red");
         $("#register_cus_name").css("background-color", "white");
         $("#register_cus_name").css("color", "black");
         $("#register_cus_name").css("background-color", "white");
         return false;
      } else {
         $('#register_cus_name_error').show();
         $("#register_cus_name_error").html("");
         $('#register_cus_name_error').focus();
         $("#register_cus_name_error").css("color", "green");
         return true;
      }
   }
   $("#phone").keyup(function () {
   register_mobile_fun();
   });   
   function register_mobile_fun() {
      var register_mobile_value = $("#phone").val();
      if (register_mobile_value.length == '') {
         $('#register_cus_mobile_error').show();
         $("#register_cus_mobile_error").html("Enter Your mobile");
         $('#register_cus_mobile_error').focus();
         $("#register_cus_mobile_error").css("color", "red");
         $("#phone").css("background-color", "white");
         $("#phone").css("color", "black");
         return false;
      } else {
         $('#register_cus_mobile_error').show();
         $("#register_cus_mobile_error").html("");
         $('#register_cus_mobile_error').focus();
         return true;      
      }
   }
   $("#register_cus_email").keyup(function () {
   register_email_fun();
   });   
   function register_email_fun() {
      var register_email_value = $.trim($("#register_cus_email").val());
      if (register_email_value!='') {
         var register_email_value = $.trim($("#register_cus_email").val());
         var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
         if (register_email_value.length == '') {
            $("#register_cus_email_error").show();
            $("#register_cus_email_error").html("Enter Email Id");
            $("#register_cus_email_error").focus();
            $("#register_cus_email_error").css("color", "red");
            $("#register_cus_email").css("background-color", "white");
            $("#register_cus_email").css("color", "black");
            return false;
         } else {}
         if (!regex.test(register_email_value)) {
            $("#register_cus_email_error").show();
            $("#register_cus_email_error").html("Valid Email Address");
            $("#register_cus_email_error").focus();
            $("#register_cus_email_error").css("color", "red");
            $("#register_cus_email").css("background-color", "white");
            $("#register_cus_email").css("color", "black");
            return false;
         } else {
            $('#register_cus_email_error').show();
            $("#register_cus_email_error").html("");
            $('#register_cus_email_error').focus();
            $("#register_cus_email_error").css("color", "green");
            return true;
         }
      }else{
         return true;
      }
   
   }      
   $("#register_cus_password").keyup(function () {
   register_password_fun();
   });   
   function register_password_fun() {
      var register_password_value = $("#register_cus_password").val();
      if (register_password_value.length == '') {
         $('#register_cus_password_error').show();
         $("#register_cus_password_error").html("Enter Your password");
         $('#register_cus_password_error').focus();
         $("#register_cus_password_error").css("color", "red");
         $("#register_cus_password").css("background-color", "white");
         $("#register_cus_password").css("color", "black");
         return false;
      } else {
   
      }
      if ((register_password_value.length < 6) || (register_password_value.length > 20)) {
         $('#register_cus_password_error').show();
         $("#register_cus_password_error").html("password Must be 6 to 20 character");
         $('#register_cus_password_error').focus();
         $("#register_cus_password_error").css("color", "red");
         $("#register_cus_password").css("background-color", "white");
         $("#register_cus_password").css("color", "black");
         $("#register_cus_password").css("background-color", "white");
         return false;
      } else {
         $('#register_cus_password_error').show();
         $("#register_cus_password_error").html("");
         $('#register_cus_password_error').focus();
         $("#register_cus_password_error").css("color", "green");
         return true;
      }
   }
   var input = document.querySelector("#phone"),
   errorMsg = document.querySelector("#error-msg"),
   validMsg = document.querySelector("#valid-msg"),
   form = document.querySelector("#registerformdetails"),
   result = document.querySelector("#result");   
   var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
   
   var iti = window.intlTelInput(input, {
       container: 'body',
       autoHideDialCode: true,
       autoPlaceholder: "ON",
       dropdownContainer: document.body,
       formatOnDisplay: true,
       hiddenInput: "full_number",
       nationalMode: true,
       placeholderNumberType: "MOBILE",
       preferredCountries: ['AU'],
       separateDialCode: true,
       initialCountry: "auto",
        geoIpLookup: function(callback) {
          $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
            var countrynameaoutofetch = (resp && resp.country) ? resp.country : "us";
            callback(countrynameaoutofetch);
          });
        },
       utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
   });
   form.addEventListener("submit", function (e) {
   e.preventDefault();
   var register_cus_name = $('#register_cus_name').val();
   var register_cus_email = $('#register_cus_email').val();
   var register_cus_password = $('#register_cus_password').val();  
   var mobileNum = iti.getNumber();
   var mobileValid = iti.isValidNumber();
   var countryCode =iti.getSelectedCountryData().dialCode;
   register_name_fun();
   register_mobile_fun();
   register_email_fun();
   register_password_fun();
   if (register_name_fun() && register_mobile_fun() && register_email_fun() && register_password_fun() && mobileValid==true) {
   $.ajax({
      type:'post',
      dataType:'json',
      url:'<?php echo base_url(); ?>makeusernew',
      data:{
         register_cus_name:register_cus_name,
         mobileNum:mobileNum,
         mobileValid:mobileValid,
         countryCode:countryCode,
         register_cus_email:register_cus_email,
         register_cus_password:register_cus_password
      },
      success:function(response)
      {
         if (response.register_cus_name!='') {
            $('#register_cus_name_error').html(response.register_cus_name);
         }
   
         if (response.mobileNum!='') {
            $('#register_cus_mobile_error').html(response.mobileNum);
            $("#register_cus_mobile_error").css("color", "#f71e0e");
            $("#valid-msg").hide();
   
         }
   
         if (response.register_cus_email!='') {
            $('#register_cus_email_error').html(response.register_cus_email);
            $("#register_cus_email_error").css("color", "#f71e0e");
         }
   
         if (response.register_cus_password!='') {
            $('#register_cus_password_error').html(response.register_cus_password);
         }
   
         if (response.otp_sent_success) {
            $('#otpvalidationmatch').show();
            $('#loginformdetails').hide();
            $('#resetformdetails').hide();
            $('#registerformdetails').hide();
            $('#reg_otp_mobile_no').html(response.mobile_number);
         }
      }
   });
   }
   }, false);
   
   input.addEventListener("focus", function () {
   }, false);
   var reset = function () {
   input.classList.remove("error");
   errorMsg.innerHTML = "";
   errorMsg.classList.add("hide");
   validMsg.classList.add("hide");
   };
   
   input.addEventListener('blur', function () {
   reset();
   if (input.value.trim()) {
      if (iti.isValidNumber()) {
         validMsg.classList.remove("hide");
      } else {
         input.classList.add("error");
         var errorCode = iti.getValidationError();
         errorMsg.innerHTML = errorMap[errorCode];
         errorMsg.classList.remove("hide");
      }
   }
   });
   
   input.addEventListener('change', reset);
   input.addEventListener('keyup', reset);
</script>