
<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Product Tags Details</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Tags Details
                </div>
                <p class="text-success"> <?php if(isset($success_message)){
                  echo $success_message;
                 }?>
                 </p>
                <?php if (!empty($this->session->flashdata('flsh_msg'))) { ?>
                    <div class="alert alert-success">
                     <?php echo $this->session->flashdata('flsh_msg'); ?>
                    </div>
                <?php } ?>              
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Tags Name</th>
                                    <th>Tags Slug</th>
                                    <th>Tags Description</th>
                                    <th>Tags Created</th>
                                    <th>Tags Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_products_tags)){
                                  foreach ($all_products_tags as $value){
                                    $i++;

                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->product_tag_name;?></td>
                                    <td><?php echo $value->product_tag_slug;?></td>
                                    <td><?php echo $value->product_tag_description;?></td>
                                    <td><?php echo $value->product_tag_created_at;?></td>
                                    <td><?php echo $value->product_tag_status;?></td>
                                   <td>
                                        <a class="btn btn-info" href="<?php  echo base_url();?>admin/edit-product-tags/<?php echo $value->product_tag_id;?>">Edit</a>
                                        <form method="post" action="<?php echo base_url();?>admin/delete-product-tags/<?php echo (int) $value->product_tag_id;?>" style="display:inline;"><button class="btn btn-danger" type="submit">Delete</button></form>
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