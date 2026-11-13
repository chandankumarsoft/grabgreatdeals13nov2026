<section class="main-container col1-layout">
   <div class="main container">
      <div class="row">
         <section class="col-main col-sm-12">
            <div id="contact" class="page-content page-contact">
               <div class="page-title">
                  <h1>SUBMIT <span class="text_color">YOUR INTEREST</span></h1>
               </div>
               <div class="col-xs-12 col-sm-12">
                  <h3 class="page-subheading">Please provide the following details</h3>
                  <?php
                     if($this->session->flashdata('success'))
                     {
                     echo '<div class="alert alert-success hidemessage" role="alert">'.$this->session->flashdata('success').'</div>';
                     echo '<script>
                     setTimeout(function() { $(".hidemessage").hide(); }, 3000);
                     </script>';
                     }
                     ?>
                  <div class="contact-form-box">
                     <form action="<?php echo base_url(); ?>applicant-save" method="post">
                        <div class="form-selector">
                           <label>Name</label>
                           <input type="text" class="form-control input-sm" name="applicant_full_name" value="<?php echo set_value('applicant_full_name'); ?>" id="applicant_full_name" />
                           <span class="text-danger"><?php echo form_error('applicant_full_name'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Email</label>
                           <input type="text" class="form-control input-sm" name="applicant_email" value="<?php echo set_value('applicant_email'); ?>" id="applicant_email" />
                           <span class="text-danger"><?php echo form_error('applicant_email'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Phone</label>
                           <input type="text" class="form-control input-sm" name="applicant_phone" value="<?php echo set_value('applicant_phone'); ?>" id="applicant_phone" />
                           <span class="text-danger"><?php echo form_error('applicant_phone'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Company</label>
                           <input type="text" class="form-control input-sm" name="applicant_company_name" value="<?php echo set_value('applicant_company_name'); ?>" id="applicant_company_name" />
                           <span class="text-danger"><?php echo form_error('applicant_company_name'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>ABN</label>
                           <input type="text" class="form-control input-sm" name="applicant_abn" value="<?php echo set_value('applicant_abn'); ?>" id="applicant_abn" />
                        </div>
                        <div class="form-selector">
                           <label>Message</label>
                           <textarea class="form-control input-sm" rows="10" name="applicant_message" id="applicant_message">
                           <?php echo set_value('applicant_message'); ?>
                           </textarea>
                           <span class="text-danger"><?php echo form_error('applicant_message'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Country</label>
                           <select class="form-control" name="applicant_country" id="applicant_country">
                              <option value="">--Country--</option>
                              <?php 
                                 $countryDetails=$this->db->select('*')->from('country')->get()->result();
                                 foreach ($countryDetails as $countryDetailsvalue) { ?>
                              <option value="<?php echo $countryDetailsvalue->id; ?>"><?php echo $countryDetailsvalue->country; ?></option>
                              <?php } ?>
                           </select>
                           <span class="text-danger"><?php echo form_error('applicant_country'); ?></span>
                        </div>
                        <script>
                           $('#applicant_country').on('change', function() {
                             $countriesID=this.value;
                             $.ajax({
                              type:'POST',
                              url:'<?php echo base_url(); ?>Country_controller_state',
                              data:{country_id:$countriesID},
                                 success:function(successResponse){
                                 $('#applicant_state').html(successResponse);
                              }
                             });
                           });
                        </script>
                        <div class="form-selector">
                           <label>Region /State</label>
                           <select class="form-control" name="applicant_state" id="applicant_state">
                              <option value="">--select country first--</option>
                           </select>
                           <span class="text-danger"><?php echo form_error('applicant_state'); ?></span>
                        </div>
                        <script>
                           $('#applicant_state').on('change', function() {
                             $stateID=this.value;
                             $.ajax({
                              type:'POST',
                              url:'<?php echo base_url(); ?>Country_controller_city',
                              data:{state_id:$stateID},
                                 success:function(successResponse){
                                 $('#applicant_city').html(successResponse);
                              }
                             });
                           });
                        </script>
                        <div class="form-selector">
                           <label>City</label>
                           <select class="form-control" name="applicant_city" id="applicant_city">
                              <
                              <option value="">--select state first--</option>
                           </select>
                           <span class="text-danger"><?php echo form_error('applicant_city'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Address</label>
                           <input type="text" class="form-control input-sm" name="applicant_address" value="<?php echo set_value('applicant_address'); ?>" id="applicant_address" />
                           <span class="text-danger"><?php echo form_error('applicant_address'); ?></span>
                        </div>
                        <div class="form-selector">
                           <label>Pincode/Zip</label>
                           <input type="text" class="form-control input-sm" name="applicant_zip" value="<?php echo set_value('applicant_zip'); ?>" id="applicant_zip" />
                           <span class="text-danger"><?php echo form_error('applicant_zip'); ?></span>
                        </div>
                        <div class="form-selector">
                           <button class="button" type="submit"> <span>Save</span></button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</section>