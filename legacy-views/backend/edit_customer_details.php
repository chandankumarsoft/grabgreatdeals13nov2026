<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Edit Customer Details</h1>
        </div>
        <!--end page header -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Elements -->
            <div class="panel panel-default">
                <?php echo $this->session->flashdata('flsh_msg'); ?>
                <h4 class="error">
                <?php $msg = $this->session->userdata('error_image');
                echo $msg;
                $this->session->unset_userdata('error_image');
                ?>
                </h4>
                <div class="panel-heading">
                    Edit Customer Details
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 style='color:red'> <?php echo validation_errors();?></h5>
                            <?php echo form_open_multipart('admin/customer-details-edit-save','');?>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php echo esc($all_customer->cus_name); ?>" name="cus_name">
                                <input type="hidden" name="cus_name_hidden" value="<?php echo esc($all_customer->cus_id); ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" value="<?php echo esc($all_customer->cus_email); ?>" name="cus_email">
                            </div>
                            <div class="form-group">
                                <label for="cus_gender">Gender:</label>
                                <select class="form-control" id="cus_gender" name="cus_gender">
                                    <option value="">Select</option>
                                    <option value="male" <?php echo ($all_customer->cus_gender=='male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo ($all_customer->cus_gender=='female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="others" <?php echo ($all_customer->cus_gender=='others') ? 'selected' : ''; ?>>Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="text" class="form-control" value="<?php echo esc($all_customer->date_of_birth); ?>" name="date_of_birth" id="date_of_birth">
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control" value="<?php echo esc($all_customer->cus_mobile_full_no); ?>" name="cus_mobile_full_no" id="cus_mobile_full_no">
                            </div>
                            <div class="form-group">
                                <label for="cus_address">Address</label>
                                <textarea class="form-control" name="cus_address" id="cus_address" autocomplete="of">
                                <?php echo esc($all_customer->cus_address); ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" value="<?php echo esc($all_customer->cus_city); ?>" name="cus_city" id="cus_city">
                            </div>
                            <div class="form-group">
                                <label for="cus_country">Country:</label>
                                <select class="form-control" id="cus_country" name="cus_country">
                                    <option value="">Select</option>
                                    <?php foreach ($countryList as $countryListValue) { ?>
                                    <option value="<?php echo esc($countryListValue->id); ?>" <?php echo ($all_customer->cus_country==$countryListValue->id) ? 'selected' : ''; ?>><?php echo esc($countryListValue->country); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cus_state">State:</label>
                                <select class="form-control" id="cus_state" name="cus_state">
                                    <option value="">Select</option>
                                    <?php foreach ($stateList as $stateListValue) { ?>
                                    <option value="<?php echo esc($stateListValue->id); ?>" <?php echo ($all_customer->cus_state==$stateListValue->id) ? 'selected' : ''; ?>><?php echo esc($stateListValue->region); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cus_zip">Pincode/Zip</label>
                                <input type="text" class="form-control" value="<?php echo esc($all_customer->cus_zip); ?>" name="cus_zip" id="cus_zip">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Form Elements -->
        </div>
    </div>
</div>
<!-- end page-wrapper -->
<script>
$( function() {
$( "#date_of_birth" ).datepicker({ dateFormat: "yy-mm-dd" }).val()
} );
$("#cus_country").change(function() {
//get the selected value
var cuscountryselectedValue = $(this).val();
//make the ajax call
$.ajax({
url: '<?php echo base_url();?>Country_controller_state',
type: 'POST',
data: {country_id : cuscountryselectedValue},
success: function(responsecvalue) {
$('#cus_state').html(responsecvalue);
}
});
});
</script>