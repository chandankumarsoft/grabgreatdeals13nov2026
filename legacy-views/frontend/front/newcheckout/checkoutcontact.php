<style type="text/css">
   .form-control{
   height: 50px;
   }
</style>
<!-- Main Container -->
<section class="main-container col2-right-layout">
   <div class="main container">
      <div class="row">
         <div class="col-main col-sm-6 col-xs-12">
            <div class="page-content checkout-page">
               <h4 class="pull-left">Contact information</h4>
               <p class="pull-right">Already have an account?Log in</p>
               <form id="signUpFormCheckout">
                  <div class="box-border">
                     <ul>
                        <li class="row">
                           <div class="col-xs-12">                           
                              <input type="text" class="input form-control" name="account_email" id="account_email" placeholder="Email">
                              <span class="text-danger" id="account_email_error"></span>
                              <input type="checkbox" name="exclusive_offer" id="exclusive_offer" value="1">
                              <span>Sign up for exclusive offers and news via text messages & email.</span>           
                           </div>
                           <!--/ [col] -->
                        </li>
                     </ul>
                  </div>
                  <h4>Shipping address</h4>
                  <div class="box-border">
                     <ul>
                        <li class="row">
                           <div class="col-sm-6">
                              <label for="shipping_first_name"></label>
                              <input class="input form-control" type="text" name="shipping_first_name" id="shipping_first_name" placeholder="First Name">
                              <span class="text-danger" id="shipping_first_name_error"></span>
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-6">
                              <label for="shipping_last_name"></label>
                              <input class="input form-control" type="text" name="shipping_last_name" id="shipping_last_name" placeholder="Last Name">
                              <span class="text-danger" id="shipping_last_name_error"></span>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="shipping_company_name"></label>
                              <input class="input form-control" type="text" name="shipping_company_name" id="shipping_company_name" placeholder="Company Name (optional)">
                           </div>
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-xs-12">
                              <label for="shipping_address1" class="required"></label>
                              <input class="input form-control" type="text" name="shipping_address1" id="shipping_address1" placeholder="Address">
                              <span class="text-danger" id="shipping_address1_error"></span>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->                     
                        <li class="row">
                           <div class="col-xs-12">
                              <label for="shipping_address2" class="required"></label>
                              <input class="input form-control" type="text" name="shipping_address2" id="shipping_address2" placeholder="Apartment, suite, etc. (optional)">
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="shipping_city" class="required"></label>
                              <input class="input form-control" type="text" name="shipping_city" id="shipping_city" placeholder="City">
                              <span class="text-danger" id="shipping_city_error"></span>
                           </div>
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-4">
                              <label class="required" for="shipping_country"></label>
                              <div class="custom_select">
                                 <select class="input form-control" name="shipping_country" id="shipping_country">
                                    <option value="">--Country--</option>
                                    <?php
                                       $country_data=$this->db->select('*')->from('country')->where_in('id',[14,254,43,113,253])->get()->result();
                                       $indiaAvailable = false;
                                       foreach ($country_data as $country_option) {
                                          if ((int) $country_option->id === 113) {
                                             $indiaAvailable = true;
                                          } ?>
                                    <option
                                       value="<?php echo $country_option->id; ?>"
                                       <?php if ($country_option->id==$fetched_cus_info->cus_country) {
                                          echo "selected";
                                          } ?>
                                       ><?php echo $country_option->country; ?></option>
                                    <?php }
                                       if (! $indiaAvailable) { ?>
                                    <option value="113" <?php if (113 == $fetched_cus_info->cus_country) { echo "selected"; } ?>>India</option>
                                    <?php } ?>
                                 </select>
                                 <span class="text-danger" id="shipping_country_error"></span>
                              </div>
                           </div>
                           <script>
                              $('#shipping_country').on('change', function() {
                                $countriesID=this.value;
                                $.ajax({
                                 type:'POST',
                                 url:'<?php echo base_url(); ?>Country_controller_state',
                                 data:{country_id:$countriesID},
                                    success:function(successResponse){
                                       $('#shipping_state').html(successResponse);
                                    }
                                });
                              });
                           </script>
                           <!--/ [col] -->
                           <!--/ [col] -->
                           <div class="col-sm-4">
                              <label class="required" for="shipping_state"></label>
                              <div class="custom_select">
                                 <select class="input form-control" name="shipping_state" id="shipping_state">
                                    <option value="">State</option>
                                 </select>
                                 <span class="text-danger" id="shipping_state_error"></span>
                              </div>
                           </div>
                           <!--/ [col] -->
                           <div class="col-sm-4">
                              <label for="shipping_postal_code" class="required"></label>
                              <input class="input form-control" type="text" name="shipping_postal_code" id="shipping_postal_code" placeholder="Zip/Postal Code">
                              <span class="text-danger" id="shipping_postal_code_error"></span>
                           </div>
                           <!--/ [col] -->
                        </li>
                        <!--/ .row -->
                        <li class="row">
                           <div class="col-sm-12">
                              <label for="phone_for_exclusive_offer" class="required"></label>
                              <input class="input form-control" type="text" name="phone_for_exclusive_offer" id="phone_for_exclusive_offer" placeholder="Phone number for updates and exclusive offers.">
                              <span id="phone_for_exclusive_offer_error"></span>
                              <input type="checkbox" name="save_info_for_next_time" name="save_info_for_next_time" id="save_info_for_next_time" value="1">
                              <span>Save this information for next time</span>
                           </div>
                        </li>
                        <!--/ .row -->
                        <button class="button"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue to shipping</span></button>
                     </ul>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-main col-sm-6 col-xs-12">
            <?php $this->load->view('front/newcheckout/checkoutsidebar'); ?>
         </div>
      </div>
   </div>
</section>
<!-- Main Container End -->
<script>
   $("#signUpFormCheckout").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.    
      $.ajax({
           type: "POST",
           dataType: "json",
           url:'<?php echo base_url(); ?>checkouts-contact-save',
           data: $(this).serialize(), // serializes the form's elements.
           success: function(data)
           {
              if (data.account_email_error) {
               $('#account_email_error').html(data.account_email_error);
              }else{
               $('#account_email_error').html('');
              }


              if (data.shipping_first_name_error) {
               $('#shipping_first_name_error').html(data.shipping_first_name_error);
              }else{
               $('#shipping_first_name_error').html('');
              }


              if (data.shipping_last_name_error) {
               $('#shipping_last_name_error').html(data.shipping_last_name_error);
              }else{
               $('#shipping_last_name_error').html('');
              }


              if (data.shipping_address1_error) {
               $('#shipping_address1_error').html(data.shipping_address1_error);
              }else{
               $('#shipping_address1_error').html('');
              }


              if (data.shipping_city_error) {
               $('#shipping_city_error').html(data.shipping_city_error);
              }else{
               $('#shipping_city_error').html('');
              }



              if (data.shipping_country_error) {
               $('#shipping_country_error').html(data.shipping_country_error);
              }else{
               $('#shipping_country_error').html('');
              }


              if (data.shipping_state_error) {
               $('#shipping_state_error').html(data.shipping_state_error);
              }else{
               $('#shipping_state_error').html('');
              }



              if (data.shipping_postal_code_error) {
               $('#shipping_postal_code_error').html(data.shipping_postal_code_error);
              }else{
               $('#shipping_postal_code_error').html('');
              }

               if (data.status=='ok') {
                  window.location.href = "checkouts-shipping";
               }
           }
      });    
   });
</script>