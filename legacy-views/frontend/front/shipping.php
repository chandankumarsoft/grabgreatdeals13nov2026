<section class="main-container col2-right-layout">
   <div class="main container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12">
            <div class="page-content checkout-page">
               <div class="page-title">
                  <h2>Shipping</h2>
               </div>
               <h5 class="shipping_info" style="color: red;">
                  <?php echo validation_errors();?>
               </h5>
               <h4 class="checkout-sep">3. Shipping Information</h4>
               <div class="box-border">
                  <form action="<?php echo base_url()?>insert-shipping" method="post" name="shiping_info">
                     <ul>
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="cus_name" class="required">Name</label>
                              <input type="text" placeholder="Name" name="cus_name" value="<?php echo set_value('cus_name'); ?>" class="input form-control" id="cus_name">
                              <input type="hidden" name="cus_id" value="<?php echo $this->session->userdata("cus_id"); ?>">
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-6">
                              <label for="cus_email" class="required">Email</label>
                              <input type="text" placeholder="Email*" name="cus_email" value="<?php echo set_value('cus_email'); ?>" id="cus_email" class="input form-control">
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="cus_mobile">Mobile</label>
                              <input type="text" placeholder="Mobile" name="cus_mobile" value="<?php echo set_value('cus_mobile'); ?>" id="cus_mobile" class="input form-control">
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-6">
                              <label for="cus_address" class="required">Address</label>
                              <input type="text" placeholder="Address*" name="cus_address" value="<?php echo set_value('cus_address'); ?>" id="cus_address" class="input form-control">
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-xs-12">
                              <label for="cus_city" class="required">City</label>
                              <input type="text" placeholder="City" name="cus_city" value="<?php echo set_value('cus_city'); ?>" id="cus_city" class="input form-control">
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <!--/ [col] -->
                           <div class="col-sm-6">
                              <label class="required">Country</label>
                              <div class="custom_select">
                                 <select name="cus_country" class="input form-control">
                                    <option value="">Country</option>
                                    <?php 
                                       $country_data=$this->CountryModel->countries();
                                       foreach ($country_data as $country_data) {  ?>                                 
                                    <option value="<?php echo $country_data->name; ?>" <?php echo set_select('cus_country',"$country_data->name"); ?> ><?php echo $country_data->name; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="cus_state" class="required">State</label>
                              <input type="text" placeholder="State" name="cus_state" value="<?php echo set_value('cus_state'); ?>" id="cus_state" class="input form-control">
                           </div>
                        </li>
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="cus_zip" class="required">PinCode</label>
                              <input type="text" placeholder="Pin Code" name="cus_zip" value="<?php echo set_value('cus_zip'); ?>" id="cus_zip" class="input form-control">
                           </div>
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="cus_fax" class="required">Fax</label>
                              <input type="text" placeholder="Fax" name="cus_fax" value="<?php echo set_value('cus_fax'); ?>" id="cus_fax" class="input form-control">
                           </div>
                           <!--/ [col] -->
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                     </ul>
                     <input type="submit" value="Save & Continue" class="btn btn-primary button fa fa-angle-double-right">
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>