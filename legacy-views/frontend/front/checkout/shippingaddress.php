<div class="panel">
   <div class="panel-heading" id="step_ship">
      <h4 class="panel-title"><a data-toggle="collapse" id="ship_link" href="#step3">02. SHIPPING ADDRESS</a></h4>
   </div>
   <div id="step3" data-parent="#checkoutAccordion" class="panel-collapse collapse">
      <style>
         .checkboxes {
         display: flex;
         vertical-align: middle;
         word-wrap: break-word;
         }
      </style>
      <div class="col-sm-6 text-left" style="padding:0px;">
         <label for="sameasshipping" class="checkboxes">
         <input type="checkbox" id="sameasshipping" class="checkboxes" style="display: block;" />
         same as billing address.</label>
      </div>
      </br>
      <div class="panel-body step_ship">
         <form action="<?php echo base_url()?>insert-shipping" method="post" name="shipping_info_form" id="shipping_info_form">
            <div class="panel-body-inside">
               <label class="text-uppercase" for="shipping_cus_name">Name:</label>
               <div class="form-group">
                  <input type="text" placeholder="Name" name="shipping_cus_name" class="form-control" id="shipping_cus_name">
                  <span id="shipping_name_error"></span>
               </div>
               <label class="text-uppercase" for="shipping_cus_email">Email:</label>
               <div class="form-group">
                  <input type="text" placeholder="Email*" name="shipping_cus_email" id="shipping_cus_email" class="form-control">
                  <span id="shipping_email_error"></span>
               </div>
               <label class="text-uppercase" for="shipping_cus_address">Address:</label>
               <div class="form-group">
                  <input type="hidden" placeholder="Mobile" name="shipping_mobile_number" id="shipping_mobile_number" class="form-control">
                  <textarea name="shipping_cus_address" id="shipping_cus_address" class="form-control" cols="10" rows="5" placeholder="Address*"></textarea>
                  <span id="shipping_address_error"></span>
               </div>
               <label class="text-uppercase" for="shipping_cus_city">City:</label>
               <div class="form-group">
                  <input type="text" placeholder="City" name="shipping_cus_city" id="shipping_cus_city" class="form-control">
                  <span id="shipping_city_error"></span>
               </div>
               <label class="text-uppercase">Country:</label>
               <div class="form-group select-wrapper">
                  <select class="form-control" name="shipping_cus_country" id="shipping_cus_country">
                     <option value="">Country</option>
                     <?php
                        $country_data=$this->CountryModel->countries();
                        foreach ($country_data as $country_data) {  ?>
                     <option value="<?php echo $country_data->id; ?>" <?php echo set_select('cus_country',"$country_data->country"); ?> ><?php echo $country_data->country; ?></option>
                     <?php } ?>
                  </select>
                  <span id="shipping_cus_country_error"></span>
               </div>
               <script>
                  $('#shipping_cus_country').on('change', function() {
                    $countriesID=this.value;
                    $.ajax({
                     type:'POST',
                     url:'<?php echo base_url(); ?>Country_controller_state',
                     data:{country_id:$countriesID},
                        success:function(successResponse){
                        $('#shipping_cus_state').html(successResponse);
                     }
                    });
                  });
               </script>
               <div class="row">
                  <div class="col-sm-6">
                     <label class="text-uppercase">State:</label>
                     <div class="form-group select-wrapper">
                        <select class="form-control"name="shipping_cus_state" id="shipping_cus_state">
                           <option value="">--select country first--</option>
                        </select>
                        <span id="shipping_cus_state_error"></span>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <label class="text-uppercase" for="shipping_cus_zip">postal code:</label>
                     <div class="form-group">
                        <input type="text" name="shipping_cus_zip" id="shipping_cus_zip" class="form-control">
                     </div>
                     <span id="shipping_cus_zip_error"></span>
                  </div>
               </div>
               <div class="text-right mt-2">
                  <button type="button" class="btn btn-sm step-next-accordion-123" onclick="submitshiping(3);">Continue</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>