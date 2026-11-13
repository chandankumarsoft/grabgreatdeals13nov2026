<div class="panel">
   <div class="panel-heading" id="step_payment" style="background-color:#f8f8f885">
      <h4 class="panel-title">
         <a data-toggle="collapse" id="pay_link" href="#step5">04. PAYMENT METHOD</a>
      </h4>
   </div>
   <style>
      input::placeholder {
      color: #c1bbbb !important;
      }
      .star-font-color{
      color: red;
      font-weight: 700;
      border: 0!important;
      text-decoration: none;
      font-size: large;
      }
      .row-padding{
      padding: 10px;
      }                        
   </style>
   <script src="https://js.stripe.com/v3/"></script>
   <div id="step5" data-parent="#checkoutAccordion" class="panel-collapse collapse">
      <div class="panel-body step_payment" style="background-color:#fafafa">
         <div class="panel-body-inside">
            <div class="clearfix">
               <input id="formcheckoutRadio4" value="stripe_payment" name="payment_method_input_name" type="radio" class="radio" checked="checked">
               <label for="formcheckoutRadio4">Debit/Credit Card</label>
               <img src="https://www.seller.grabgreatdeals.com/assets/front/images/cart/visa.png" class="all_pay">
               <img src="https://www.seller.grabgreatdeals.com/assets/front/images/cart/Americanexpress.png" class="all_pay">
               <img src="https://www.seller.grabgreatdeals.com/assets/front/images/cart/mastercard.png" class="all_pay">
            </div>
            <div>
               <form id="payment-form">
                  <div class="form-group">
                     <p>Pay Via Debit/Credit Card.</p>
                  </div>
                  <div class="form-group">
                     <label class="font-weight-bold">Full Name</label>
                     <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name">
                  </div>
                  <div class="form-group">
                     <label class="font-weight-bold">Email</label>
                     <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                     <label class="font-weight-bold">Card Details</label>
                     <div id="card-element" style="background-color: white;border: #dddfe5 1px solid;padding: 10px;">
                     </div>
                     <div id="card-errors" role="alert" class="p-3 mb-2 text-white" style="background-color: #fb641b;
                        color: white;
                        text-align: center;
                        margin-top: 10px;
                        "></div>
                  </div>
                  <div class="form-group">
                     <button id="submit" class="btn btn-block btn-success">Place Order</button>
                  </div>
               </form>
               <div>
                  <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="<?php echo base_url(); ?>privacy-policy">privacy policy.</a></p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>