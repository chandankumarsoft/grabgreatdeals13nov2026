<section class="main-container col1-layout">
   <div class="main container">
      <div class="row">
         <section class="col-main col-sm-12">
            <div id="contact" class="page-content page-contact">
               <div class="page-title">
                  <h2>Contact Us</h2>
               </div>
               <div id="message-box-conact">If you would like to speak to us directly or provide us feedback and help us to improve then please contact us. We value your input! </div>
               <div class="row">
                  <div class="col-xs-12 col-sm-6" id="contact_form_map">
                     <h3 class="page-subheading">Just stop by and say Hello!
                     </h3>
                     <p>Grab Great Deal tries to provide the best service to its customers. We concentrate on the quality, assistance and customer satisfaction. We have introduced a more valuable, less invasive way to shop online.</p>
                     <br/>
                     <P>If you have a question or concern regarding Grab Great Deals you can give us feedback. You can also contact us by email or phone.
                        To get more information contact us on these numbers or call us at :
                     </P>
                     <br/>
                     <ul class="store_info">
                        <li><i class="fa fa-map-marker"></i>FMT INFOTECH PVT LTD<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2/5 Chittaranjan Colony Road Bagha Jatin Kolkata -700092, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INDIA</li>
                        <br>
                        <li><i class="fa fa-map-marker"></i>GrabGreatDeals LLC<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1309 Coffeen Ave STE 1200 Sheridan, WY 82801, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USA</li>
                        <br>
                        <!--<li><i class="fa fa-map-marker"></i>FMT INFOTECH PTY LTD<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 1, 8 Beulah Road, Norwood SA 5067, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AUSTRALIA</li>-->
                        <!--<br>-->
               <li><i class="fa fa-phone"></i><span><a href="tel:+61488847228">+61 488 847 228</a> / <a href="tel:+13343453326">+1 334 345 3326</a></span></li>
                        <li><i class="fa fa-envelope"></i><span><a href="mailto:support@grabgreatdeals.com.au">support@grabgreatdeals.com.au</a></span></li>
                     </ul>
                  </div>
                  <div class="col-sm-6">
                     <h3 class="page-subheading">Make an enquiry</h3>
                     <?php echo $this->session->flashdata("flash_msg");?>
                     <div class="status alert alert-success" style="display: none"></div>
                     <form action="<?php echo base_url()?>contact-form" method="post">
                        <div class="contact-form-box">
                           <div class="form-selector">
                              <label>Name</label>
                              <input type="text" class="form-control input-sm" name="contact_name" id="contact_name" placeholder="Name" value="<?php echo set_value('contact_name'); ?>" />
                              <span style="color:red;"><?php echo form_error('contact_name'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Email</label>
                              <input type="text" class="form-control input-sm" name="contact_email" id="contact_email" placeholder="Email" value="<?php echo set_value('contact_email'); ?>" />
                              <span style="color:red;"><?php echo form_error('contact_email'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Subject</label>
                              <input type="text" class="form-control input-sm" name="contact_subject" id="contact_subject" value="<?php echo set_value('contact_subject'); ?>" />
                              <span style="color:red;"><?php echo form_error('contact_subject'); ?></span>
                           </div>
                           <div class="form-selector">
                              <label>Message</label>
                              <textarea style="height:135px;" class="form-control input-sm" rows="10" name="contact_message" id="message"><?php echo set_value('contact_message'); ?></textarea>
                              <span style="color:red;"><?php echo form_error('contact_message'); ?></span>
                           </div>
                           <div class="form-selector">
                              <button class="button" type="submit"><i class="fa fa-send"></i>&nbsp; <span>Send Message</span></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</section>