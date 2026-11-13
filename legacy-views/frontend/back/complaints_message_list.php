<div id="page-wrapper">
   <div class="row">
      <!--  page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Complaints Details</h1>
      </div>
      <!-- end  page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Advanced Tables -->
         <div class="panel panel-default">
            <div class="panel-heading">
               Complaints Details
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
                           <th width="3%">Serial No</th>
                           <th width="13%">Name</th>
                           <th width="12%">Email</th>
                           <th width="15%">Subject</th>
                           <th width="25%">Message</th>
                           <th width="2%">Customer</th>
                           <th width="5%">Submit Date</th>
                           <th width="25%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $i = 0;
                           if(isset($all_complaints)){
                           foreach ($all_complaints as $value){
                           $i++;
                           ?>
                        <tr class="gradeC">
                           <td><?php echo $i;?></td>
                           <td><?php echo $value->complaint_name;?></td>
                           <td><?php echo $value->complaint_email;?></td>
                           <td><?php echo $value->complaint_subject;?></td>
                           <td><?php $msg =  $value->complaint_message;?>
                              <?php
                                 $content = explode(" ",$msg);
                                 $less_content = array_slice($content, 0, 7);
                                 echo implode(" ", $less_content);
                                 ?>
                           </td>
                           <td><?php echo $value->complaint_customer;?></td>
                           <td><?php echo $value->created_at;?></td>
                           <td>
                              
                              <a class="btn btn-info" href="#">Replay</a>
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