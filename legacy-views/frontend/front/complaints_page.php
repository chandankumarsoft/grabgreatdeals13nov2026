<section class="main-container col1-layout">
   <div class="main container">
      <div class="row">
         <section class="col-main col-sm-12">
            <div id="contact" class="page-content page-contact">
               <div class="page-title">
                  <h2>COMPLAINTS</h2>
               </div>
               <div id="message-box-conact">Grab Great Deals delivers consistence level of customer service but if you are not happy with our service you can share your grievance with us here!  We ask your pardon for this inconvenience. Our solution is the quickest! </div>
               <div class="row">
                  <div class="col-xs-12 col-sm-6" id="contact_form_map">
                     <h3 class="page-subheading">Inscribe your complaint! </h3>
                     <p>If you are dealing with an issue regarding any purchase order at Grab Great Deals or not at all happy with the service then give us the chance to resolve your problem! Our team is prompt to provide the best solution to your problem! </p>
                     <h3 class="page-subheading">Get a reference number </h3>
                     <p>As soon as you register your complaint, you will get a reference number. This number will help you to track the complaint progress and action taken by the company. We will get back to within 1-3 working days and surely resolve your problem. </p>
                     <h3 class="page-subheading">Solving your issue </h3>
                     <p>Our team works rapidly to solve your issue. We solve your issue within 3-14days after the complaint gets registered.  We consider your issue to be ours! Resolving your problem is the utmost important job!</p>
                     <br>
                     <p>Urgent problem is given prior preference. </p>
                  </div>
                  <div class="col-sm-6">
                     <h3 class="page-subheading">Complain Details </h3>
                     <div style="color: green;"><?php if ($this->session->flashdata('success_message') != ''):
                        echo $this->session->flashdata('success_message');
                        endif; ?></div>
                     <div class="contact-form-box">
                        <form action="<?php echo base_url(); ?>complaints" method="post">
                           <div class="form-selector">
                              <label>Name</label>
                              <input type="text" class="form-control input-sm" name="complaint_name" id="complaint_name" value="<?php echo set_value('complaint_name'); ?>" />
                              <span class="text-danger"><?php echo form_error('complaint_name'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Registered email I’d </label>
                              <input type="email" class="form-control input-sm" name="complaint_email" id="complaint_email" value="<?php echo set_value('complaint_email'); ?>" />
                              <span class="text-danger"><?php echo form_error('complaint_email'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Subject </label>
                              <input type="text" class="form-control input-sm" name="complaint_subject" id="complaint_subject" value="<?php echo set_value('complaint_subject'); ?>" />
                              <span class="text-danger"><?php echo form_error('complaint_subject'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Complaint </label>
                              <textarea class="form-control input-sm" rows="10" name="complaint_message" id="complaint_message" style="height: 100px;">
                              <?php echo set_value('complaint_message'); ?>
                              </textarea>
                              <span class="text-danger"><?php echo form_error('complaint_message'); ?></span>
                           </div>
                           <div class="form-selector">
                              <p>Are you a customer?</p>
                              <input type="radio" name="complaint_customer" id="yes" value="yes">
                              <label for="yes">yes</label><br>
                              <input type="radio"  name="complaint_customer" id="no" value="no">
                              <label for="no">No</label>
                              <span class="text-danger"><?php echo form_error('complaint_customer'); ?></span>
                           </div>
                           <div class="form-selector">
                              <button type="submit" class="button"><span>Submit</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</section>