<div id="page-wrapper">
    <div class="row">
        <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Products Video Details</h1>
        </div>
        <!-- end  page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products Video List
                </div>
                <p class="text-success"> <?php if(isset($success_message)){
                    echo $success_message;
                    }?>
                </p>
                <?php if ($this->session->flashdata('flsh_msg')!='') {
                ?>
                <div class="alert alert-success">
                    <h4 class="success"><?php echo $this->session->flashdata('flsh_msg')?></h4>
                </div>
                <?php } ?>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Product ID</th>
                                    <th>Product Sku Name</th>
                                    <th>Product Video</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_video)){
                                foreach ($all_video as $value){
                                $i++;
                                ?>
                                <tr class="gradeC">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo "ID: $value->pro_id"; ?></td>
                                    <td><?php echo $value->product_sku_name;?></td>
                                    <td><video width="320" height="240" controls>
                                      <source src="<?php echo base_url().'video/'.$value->product_video_name;?>" type="video/mp4">
                                    </video>
                                    </td>                                    
                                      <td style="display: flex;align-items: center;justify-content: center;">
                                    <a class="btn btn-info" href="<?php echo base_url()?>edit-product-video/<?php echo $value->pro_id?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                    <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url()?>video-list-delete/<?php echo $value->pro_id?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
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