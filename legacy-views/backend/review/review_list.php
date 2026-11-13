<div id="page-wrapper">
    <div class="row">
         <!--  page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Product Review Details</h1>
        </div>
         <!-- end  page header -->
    </div>
    <style>
        .checked {
          color: orange;
        }
    </style>
     <div class="row">
        <div class="col-lg-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     Product Review Details
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
                                    <th width="%">ID</th>
                                    <th width="%">Name</th>                          
                                    <th width="%">Title</th>
                                    <th width="%">Description</th>
                                    <th width="%">Rating</th>
                                    <th width="%">Status</th>
                                    <th width="%">Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($all_review)){
                                  foreach ($all_review as $value){
                                    $i++;

                                ?>
                                <tr class="gradeC">
                                    <td><?php echo esc($value->review_id);?></td>
                                    <td><?php echo esc($value->reviewer_name);?></td>
                                    <td><?php echo esc($value->review_title);?></td>
                                    <td><?php echo esc($value->review_description);?></td>
                                    <td>
                                        <?php 
                                           $num=0;
                                           foreach (range(1, 5) as $i) { 
                                            $num++;
                                            if ($num <= (int) $value->review_value) {
                                                echo "<span class='fa fa-star checked'></span>";
                                            }else{
                                                echo "<span class='fa fa-star'></span>";
                                                } 
                                            }
                                        ?>
                                    </td>
                                    <td>
                                         <button class="attrclass <?php echo ($value->show_frontend==1) ? 'btn-success' : 'btn-danger' ?>" data-dataattr="<?php echo esc($value->review_id);?>" data-dataattrpro="<?php echo esc($value->product_id);?>"> Enable</button>
                                    </td>
                                    <td><?php echo esc($value->created_at);?></td>                                    
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
    <script> 
      $('.attrclass').click(function() {
      var dataattr = $(this).data('dataattr');    
      var dataattrpro = $(this).data('dataattrpro');    
      var datarev = $(this).data('datarev');    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>/admin/product-review-update",
          dataType: 'json',
          data: {
              dataattr:dataattr,dataattrpro,
              dataattrpro:dataattrpro
          },
          context: this,
          success: function(response) {
            if (response.success==1) {
                $(this).removeClass('btn-success');
                $(this).removeClass('btn-danger');
                $(this).addClass('btn-success');
            }else{
                $(this).removeClass('btn-success');
                $(this).removeClass('btn-danger');
                $(this).addClass('btn-danger');
            }
          },
          error: function() {
            alert('Unable to update the review status.');
          }
        });
});
    </script> 

   