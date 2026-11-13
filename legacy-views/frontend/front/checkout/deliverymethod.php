<div class="panel">
   <div class="panel-heading" id="step_method">
      <h4 class="panel-title"><a data-toggle="collapse" id="method_link" href="#step4">03. SHIPPING CHARGE</a></h4>
   </div>
   <div id="step4" data-parent="#checkoutAccordion" class="panel-collapse collapse">
      <div class="panel-body step_method">
         <div class="panel-body-inside">
            <?php
               $cart_content_shipping = $this->cart->contents();
            ?>
            <?php
               $shipping_amount_summary_value=0;
            foreach ($cart_content_shipping as $summaryitems) {
               $summary_shipping_amount_select=$this->db->select('shipping_amount')->from('tbl_shipping_charge')->where('id',$summaryitems['shipping_method'])->get()->row();
               $shipping_amount_summary_value+=$summary_shipping_amount_select->shipping_amount;
            }
            ?>
            <form id="">
               <div class="clearfix">
                  <input id="formcheckoutRadio1" value="" name="radio1" type="radio" class="radio" checked="checked">
                  <label for="formcheckoutRadio1">TOTAL SHIPPING CHARGE (<?php echo currencyConverterFunction($shipping_amount_summary_value); ?>)</label>
               </div>
               <div class="text-right">
                  <button type="button" class="btn btn-sm step-next-accordion-123" onclick="submitmethod(4)">Continue</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>