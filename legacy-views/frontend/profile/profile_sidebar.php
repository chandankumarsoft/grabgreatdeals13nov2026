<style type="text/css">
   .sidebar li {
    list-style: none;
    padding: 20px;
    font-size: 14px;
    font-weight: bold;
}
 .sidebar .fa {
   color: #0037ff;

 }
</style>
<?php  
     $cusImage=$this->db->select('profile_image')->from('tbl_customer')->where('cus_id',$this->session->userdata('cus_id'))->get()->row(); 
     $selectedImage = ($cusImage->profile_image!='') ? $cusImage->profile_image : 'profile.png';
?>
<aside class="sidebar col-sm-3 col-xs-12 col-sm-pull-9">
   <div class="block shop-by-side">
      <div class="sidebar-bar-title">
         <h3>My Account</h3>
      </div>
      <div class="block-content">
         <div class="manufacturer-area">
            <!-- h2 class="saider-bar-title">My Account</h2> -->
            <div class="saide-bar-menu">
               <div class="card">
                <div>
                 <img src="<?php echo base_url().'uploads/medium/'.$selectedImage; ?>" id="proImageId" onclick="document.getElementById('getFile').click()" alt="Avatar" style="width:20%;border-radius:50%; float: left;">
                 <h4 style="padding: 10px; float: left;"></h4>
                 <form name="photo" id="imageUploadForm" enctype="multipart/form-data" action="<?php echo base_url(); ?>update-profile-image" method="post">
                  <input type='file' name="profile_image" id="getFile" style="display:none"> 
                  </form>
                 </div>
                 <div>
                   <h4><b><?php if ($this->session->userdata('cus_id')) {
                      echo $this->session->userdata('cus_name'); 
                   } ?></b></h4>
                 </div>
               </div>      
               <script>
                 $('#imageUploadForm').on('submit',(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);

                    $.ajax({
                        type:'POST',
                        url: $(this).attr('action'),
                        data:formData,
                        dataType: "json",
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(data){
                         if (data.message=='success') {
                          $("#proImageId").attr("src","<?php echo base_url(); ?>uploads/medium/"+data.image);
                         }
                        },
                        error: function(data){
                            console.log("error");
                            console.log(data);
                        }
                    });
                }));

                $("#getFile").on("change", function() {
                    $("#imageUploadForm").submit();
                    // alert();
                });
               </script>
                <hr>
               <ul>
                  <!-- <li><a href="<?php // echo base_url(); ?>upload-order"><i class="fa fa-angle-right"></i> Upload Order </a></li> -->
<!--                   <li>
            <a href="<?php //echo base_url(); ?>order-status"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;My Orders (0) </a>
                  </li> -->
                  <!-- <li>
                     <a href="<?php //echo base_url(); ?>my-profile-shopping-cart"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;My Shopping Cart </a>
                  </li> -->
                  <li>
                     <a href="<?php echo base_url(); ?>my-order"><i class="fa fa-first-order"></i>&nbsp;&nbsp;My Order</a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>my-wishlist"><i class="fa fa-heart"></i>&nbsp;&nbsp;My Wishlist</a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>my-news-letter"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;Newsletter Subscription</a>
                  </li>
                  <li>
                  <a href="<?php echo base_url(); ?>my-profile"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;My Profile</a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>my-address"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;My Address</a>
                  </li>
                  <!-- <li><a href="<?php //echo base_url(); ?>favorite"><i class="fa fa-angle-right"></i> My Favorites</a></li> -->
                  <!-- <li><a href="<?php //echo base_url(); ?>my-credits"><i class="fa fa-angle-right"></i> My Credits</a></li> -->
                  <!-- <li><a href="<?php //echo base_url(); ?>my-coupon"><i class="fa fa-angle-right"></i> My Coupon Codes</a></li> -->
                  <li>
                     <a href="<?php echo base_url(); ?>change-account-password"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;&nbsp;Change Password</a>
                  </li>
                  <!-- <li><a href="<?php //echo base_url(); ?>my-reviews"><i class="fa fa-angle-right"></i> My Reviews</a></li> -->
      <li><form method="post" action="<?php echo base_url(); ?>logout"><button type="submit" class="btn btn-link"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;Logout</button></form></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</aside>