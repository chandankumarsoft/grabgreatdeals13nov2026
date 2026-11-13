<div id="page-wrapper">
   <div class="row">
      <!--  page header -->
      <div class="col-lg-12">
         <h1 class="page-header">Applicants Details</h1>
      </div>
      <!-- end  page header -->
   </div>
   <div class="row">
      <div class="col-lg-12">
         <!-- Advanced Tables -->
         <div class="panel panel-default">
            <div class="panel-heading">
               Applicants Details
            </div>
            <p class="text-success"> 
            <?php if(isset($success_message)){
               echo $success_message;
            }?>
            </p>
            <?php
            if(!empty($this->session->flashdata('flsh_msg'))) {
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
                           <th width="2%">Serial No</th>
                           <th width="8%">Name</th>
                           <th width="12%">Email</th>
                           <th width="8%">Phone</th>
                           <th width="8%">Company Name</th>
                           <th width="6%">ABN</th>
                           <th width="20%">Message</th>
                           <th width="5%">Country</th>
                           <th width="5%">State</th>
                           <th width="5%">City</th>
                           <th width="5%">Address</th>
                           <th width="3%">Zip</th>
                           <th width="3%">Submit Date</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $i = 0;
                           if(isset($all_applicants)){
                           foreach ($all_applicants as $value){
                           $i++;
                           ?>
                        <tr class="gradeC">
                           <td><?php echo $i;?></td>
                           <td><?php echo esc($value->applicant_full_name);?></td>
                           <td><?php echo esc($value->applicant_email);?></td>
                           <td><?php echo esc($value->applicant_phone);?></td>
                           <td><?php echo esc($value->applicant_company_name);?></td>
                           <td><?php echo esc($value->applicant_abn);?></td>
                           <td><?php $msg =  $value->applicant_message;?>
                              <?php
                                 $content = explode(" ",$msg);
                                 $less_content = array_slice($content, 0, 7);
                                 echo esc(implode(" ", $less_content));
                                 ?>
                           </td>
                           <td><?php echo esc($value->country_name);?></td>
                           <td><?php echo esc($value->state_name);?></td>
                           <td><?php echo esc($value->city_name);?></td>
                           <td><?php echo esc($value->applicant_address);?></td>
                           <td><?php echo esc($value->applicant_zip);?></td>
                           <td><?php echo esc($value->created_at);?></td>
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