<style>
   .shop-tracking-status .form-horizontal{margin-bottom:50px; margin-top: 50px;
   }
   .shop-tracking-status .order-status{margin-top:150px;position:relative;margin-bottom:150px}
   .shop-tracking-status .order-status-timeline{height:12px;border:1px solid #aaa;border-radius:7px;background:#eee;box-shadow:0px 0px 5px 0px #C2C2C2 inset}.shop-tracking-status .order-status-timeline .order-status-timeline-completion{height:8px;margin:1px;border-radius:7px;background:#cf7400;width:0px}
   .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c1{width:22%}
   .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c2{width:46%}
   .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c3{width:70%}
   .shop-tracking-status .order-status-timeline .order-status-timeline-completion.c4{width:100%}
   .shop-tracking-status .image-order-status{border:1px solid #ddd;padding:7px;box-shadow:0px 0px 10px 0px #999;background-color:#fdfdfd;position:absolute;margin-top:-35px}.shop-tracking-status .image-order-status.disabled{filter:url("data:image/svg+xml;utf8,<svg%20xmlns='http://www.w3.org/2000/svg'><filter%20id='grayscale'><feColorMatrix%20type='matrix'%20values='0.3333%200.3333%200.3333%200%200%200.3333%200.3333%200.3333%200%200%200.3333%200.3333%200.3333%200%200%200%200%200%201%200'/></filter></svg>#grayscale");filter:grayscale(100%);-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);filter:gray;}
   .shop-tracking-status .image-order-status.active{box-shadow:0px 0px 10px 0px #cf7400}.shop-tracking-status .image-order-status.active .status{color:#cf7400;text-shadow:0px 0px 1px #777}
   .shop-tracking-status .image-order-status .icon{height:40px;width:40px;background-size:contain;background-position:no-repeat}
   .shop-tracking-status .image-order-status .status{position:absolute;text-shadow:1px 1px #eee;color:#333;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);width:180px;top:-50px;left:50px}.shop-tracking-status .image-order-status .status:before{font-family:FontAwesome;content:"\f053";padding-right:5px}
   .shop-tracking-status .image-order-status-new{left:0}.shop-tracking-status .image-order-status-new .icon{background-image: url(assets/front/images/unbox.png);;}
   .shop-tracking-status .image-order-status-active{left:22%}.shop-tracking-status .image-order-status-active .icon{background-image: url(assets/front/images/time.png);;}
   .shop-tracking-status .image-order-status-intransit{left:45%}.shop-tracking-status .image-order-status-intransit .icon{background-image: url(assets/front/images/delivered.png);;}
   .shop-tracking-status .image-order-status-delivered{left:70%}.shop-tracking-status .image-order-status-delivered .icon{background-image: url(assets/front/images/gift.png);}
   .shop-tracking-status .image-order-status-delivered .status{top:85px;left:-180px;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);text-align:right}.shop-tracking-status .image-order-status-delivered .status:before{display:none}
   .shop-tracking-status .image-order-status-delivered .status:after{font-family:FontAwesome;content:"\f054";padding-left:5px;vertical-align:middle}
   .shop-tracking-status .image-order-status-completed{right:0px}.shop-tracking-status .image-order-status-completed .icon{background-image: url(assets/front/images/complete.png)}
   .shop-tracking-status .image-order-status-completed .status{top:85px;left:-180px;transform:rotate(-30deg);-webkit-transform:rotate(-30deg);text-align:right}.shop-tracking-status .image-order-status-completed .status:before{display:none}
   .shop-tracking-status .image-order-status-completed .status:after{font-family:FontAwesome;content:"\f054";padding-left:5px;vertical-align:middle}
</style>
<!-- Main Container -->
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="shop-inner">
               <div class="page-title">
                  <h2>Order Status</h2>
               </div>
               <section>
                  <div class="row shop-tracking-status">
                     <div class="col-md-12">
                        <div class="form-horizontal">
                           <div class="form-group">
                              <label for="inputOrderTrackingID" class="col-sm-2 control-label">Order id</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control" id="inputOrderTrackingID" value="" placeholder="# put your order id here">
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                 <button type="button" id="shopGetOrderStatusID" class="btn btn-success">Get status</button>
                              </div>
                           </div>
                        </div>
                        <h4>Your order status:</h4>
                        <ul class="list-group">
                           <li class="list-group-item">
                              <span class="prefix">Date created:</span>
                              <span class="label label-success">12.12.2013</span>
                           </li>
                           <li class="list-group-item">
                              <span class="prefix">Last update:</span>
                              <span class="label label-success">12.15.2013</span>
                           </li>
                           <li class="list-group-item">
                              <span class="prefix">Comment:</span>
                              <span class="label label-success">customer's comment goes here</span>
                           </li>
                           <li class="list-group-item">You can find out latest status of your order with the following link:</li>
                           <li class="list-group-item"><a href="//tracking/link/goes/here">//tracking/link/goes/here</a></li>
                        </ul>
                        <div class="order-status">
                           <div class="order-status-timeline">
                              <!-- class names: c0 c1 c2 c3 and c4 -->
                              <div class="order-status-timeline-completion c3"></div>
                           </div>
                           <div class="image-order-status image-order-status-new active img-circle">
                              <span class="status">Accepted</span>
                              <div class="icon"></div>
                           </div>
                           <div class="image-order-status image-order-status-active active img-circle">
                              <span class="status">In progress</span>
                              <div class="icon"></div>
                           </div>
                           <div class="image-order-status image-order-status-intransit active img-circle">
                              <span class="status">Shipped</span>
                              <div class="icon"></div>
                           </div>
                           <div class="image-order-status image-order-status-delivered active img-circle">
                              <span class="status">Delivered</span>
                              <div class="icon"></div>
                           </div>
                           <div class="image-order-status image-order-status-completed active img-circle">
                              <span class="status">Completed</span>
                              <div class="icon"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>
<!-- Main Container End -->