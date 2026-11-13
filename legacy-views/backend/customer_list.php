<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Customer Details</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Customer Details
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
                                    <th width="3%">ID</th>
                                    <th width="15%">Name</th>                          
                                    <th width="15%">Email</th>
                                    <th width="15%">Gender</th>
                                    <th width="25%">Mobile</th>
                                    <th width="25%">Address</th>
                                    <th width="25%">City</th>
                                    <th width="25%">Country</th>
                                    <th width="25%">State</th>
                                    <th width="25%">Postal Code</th>
                                    <th width="25%">Created On</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_customer)){
                                  foreach ($all_customer as $value){
                                    $i++;

                                ?>
                                <tr class="gradeC">
                                    <td><?php echo esc($value->cus_id);?></td>
                                    <td><?php echo esc($value->cus_name);?></td>
                                    <td><?php echo esc($value->cus_email);?></td>
                                    <td><?php echo esc($value->cus_gender);?></td>
                                    <td><?php echo esc($value->cus_mobile);?></td>
                                    <td><?php echo esc($value->cus_address);?></td>
                                    <td><?php echo esc($value->cus_city);?></td>
                                    <td><?php echo esc($value->cus_country);?></td>
                                    <td><?php echo esc($value->cus_state);?></td>
                                    <td><?php echo esc($value->cus_zip);?></td>
                                    <td><?php echo esc($value->createdon);?></td>                                    
                                    <td style="display: inline-flex;">
                                        <a class="btn btn-info" href="<?php  echo base_url();?>admin/customer-details-edit?cus_id=<?php echo esc($value->cus_id);?>">Edit</a>
                                        <form method="post" action="<?php echo base_url();?>admin/customer-details-delete/<?php echo (int) $value->cus_id;?>" style="display:inline;" onsubmit="return confirm('Are you sure to delete?')"><button class="btn btn-danger" type="submit">Delete</button></form>
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

   