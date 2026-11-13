<style>
   ic {
   color: #fafafa;
   font-size: 30px;
   ;
   line-height: 60px;
   margin-left: 16px;
   }
   .book_p {
   color: #8a8686;
   text-align: center;
   font-size: 18px;
   margin: 15px 0px 10px 0px;
   }
   .all {
   padding: 15px 0px 40px 0px;
   }
</style>
<div class="container all">
   <div style="border-radius:200px; height:55px; width:55px; background: #6dab10; margin:0 auto;">
      <ic class="checkmark">
      ✓</i>
   </div>
   <p class="book_p">Booking Ref.Total payable amount : <?php echo currencyConverterFunction($this->session->userdata("g_total")); ?></p>
   <h3 class="text-center">Dear <?php echo $this->session->userdata("cus_name"); ?></h3>
   <h4 class="text-center">Your Order Successfully complete....</h4>
   <p class="text-center">We received your purchase request;<br /> we'll be in touch shortly!</p>
   <h5 class="text-center">Total payable amount : <?php echo currencyConverterFunction($this->session->userdata("g_total")); ?><br><a href="<?php echo base_url(); ?>"> Click Here</a><br></h5>
</div>