<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Customer Sms List</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Customer Sms Details
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
                                    <th width="20%">Date</th>                          
                                    <th width="20%">Sid</th>                          
                                    <th width="20%">Direction</th>
                                    <th width="20%">From</th>
                                    <th width="20%">To</th>
                                    <th width="20%">Body</th>
                                    <th width="20%"># Segments</th>
                                    <th width="20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_contact)){
                                  foreach ($all_contact->messages as $value){
                                    $i++;
                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->date_updated;?></td>
                                    <td><?php echo $value->sid;?></td>
                                    <td><?php echo $value->direction;?></td>
                                    <td><?php echo $value->from;?></td>
                                    <td><?php echo $value->to;?></td>
                                    <td><?php echo $value->body;?></td>
                                    <td><?php echo $value->num_segments;?></td>
                                    <td><?php echo $value->status;?></td>                                    
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

   