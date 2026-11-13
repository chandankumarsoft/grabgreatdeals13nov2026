<div id="page-wrapper">
    <div class="row">
        <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Blog Details</h1>
        </div>
        <!-- end  page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Blog Details
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
                                    <th>Blog Image</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_blog)){
                                foreach ($all_blog as $value){
                                $i++;
                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><img src="<?php echo base_url().$value->image; ?>" width="100" height="100"></td>
                                    <td><?php echo $value->title;?></td>
                                    <td>
                                        <a class="btn btn-info" href="<?php  echo base_url();?>edit-blog?blog_id=<?php echo $value->blog_id;?>">Edit</a>
                                        <a class="btn btn-danger" href="<?php  echo base_url();?>delete-blog?blog_id=<?php echo $value->blog_id;?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
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