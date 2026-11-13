<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Customer Email List</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Customer Email Details
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
                                    <th width="10%">Serial No</th>
                                    <th width="20%">First Name</th>                          
                                    <th width="20%">Last Name</th>                          
                                    <th width="20%">Email</th>
                                    <th width="20%">Join Date</th>
                                    <th width="30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_contact)){
                                  foreach ($all_contact as $value){
                                    $i++;

                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->free_discount_fname;?></td>
                                    <td><?php echo $value->free_discount_lname;?></td>
                                    <td><?php echo $value->free_discount_email;?></td>
                                    <td><?php echo $value->created_at;?></td>
                                   <td> 
<!-- 			                            <a href="<?php // echo base_url();?>view-contact/<?php// echo $value->id;?>" class="btn btn-primary" data-toggle="modal" data-target="#myid">
			                                view
			                            </a> -->
			                            <div class="modal fade" id="myid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			                                <div class="modal-dialog">
			                                
			                                    <div class="modal-content">
			                                        <div class="modal-header">
			                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                            <h4 class="modal-title" id="myModalLabel"></h4>
			                                        </div>
			                                        <div class="modal-body">
			                                           Contacer message Display here
			                                        </div>
			                                        <div class="modal-footer">
			                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			                                            <button type="button" class="btn btn-primary">Save changes</button>
			                                        </div>
			                                    </div>
			                                   
			                                </div>
			                            </div>
<!--                                         <a class="btn btn-primary" href="<?php  //echo base_url();?>delete-contact/<?php //echo $value->id;?>">Edit</a> -->
                                        <a class="btn btn-danger" href="<?php  echo base_url();?>delete-discount-email/<?php echo $value->id;?>">Delete</a>
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

   