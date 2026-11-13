
<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Product Search Key List</h1>
        </div>
         <!-- end  page header -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Product search Key Details
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
                                    <th>Search Keywords Name</th>
                                    <th>Search Keywords Slug</th>
                                    <th>Search Keywords Description</th>
                                    <th>Search Keywords Created</th>
                                    <th>Search Keywords Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_product_search_key)){
                                  foreach ($all_product_search_key as $value){
                                    $i++;

                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->search_key_name;?></td>
                                    <td><?php echo $value->search_key_slug;?></td>
                                    <td><?php echo $value->search_key_description;?></td>
                                    <td><?php echo $value->created_at;?></td>
                                    <td><?php echo $value->key_status;?></td>
                                   <td>
                                        <a class="btn btn-info" href="<?php  echo base_url();?>edit-product-search_keywords/<?php echo $value->search_key_id;?>">Edit</a>
                                        <a class="btn btn-danger" href="<?php  echo base_url();?>delete-product-search_keywords/<?php echo $value->search_key_id;?>">Delete</a>
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