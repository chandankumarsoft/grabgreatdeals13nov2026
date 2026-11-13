<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Order Details</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12" style="width:initial;">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Order List
                </div>
                <p class="text-success"> <?php if(isset($success_message)){
                  echo $success_message;
                 }?>
                 </p>
                 <?php
                   if (!empty($this->session->flashdata('flsh_msg'))) {
                    ?>
                       <div class="alert alert-success">
                     <?php echo $this->session->flashdata('flsh_msg'); ?>
                      </div>
                <?php
                   }
                 ?>
                <div class="panel-body">
                <form action="<?php echo base_url(); ?>admin/manage-order" method="get">
                <select style="border-radius:10px;height:45px;" name="view_status">
                  <option value="">-- All Order --</option>
                  <option value="0">-- New Order--</option>
                  <option value="1">-- Old Order --</option>
                </select>
                <select style="border-radius:10px;height:45px;" name="payment_status">
                  <option value="">-- Payment Status --</option>
                  <option value="2">-- Completed --</option>
                  <option value="1">-- Pending / Failed --</option>
                  <option value="0">-- Cancel --</option>
                </select>
                <select style="border-radius:10px;height:45px;" name="payment_type">
                  <option value="">-- Payment Type --</option>
                  <option value="stripe_gateway">-- stripe_gateway --</option>
                  <option value="cod">-- Cash on Delivery --</option>
                </select>
                <select style="border-radius:10px;height:45px;" name="tracking_status">
                  <option value="">-- Tracking Status --</option>
                  <option value="1">-- Sent --</option>
                  <option value="0">-- Not Sent --</option>
                </select>
                <select style="border-radius:10px;height:45px;" name="currency">
                  <option value="">-- Currency --</option>
                  <option value="AUD">-- AUD --</option>
                  <option value="USD">-- USD --</option>
                  <option value="CAD">-- CAD --</option>
                  <option value="INR">-- INR --</option>
                  <option value="GBP">-- GBP --</option>
                </select>
                <button type="submit" class="btn btn-info btn-lg" id="filter_button" style="margin-bottom: 10px;">Filter</button>
              </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ID</th>
                                    <th width="5%" class="text-center">Order No</th>
                                    <th width="10%" class="text-center">Product Name</th>
                                    <th width="15%" class="text-center">Name/Email</th>
                                    <th width="15%" class="text-center">Total Order</th>
                                    <th width="15%" class="text-center">Coupon</th>
                                    <th width="10%" class="text-center">Date</th>
                                    <th width="5%" class="text-center">Payment Status</th>
                                    <th width="5%" class="text-center">Viewed Details</th>
                                    <th width="5%" class="text-center">tracking status</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($all_order)){
                                  foreach ($all_order as $value){
                                ?>
                                <tr class="gradeC text-center">
                                    <td><?php echo esc($value->order_id);?></td>
                                    <td><?php echo esc($value->invoice_no); ?></td>
                                    <td><?php 
                                        $product = $this->db->select('product_name')->from('tbl_order_details')->where('order_id',$value->order_id)->get()->row();
                                        echo esc($product->product_name ?? '');
                                    ?></td>
                                    <td><p><span><?php echo esc($value->bill_name); ?></span>
                                        <br/>
                                    <span style="color: #3085d6"><?php echo esc($value->bill_email); ?></span>
                                    </p>                                        
                                    </td>
                                    <td><?php echo esc($value->order_amount_withcurrency); ?> 
                                      <span><?php echo esc($value->curreny_code); ?></span>
                                    </td>
                                    <td><?php echo esc($value->coupon_name); ?><?php if ($value->coupon_price!=null) {
                                        echo '(' . esc($value->coupon_price) . '%) price : ' . esc($value->coupon_amount_withorder);
                                    } ?>                                        
                                    </td>
                                    <td><?php echo esc($value->createdon); ?></td> 
                                    <td>
                                    <?php 
                                      if ($value->payment_status==0) 
                                      {
                                        echo '<button type="button" class="btn btn-warning">Cancel Request</button>';
                                      }
                                      elseif($value->payment_status==1 && $value->payment_type=='cod')
                                      {
                                        echo '<button type="button" class="btn btn-warning">Pending - Cash on Delivery</button>';
                                      }
                                      elseif($value->payment_status==1)
                                      {
                                        echo '<button type="button" class="btn btn-danger">Failed</button>';
                                      }
                                      elseif($value->payment_status==2)
                                      {
                                         echo '<button type="button" class="btn btn-success">Completed</button>';
                                      }
                                    ?> 
                                    <span><?php echo esc($value->payment_type); ?></span>
                                    </td>
                                    <td>
                                        <?php 
                                          if ($value->viewed_details==0) 
                                          {
                                            echo 'No';
                                          }
                                          elseif($value->viewed_details==1)
                                          {
                                            echo 'Yes';
                                          }
                                          else
                                          {
                                             echo 'N/A';
                                          }
                                        ?> 
                                    </td>
                                    <td>
                                        <?php 
                                          if ($value->tracking_number_status==0) 
                                          {
                                            echo '<button type="button" class="btn btn-warning orderNoID" data-value="' . esc($value->order_id) . '" data-invoice="' . esc($value->invoice_no) . '" data-email="' . esc($value->bill_email) . '">Not Sent</button>';
                                          }
                                          elseif($value->tracking_number_status==1)
                                          {
                                            echo '<button type="button" class="btn btn-success orderNoID" data-value="' . esc($value->order_id) . '" data-invoice="' . esc($value->invoice_no) . '" data-email="' . esc($value->bill_email) . '">Sent</button>';
                                          }
                                          else
                                          {
                                             echo 'N/A';
                                          }
                                        ?>
                                    </td>
                                   <td>
                                        <a class="btn btn-info" href="<?php echo base_url()?>admin/view-order/<?php echo esc($value->order_id)?>">view details</a>
                                       <!--  <a onclick="alert('Are Your Sure to Delete')" class="btn btn-danger" href="<?php// echo base_url()?>admin/delete-order/<?php //echo $value->order_id?>">Delete</a> -->
                                    </td> 
                                    
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
</div>
<!-- Modal -->
<div id="orderNoPopUp" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Order No : <span id="trackingNoSpanId"></span></h4>
         </div>
         <div class="modal-body">
            <form id="trackingFormId">
              <div class="form-group">
                <label for="trackingEmail">Email Address:</label>
                <input type="email" class="form-control" id="trackingEmail" name="trackingEmail" required>
                <input type="hidden" class="form-control" id="trackingOdrNo" name="trackingOdrNo">
              </div>
              <div class="form-group">
                <label for="trackingNumber">Tracking Number:</label>
                <input type="text" class="form-control" id="trackingNumber" name="trackingNumber">
              </div>
              <div class="form-group">
                <label for="TrackingUrl">Tracking Url:</label>
                <input type="url" class="form-control" id="TrackingUrl" name="TrackingUrl" required>
              </div>
              <button type="submit" class="btn btn-success" id="trackingBtnSubmit">Tracking Number Send</button>
              <button class="btn btn-success has-spinner" id="trackingBtnSubmitLoader">
                <span class="spinner"><i class="fa fa-refresh fa-spin"></i></span> Tracking Number Send
              </button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>


<script src="<?php echo base_url()?>assets/back/plugins/dataTables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script> 
<script>
    $(document).ready(function () {
        $('#trackingBtnSubmitLoader').hide();
        $(document).on("click",".orderNoID",function(e){
            $('#trackingBtnSubmit').show();
            $("#trackingNoSpanId").text($(this).attr("data-invoice"));
            $("#trackingEmail").val($(this).attr("data-email"));
            $("#trackingOdrNo").val($(this).attr("data-value"));
            $(this).addClass("tempClassTracking");
            $('#orderNoPopUp').modal({backdrop: 'static', keyboard: false},'show');
            $("#trackingFormId").submit(function(ortrfn){
            ortrfn.preventDefault();
                $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo base_url(); ?>admin/send-orderno-to-customer',
                data: $(this).serialize(), // serializes the form's elements.
                beforeSend: function() {
                   $('#trackingBtnSubmit').hide();
                   $('#trackingBtnSubmitLoader').show();
                },
                success: function (data) {
                    if (data.mail_send_status==1) {
                       $('#trackingBtnSubmit').show();
                       $('#trackingBtnSubmitLoader').hide();
                       $('.tempClassTracking').removeClass("btn-warning").addClass("btn-success");
                       $('.tempClassTracking').text("Sent");
                       $('.tempClassTracking').removeClass("tempClassTracking");
                       $('#trackingFormId')[0].reset();
                       $('#orderNoPopUp').modal('hide');
                    }
                },
                error: function (xhr) {
                   var message = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Unable to send tracking details.';
                   alert(message);
                   $('#trackingBtnSubmit').show();
                   $('#trackingBtnSubmitLoader').hide();
                   $('.tempClassTracking').removeClass('tempClassTracking');
                }
            });
        });
        });
        $('#orderNoPopUp').on('hidden.bs.modal', function () {
            $('#trackingBtnSubmitLoader').hide();
        });

    });
</script>