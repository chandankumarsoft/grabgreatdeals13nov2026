<?php $all_slider = $this->db->select('baner_name,baner_link,baner_text')->from('tbl_baner')->order_by('baner_id','RANDOM')->get()->result(); ?>
<!-- Home Slider Start -->
<div class="slider hidden-xs">
   <div class="tp-banner-container clearfix">
      <div class="tp-banner" >
         <ul>
            <!-- SLIDE 1 -->
         <?php 
           foreach ($all_slider as $slider) {   
         ?>
            <li data-transition="slidehorizontal" data-slotamount="5" data-masterspeed="10" href="<?php echo $slider->baner_link;  ?>" onclick="location.href = '<?php echo $slider->baner_link;  ?>';" style="cursor:pointer;">
               <!-- MAIN IMAGE -->
               <img src="<?php echo 'https://www.seller.grabgreatdeals.com/'.$slider->baner_name; ?>" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" class="img-responsive">
               <!-- LAYERS -->
               <!-- LAYER NR. 1 -->
               <div class="tp-caption very_big_white skewfromrightshort fadeout"
                  data-x="center"
                  data-y="100"
                  data-speed="500"
                  data-start="1200"
                  data-easing="Circ.easeInOut"
                  style=" font-size:70px; font-weight:800; color:#fe0100;"><?php //echo $slider->pro_title; ?></div>
               <!-- LAYER NR. 2 -->
               <div class="tp-caption tp-caption medium_text skewfromrightshort fadeout"
                  data-x="center"
                  data-y="165"
                  data-hoffset="0"
                  data-voffset="-73"
                  data-speed="500"
                  data-start="1200"
                  data-easing="Power4.easeOut"
                  style=" font-size:20px; font-weight:500; color:#337ab7;"> <!-- Sale off 75% all products --> </div>
               <!-- LAYER NR. 3 -->
               <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0"
                  data-x="center"
                  data-y="210"
                  data-hoffset="0"
                  data-voffset="98"
                  data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                  data-speed="500"
                  data-start="1500"
                  data-easing="Power3.easeInOut"
                  data-splitin="none"
                  data-splitout="none"
                  data-elementdelay="0.1"
                  data-endelementdelay="0.1"
                  data-linktoslide="next"
                  style="border: 2px solid #fed700;border-radius: 50px; font-size:14px; background-color:#fed700; color:#333; z-index: 12; white-space: nowrap; letter-spacing:1px;"><a href='<?php echo $slider->baner_link;  ?>' class='largebtn slide1'>Shop Now</a></div>
            </li>
            
         <?php } ?>
            <!-- SLIDE 2 -->            
         </ul>
      </div>
   </div>
</div>
<!-- Home Slider End -->