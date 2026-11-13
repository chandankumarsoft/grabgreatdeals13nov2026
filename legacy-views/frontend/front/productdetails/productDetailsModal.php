<!-- Modal -->
<style type="text/css">
  #default{
  text-align:center;
  }
</style>
<script src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/xzoom/dist/xzoom.css">
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onmousemove="modalPopUpDelete()">
  <div class="modal-dialog modal-dialog-centered" style="width: 100%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
    <!-- default start -->
   <body>
  
  <div class="container">
    
    <!-- default start -->
    <section id="default" class="padding-top0">
    <div class="row">
      <div class="large-12 column"><h3><?php echo $product_info->pro_title ?></h3></div>
        <hr>
        <?php  $featureImage = $this->db->select('image_name')->from('tbl_image')->where('img_rel_id',$product_info->pro_id)->where('img_rel_cat_id',2)->get()->result(); ?>
      <div class="large-12 column">
        <div class="xzoom-container">
          <img class="xzoom" id="xzoom-default" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_info->pro_image; ?>" xoriginal="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_info->pro_image; ?>" />

          <div class="xzoom-thumbs">
             <a href="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_info->pro_image; ?>">
                <img class="xzoom-gallery" width="80" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_info->pro_image; ?>"  xpreview="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $product_info->pro_image; ?>" title="The description goes here"></a>
            <?php 
                        
                        foreach ($featureImage as $featureImageValue) {
                     ?>
            <a href="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>">
                <img class="xzoom-gallery" width="80" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>"  xpreview="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $featureImageValue->image_name; ?>" title="The description goes here"></a>
            <?php } ?>           
          </div>
        </div>        
      </div>
    </div>
    </section>
    <!-- default end -->
  </div>
  </body>
    <!-- default end -->
      </div>
    </div>
  </div>
</div>
<script>
  (function ($) {
    $(document).ready(function() {
        $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 400, title: true, tint: '#333', Xoffset: 30});
        $('.xzoom2, .xzoom-gallery2').xzoom({position: '#xzoom2-id', tint: '#ffa200'});
        $('.xzoom3, .xzoom-gallery3').xzoom({position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden'});
        $('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
        $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});
    });
})(jQuery);
</script>
<script>
function modalPopUpDelete(){
    $('.xzoom-source').remove();
    $('.xzoom-preview').remove();
}
</script>