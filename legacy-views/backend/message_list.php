
<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Contact Details</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Contact Details
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
                                    <th width="15%">Subject</th>
                                    <th width="25%">Message</th>
                                    <th width="27%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($all_contact)){
                                  foreach ($all_contact as $value){
                                ?>
                                <tr class="gradeC">
                                    <td><?php echo esc($value->contact_id);?></td>
                                    <td><?php echo esc($value->contact_name);?></td>
                                    <td><?php echo esc($value->contact_email);?></td>
                                    <td><?php echo esc($value->contact_subject);?></td>
                                    <td><?php $msg =  $value->contact_message;?>
                                         <?php
                                           $content = explode(" ",$msg);
                                           $less_content = array_slice($content, 0, 7);
                                           echo esc(implode(" ", $less_content));
                                         ?>

                                    </td>
                                   <td class="text-center"> 
			                            <a href="<?php  echo base_url();?>admin/view-contact/<?php echo esc($value->contact_id);?>" class="btn btn-primary" data-toggle="modal" data-target="#myid">
			                                view
			                            </a>
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
                                        <form method="post" action="<?php echo base_url();?>admin/delete-contact/<?php echo (int) $value->contact_id;?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');"><button class="btn btn-danger" type="submit">Delete</button></form>
                                         <!-- <a class="btn btn-info" href="<?php  //echo base_url();?>replay-contact/<?php //echo $value->contact_id;?>">Replay</a> -->
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

   