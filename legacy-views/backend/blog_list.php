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
                     <?php echo esc($this->session->flashdata('flsh_msg')); ?>
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
                                    <td style="width: 10%;"><?php echo $i;?></td>
                                    <td style="width: 20%;"><img src="<?php echo base_url().esc($value->image); ?>" class="img-responsive" style="max-height: 200px;"></td>
                                    <td style="width: 50%;"><?php echo esc($value->title);?></td>
                                    <td style="width: 20%;">
                                        <a class="btn btn-info" href="<?php echo base_url('admin/edit-blog?blog_id=' . (int) $value->blog_id); ?>">Edit</a>
                                        <form method="post" action="<?php echo base_url('admin/delete-blog'); ?>" style="display:inline;" onsubmit="return confirm('Are you sure to delete?')"><input type="hidden" name="blog_id" value="<?php echo (int) $value->blog_id; ?>"><button class="btn btn-danger" type="submit">Delete</button></form>
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