<div id="page-wrapper">
   <div class="row">
      <!--  page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Shipping Charge Product List</h1>
      </div>
      <!-- end  page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Advanced Tables -->
         <div class="panel panel-default">
            <div class="panel-heading">
               Shipping Charge Product List
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
                           <th>Product ID</th>
                           <th>Product Name</th>
                           <th>Shipping ID</th>
                           <th>Shipping Name</th>
                           <th>Added Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if(isset($all_shipping_charge)){
                             foreach ($all_shipping_charge as $value){
                           ?>
                        <tr class="gradeC">
                           <td><?php echo esc($value->pro_id);?></td>
                           <td><?php echo esc($value->pro_title);?></td>
                           <td><?php echo esc($value->ship_charge_id);?></td>
                           <td><?php echo esc($value->shipping_description);?></td>
                           <td><?php echo esc($value->created_at);?></td>
                           <td> 
                              <a class="btn btn-primary" href="<?php  echo base_url();?>admin/edit-shipping-product-list-charge/<?php echo esc($value->pro_id);?>">Edit
                              </a>                              
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
            $('#dataTables-example').dataTable({
                 "order": []
            });
        });
    </script> 