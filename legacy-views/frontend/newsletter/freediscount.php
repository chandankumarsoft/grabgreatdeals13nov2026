<!-- Mobile specific metas  , -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicon  -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<!-- Google Fonts -->
<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700italic,700,400italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Dosis:400,300,200,500,600,700,800' rel='stylesheet' type='text/css'>
<!-- CSS Style -->
<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/bootstrap.min.css">
<!-- font-awesome & simple line icons CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/font-awesome.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/simple-line-icons.css" media="all">
<!-- owl.carousel CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/owl.theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/owl.transitions.css">
<!-- animate CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/animate.css" media="all">
<!-- flexslider CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/flexslider.css" >
<!-- jquery-ui.min CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/jquery-ui.css">
<!-- Revolution Slider CSS -->
<link href="<?php echo base_url();?>assets/front/css/revolution-slider.css" rel="stylesheet">
<!-- style CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/style.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/blog.css" media="all">
<link rel="icon" href="<?php echo base_url()?>assets/front/images/logo/final-logo.png" type="image/gif">
<!-- quick_view_popup CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/quick_view_popup.css" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/util.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/logincss/fonts/iconic/css/material-design-iconic-font.min.css">
<script src="<?php echo base_url();?>assets/front/js/jquery.min.js"></script>
<style>
   .separate-dial-code{
   width:100%;
   }
</style>
<section class="main-container col1-layout" style="padding:0px;">
   <div class="main container">
      <div class="limiter">
         <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-5 p-b-54">
               <form class="login100-form validate-form" id="free_discount_form_id" method="post">
                  <span class="login100-form-title p-b-5">
                  <a href="<?php echo base_url(); ?>">
                  <img alt="responsive theme logo" src="<?php echo base_url(); ?>assets/front/images/logo/final-logo.png">
                  </a>
                  </span>
                  <div id="data_submit_status_success"></div>
                  <div id="form_credentials_error"></div>   
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="text" id="free_discount_fname" placeholder="Type your First Name">
                     <span class="focus-input100" id="free_discount_fname_error" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="wrap-input100 validate-input m-b-23">
                     <input class="input100" type="text" id="free_discount_lname" placeholder="Type your Last Name">
                     <span class="focus-input100" id="free_discount_lname_error" data-symbol="&#xf206;"></span>
                  </div>
                  <div class="wrap-input100 validate-input">
                     <input class="input100" type="text" id="free_discount_email" placeholder="Type your Email">
                     <span class="focus-input100" id="free_discount_email_error" data-symbol="&#xf15a;"></span>
                  </div>
                  <div class="text-right p-t-8 p-b-31">
                  </div>
                  <div class="container-login100-form-btn p-t-8 p-b-31">
                     <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn" style="background-color:#fe0100;"></div>
                        <button class="login100-form-btn" type="submit">
                        submit
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
   $('#free_discount_form_id').on('submit', function (event) {
      event.preventDefault();
      let free_discount_fname = $('#free_discount_fname').val();
      let free_discount_lname = $('#free_discount_lname').val();
      let free_discount_email  = $('#free_discount_email').val();
      $.ajax({
         type:'post',
         dataType:'json',
         url:'<?php echo base_url(); ?>discount-form-free',
         data:{
                 free_discount_fname:free_discount_fname,
                 free_discount_lname:free_discount_lname,
                 free_discount_email:free_discount_email
               },
         success:function(response)
         {
            if (response.free_discount_fname_error!='') {
             $('#free_discount_fname_error').html(response.free_discount_fname_error).css('color','#ff0000');
            }else{
              $('#free_discount_fname_error').html('');
            }

            if (response.free_discount_lname_error!='') {
             $('#free_discount_lname_error').html(response.free_discount_lname_error).css('color','#ff0000');
            }else{
              $('#free_discount_lname_error').html('');
            }                           

            if (response.free_discount_email_error!='') {
             $('#free_discount_email_error').html(response.free_discount_email_error).css('color','#ff0000');
            }else{
              $('#free_discount_email_error').html('');
            }

            if (response.data_submit_status) {                                 
               $('#data_submit_status_success').html('<div class="alert alert-success" alert-dismissible role="alert">'
                 +response.data_submit_status+
               '</div>');
               $('#free_discount_form_id')[0].reset();                              
            }
         }
      });
   });
</script>