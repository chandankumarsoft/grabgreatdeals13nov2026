<?php
   $fetched_cus_info=$this->db->select('*')->from('tbl_customer')->where('cus_id',$this->session->userdata('cus_id'))->get()->row();
?>
<link rel="stylesheet" href="https://demos.codexworld.com/international-telephone-input-with-country-flags-dial-codes-jquery/css/intlTelInput.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/countrylist/js/intlTelInput.js"></script>
<script src="https://demos.codexworld.com/international-telephone-input-with-country-flags-dial-codes-jquery/js/intlTelInput.js"></script>
<style>
   .separate-dial-code{
   width:100%;
   }
</style>
<div class="panel">
   <div class="panel-heading" id="step_bill">
      <h4 class="panel-title"><a data-toggle="collapse" id="bill_link" href="#step2">01. BILLING ADDRESS</a></h4>
   </div>
   <div id="step2" data-parent="#checkoutAccordion" class="panel-collapse collapse">
      <div class="panel-body step_bill">
         <form action="<?php echo base_url()?>update-billing" method="post" name="billing_info" id="billing_info_form">
            <div class="panel-body-inside">
               <label class="text-uppercase" for="billing_cus_name">Name:</label>
               <div class="form-group">
                  <input type="text" placeholder="Name" name="billing_cus_name" id="billing_cus_name" class="form-control" value="<?php echo $fetched_cus_info->cus_name?>">
                  <input type="hidden" id="hidden_cus_id" name="hidden_cus_id" value="<?php echo $fetched_cus_info->cus_id; ?>">
                  <input type="hidden" name="hidden_dublicacy" id="hidden_dublicacy" value="<?php echo time().mt_rand(1000,9999); ?>">
                  <span id="billing_name_error"></span>
               </div>
               <label class="text-uppercase" for="billing_cus_email">Email:</label>
               <div class="form-group">
                  <input type="text" placeholder="Email*" name="billing_cus_email" id="billing_cus_email" class="form-control" value="<?php echo $fetched_cus_info->cus_email?>">
                  <span id="billing_email_error"></span>
               </div>
               <link rel="stylesheet" href="https://demos.codexworld.com/international-telephone-input-with-country-flags-dial-codes-jquery/css/intlTelInput.css">
               <label class="text-uppercase" for="billing_cus_mobile">Mobile:</label>
               <div class="form-group">
                  <input type="tel" id="billingphone" class="form-control" value="<?php //echo $fetched_cus_info->cus_mobile_full_no;?>">
                  <input type="hidden" name="billing_mobile_number" id="billing_mobile_number">
                  <span id="billing_mobile_error"></span>
                  <span id="billingvalidmsg" class="hide">✓ Valid</span>
                  <span id="billingerrormsg" class="hide" style="color:red;"></span> 
               </div>
               <label class="text-uppercase" for="billing_cus_address">Address:</label>
               <div class="form-group">
                  <textarea name="billing_cus_address" id="billing_cus_address" class="form-control" cols="10" rows="5" placeholder="Address*"><?php echo $fetched_cus_info->cus_address?></textarea>
                  <span id="billing_address_error"></span>
               </div>
               <label class="text-uppercase" for="billing_cus_city">City:</label>
               <div class="form-group">
                  <input type="text" placeholder="City*" name="billing_cus_city" id="billing_cus_city" class=" form-control" value="<?php echo $fetched_cus_info->cus_city?>">
                  <span id="billing_city_error"></span>
               </div>
               <label class="text-uppercase">Country:</label>
               <div class="form-group select-wrapper">
                  <select class="form-control" name="billing_cus_country" id="billing_cus_country">
                     <option value="">--Country--</option>
                     <?php
                        $country_data=$this->CountryModel->countries();
                        foreach ($country_data as $country_data) {  ?>
                     <option
                        value="<?php echo $country_data->id; ?>"
                        <?php if ($country_data->id==$fetched_cus_info->cus_country) {
                           echo "selected";
                           } ?>
                        ><?php echo $country_data->country; ?></option>
                     <?php } ?>
                  </select>
                  <span id="billing_cus_country_error"></span>
               </div>
               <script>
                  $('#billing_cus_country').on('change', function() {
                    $countriesID=this.value;
                    $.ajax({
                     type:'POST',
                     url:'<?php echo base_url(); ?>Country_controller_state',
                     data:{country_id:$countriesID},
                        success:function(successResponse){
                           $('#billing_cus_state').html(successResponse);
                           $('#shipping_cus_state').html(successResponse);
                        }
                    });
                  });
               </script>
               <div class="row">
                  <div class="col-sm-6">
                     <label class="text-uppercase">State:</label>
                     <div class="form-group select-wrapper">
                        <select class="form-control"name="billing_cus_state" id="billing_cus_state">
                           <option value="">--select country first--</option>
                        </select>
                        <span id="billing_cus_state_error"></span>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <label class="text-uppercase">postal code:</label>
                     <div class="form-group"><input type="text" name="billing_cus_zip" id="billing_cus_zip" value="<?php echo $fetched_cus_info->cus_zip;?>" class="form-control"></div>
                     <span id="billing_cus_zip_error"></span>
                  </div>
               </div>
               <div class="text-right mt-2">
                  <button type="button" class="btn btn-sm step-next-accordion-123" onclick="submitbilling(2);">Continue</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   var billingphoneinput = document.querySelector("#billingphone"),
     billingerrorMsg = document.querySelector("#billingerrormsg"),
     billingvalidMsg = document.querySelector("#billingvalidmsg");
   
   var billingerrorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
   
   var billingintl = window.intlTelInput(billingphoneinput, {
     container: 'body',
           autoHideDialCode: true,
           autoPlaceholder: "ON",
           dropdownContainer: document.body,
           formatOnDisplay: true,
           nationalMode: true,
           placeholderNumberType: "MOBILE",
           preferredCountries: ['IN'],
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
   var billingreset = function() {
     billingphoneinput.classList.remove("error");
     billingerrorMsg.innerHTML = "";
     billingerrorMsg.classList.add("hide");
     billingvalidMsg.classList.add("hide");
   };
   
   billingphoneinput.addEventListener('blur', function() {
     billingreset();
     if(billingphoneinput.value.trim()){
         if(billingintl.isValidNumber()){
             billingvalidMsg.classList.remove("hide");
         }else{
             billingphoneinput.classList.add("error");
             var billingerrorCode = billingintl.getValidationError();
             billingerrorMsg.innerHTML = billingerrorMap[billingerrorCode];
             billingerrorMsg.classList.remove("hide");
         }
     }
   });
   
   billingphoneinput.addEventListener('change', billingreset);
   billingphoneinput.addEventListener('keyup', billingreset);
</script>