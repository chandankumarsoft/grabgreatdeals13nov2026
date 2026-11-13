<div id="page-wrapper">
   <div class="row">
      <!--  page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Shipping Charge List</h1>
      </div>
      <!-- end  page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Advanced Tables -->
         <div class="panel panel-default">
            <div class="panel-heading">
               Shipping Charge List
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
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                     <thead>
                        <tr>
                           <th>Shipping ID</th>
                           <th>Shipping Date Range</th>
                           <th>Shipping Description</th>
                           <th>Shipping Amount</th>
                           <th>Shipping Create Date</th>
                           <th>Shipping Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if(isset($all_shipping_charge)){
                             foreach ($all_shipping_charge as $value){
                           ?>
                        <tr class="gradeC">
                           <td><?php echo esc($value->id);?></td>
                           <td><?php echo esc($value->start_day.'-'.$value->till_day.' Days');?></td>
                           <td><?php echo esc($value->shipping_description);?></td>
                           <td><?php echo esc($value->shipping_amount);?></td>
                           <td><?php echo esc($value->created_at);?></td>
                           <td><?php echo esc($value->status);?></td>
                           <td> 
                              <a class="btn btn-primary" href="<?php  echo base_url();?>admin/edit-shipping-charge/<?php echo esc($value->id);?>">Edit
                              </a>
                              <form method="post" action="<?php echo base_url();?>admin/delete-shipping-charge/<?php echo (int) $value->id;?>" style="display:inline;" onsubmit="return confirm(' you want to delete?');"><button class="btn btn-danger" type="submit">Delete</button></form>
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
<script src="<?php echo base_url()?>assets/back/plugins/dataTables/jquery.dataTables.js"></script>
<script>
   $(document).ready(function () {
       $('#dataTables-example').dataTable();
   });
</script>