
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboad Template</title>
  <!-- Core CSS - Include with every page -->
  <link href="<?php echo base_url()?>assets/back/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/back/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/back/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/back/css/style.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/back/css/main-style.css" rel="stylesheet" />

</head>

<body class="body-Login-back">

    <div class="container">

        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <!--<img src="<?php //  echo base_url()?>assets/back/img/logo.png" alt=""/>-->
          </div>
          <div class="col-md-4 col-md-offset-4">
            <div class=""><img alt="responsive theme logo" src="<?php echo  base_url(); ?>assets/front/images/logo/final-logo.png" style="margin: 20px 0px -30px 60px"></div>
            <div class="login-panel panel panel-default">                  
                <div class="panel-heading">
                      <p class="text-success"> 
                     <?php
                          if(isset($success_message)){
                         echo $success_message;
                     }?>
                     </p>
                    <h3 class="panel-title">Sign Up</h3>
                    <p class="text-danger"> 
                     <?php
                          if(isset($error_message)){
                         echo $error_message;
                     }?>
             </p>
         </div>
         <div class="panel-body">
            <form role="form" action="<?php echo base_url();?>admin-signup" method="post">
                <fieldset>
                    <div class="form-group">
                       <label>Admin Name</label>
                        <input class="form-control" placeholder="Name" name="name" type="text" value="<?php echo set_value('name'); ?>">
                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                    </div>
                    <div class="form-group">
                      <label>Admin Email</label>
                        <input class="form-control" placeholder="E-mail" name="email" type="email" value="<?php echo set_value('email'); ?>">
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                    <div class="form-group">
                      <label>Admin Mobile</label>
                        <input class="form-control" placeholder="Mobile" name="mobile" type="text" value="<?php echo set_value('mobile'); ?>">
                        <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                    </div>
                    <div class="form-group">
                      <label>Admin Role</label>
                        <select name="adminrole" class="form-control">
  <option value="video editor">video editor</option>

</select>
                    </div>
                    <div class="form-group">
                      <label>Admin Password</label>
                        <input class="form-control" placeholder="Password" name="password" type="password" value="<?php echo set_value('password'); ?>">
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                    </div>

                    <button class="btn btn-lg btn-success btn-block" type="submit" style="background-color: #332d2d;
    border-color: #f9f72d;">Sign Up</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<!-- Core Scripts - Include with every page -->
<script src="<?php echo base_url()?>assets/back/plugins/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/back/plugins/metisMenu/jquery.metisMenu.js"></script>

</body>
</html>
