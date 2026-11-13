<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:400,700');
*{ box-sizing: border-box;}
button:active, button:focus{ outline: none; box-shadow: none;}
body{ background: #eeffad;; font-family: 'Roboto', sans-serif;}
.multitab-form-area { max-width: 750px; margin: 0 auto; background:#eee; padding: 20px}
.form-field input:focus, .form-field input:active, .form-field select:focus, .form-field select:active, .form-field textarea:active, .form-field textarea:focus {outline: 1px solid #8aa71c;}
.tab-links-area {width: 240px; display: inline-block; vertical-align: top; padding-right: 20px;}
.tab-form-area { width: calc(100% - 245px); display: inline-block; background: #fff; vertical-align: top; padding: 16px; border-radius: 5px;}
.tab-links-area p {margin: 0; font-size: 14px; color: #999;}
.tab-links-area h1 { margin: 0; font-size: 24px;}
.tab-part h4 {font-size: 24px;margin: 0;}
.multitab-form-area hr {border: 0; height: 1px; width: 100%; background: rgba(0,0,0,0.3);}
.tab-links-area ul li a {text-decoration: none;font-size: 14px;padding: 10px 15px;display: block;color: #333; position: relative;}
.tab-links-area ul li a:before {content: '';height: 0%;width: 3px;background: #8aa71c;position: absolute;left: -2px;top: 0;bottom: 0;margin: auto;transition: 0.3s ease;}
.tab-links-area ul li a.active:before{ height: 100%;}
.tab-links-area ul li {display: block; border-left: 1px solid #eee;}
.tab-links-area ul {list-style: none;padding: 0; margin: 20px 0 0;}
.form-field input, .form-field select {width: 100%; font-family: 'Roboto', sans-serif; height: 35px; padding-left: 10px; border: 1px solid #ccc;}
.form-field select {padding: 0 0 0 2px;}
.form-field label { font-size: 14px; display: block; padding:10px 0;}
.half-2 {width: 50%; padding: 0 10px; float: left;}
.devider-row:after {content: '';display: table;clear: both;}
.devider-row {margin: 0 -10px;clear: both;}
.half-3 {width: calc(100%/3); float: left; padding: 0 10px;}
.next-btn button, .next-btn a {background: #8aa71c;cursor: pointer;border: 1px solid #8aa71c;transition: 0.3s ease;color: #fff;height: 35px;width: 90px;border-radius: 100px;margin: 20px 0 10px auto;display: block;text-transform: uppercase;text-align: center;line-height: 35px;text-decoration: none;font-size: 14px;}
.next-btn button:hover, .next-btn a:hover {background: transparent; color: #8aa71c;}
.tabs-panels.active { display: block;}
.tabs-panels { display: none; animation: fadeIn 0.3s ease;}
.full {padding: 0 10px; width: 100%;}
.form-field textarea {width: 100%;height: 100px;padding: 10px;font-size: 14px;border: 1px solid #ccc;font-family: 'Roboto', sans-serif;}
.checkbox label:after {content: '';position: absolute;border-style: solid;border-color: #333;height: 8px;width: 5px;border-width: 0 3px 3px 0;left: 5px;z-index: 2;transform: rotate(35deg);top: 4px; display: none;}
.checkbox label:before {content: '';height: 20px;width: 21px;background: #fff;position: absolute;border: 1px solid #8aa71c;left: -2px;top: 0;border-radius: 3px;}
.checkbox {position: relative;margin: 10px 0;}
.checkbox label {display: inline-block;vertical-align: middle;padding: 0;}
.checkbox input[type="checkbox"] {width: 20px;height: 20px;display: inline-block;vertical-align: middle;margin: 0;position: relative;z-index: 3;opacity: 0;}
.radio label:after { content: ''; display: none; height: 15px; width: 15px; position: absolute; background: #8aa71c; border-radius: 100px; left: 2px; top: 2px; z-index: 1;}
.radio label:before {content: ''; height: 21px;  width: 21px; background: #fff; border: 1px solid #8aa71c; position: absolute; left: -2px; top: -2px; border-radius: 100px;}
.radio input[type="radio"] { height: 20px; width: 20px; display: inline-block; margin: 0; position: relative; z-index: 3; opacity: 0; vertical-align: middle;}
.radio label {padding: 0; display: inline-block;  margin: 0; vertical-align: middle;}
.radio { position: relative;  margin: 10px 0;}
.radio input:checked + label:after, .checkbox input:checked + label:after{ display: block;}
.note p { margin: 0; font-size: 12px; color: #999;}
.form-area {max-width: 80%; margin: 0 auto; background: #eee; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.25)}
.form-generate {max-width: 80%; margin: 0 auto;}
.form-footer p {margin: 0; font-size: 12px;}
.form-footer {padding: 20px; text-align: center; color: #676767;}
.form-header {background: #fff; box-shadow: 0 2px 7px rgba(0,0,0,0.1); margin-bottom: 20px;}
.logo-area {padding: 0 10%;}
.logo-area h1 a {color: #000; text-decoration: none; outline: none;}
.logo-area h1 {margin: 0; font-size: 18px;}
.need-help a i {background: #333; color: #fff; font-style: normal; font-size: 10px; height: 13px; width: 13px; display: inline-block; text-align: center; border-radius: 100px;}
.need-help a {font-size: 12px; color: #333; text-decoration: none;}
.need-help {text-align: right; padding: 0 10%;}
.top-header {padding: 15px 0; border-bottom: 2px dashed #ccc;}
.status p {font-size: 12px; color: #676767}
.status h5, .status p { margin: 0;}
.bars label { text-align: center; display: block; font-size: 14px;}
.bars {position: relative;}
.blank-bar {width: 100%; background: #ccc; height: 3px; border-radius: 100px;}
.full-bar { width: 50%; background: #8aa71c; height: 3px; position: relative; bottom: -3px;}
.bars span { height: 8px; width: 8px; display: inline-block; position: absolute; background: #ccc; border-radius: 100px; z-index: 1;}
.bars span:nth-of-type(2) {left: 15%;}
.bars span:nth-of-type(3) {left: 50%;}
.bars span:nth-of-type(4) {left: 85%;}
.bars span:nth-of-type(5) {left: 100%;}
.bars span.active{background: #8aa71c;}
.bottom-header {padding: 15px 10%;}
.status {padding-left: 10%;}
/*keyframes*/
@-webkit-keyframes fadeIn {
0% {
opacity: 0;
}
100% {
opacity: 1;
}
}
@keyframes fadeIn {
0% {
opacity: 0;
}
100% {
opacity: 1;
}
}
.fadeIn {
-webkit-animation-name: fadeIn;
animation-name: fadeIn;
}
@media(max-width:750px){
.half-2 {width: 100%;}
.top-header .half-2 {width: 50%;}
.logo-area {padding: 0 5%; text-align: left;}
.status { padding-top: 20px; padding-left: 0;}
}
@media(max-width:570px){
.tab-links-area {width: 100%;display: block; margin-bottom: 20px;}
.tab-form-area{ width: 100%;}
.bottom-header {padding: 15px 5%;}
}
@media(max-width:420px){
.form-area {max-width: 90%;}
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>/assets/back/ckeditor/ckeditor.js"></script>
<!--  page-wrapper -->
<div id="page-wrapper">
    <div class="row">
        <!-- page header -->
        <div class="col-lg-12">
            <h1 class="page-header">Add new coupon</h1>
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
                    <div class="quotes">
                        <div class="quotes__list">
                            <blockquote cite="#">
                                <p>Add Coupon as percentage discount or fix price discount.</p>
                            </blockquote>                            
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="form-generate">
                        <form>
                            <input type="text" id="name" style="margin-bottom: 20px;"><br>
                            <button onclick = "go()">
                            Generate New
                            </button>
                            <button onclick = "erase()" style="margin-bottom: 20px;">
                            Clear
                            </button><br>
                            <textarea id="message" cols="100" rows="5" placeholder="Description(Optional)"></textarea>
                        </form>
                    </div>
                    <form>
                        <div class="form-area" style="margin-top: 30px;">
                            <div class="form-header">
                                <div class="top-header">
                                    <div class="devider-row">
                                        <div class="half-2">
                                            <div class="logo-area">
                                                <h1><a href="javascript:;">Coupon Data</a></h1>
                                            </div>
                                        </div>
                                        <div class="half-2">
                                            <div class="need-help">
                                                <a href="javascript:;">Need Help <i>?</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-header">
                                    
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="multitab-form-area">
                                    <div class="tab-links-area">
                                        <!-- <h1>Registration Form</h1>
                                        <p>Lorem ipsum doler site ameti</p>
                                        <hr> -->
                                        <ul>
                                            <li><a data-toggle="formtab" href="#userProfile" class="active">General</a></li>
                                            <li><a data-toggle="formtab" href="#residentailAddress">Usage Restriction</a></li>
                                            <li><a data-toggle="formtab" href="#jobDescription">Usage Limit</a></li>
                                            <!-- <li><a data-toggle="formtab" href="#bankInfo">Bank Information & Others</a></li>
                                            <li><a data-toggle="formtab" href="#uploadDocuments">Upload Documents</a></li> -->
                                        </ul>
                                    </div>
                                    <div class="tab-form-area">
                                        <div class="tabs-panels active" id="userProfile">
                                            <div class="tab-part">
                                                <!-- <h4>User Profile</h4>
                                                <hr> -->
                                                <div class="devider-row">
                                                    <div class="half-2">
                                                        <div class="form-field">
                                                            <label>Discount type</label>
                                                            <select>
                                                                <option selected disabled>Fixed cart discount</option>
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Coupon Amount</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Allow free shipping</label>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="checkbox1" name="checkbox">
                                                                <label for="checkbox1">Checkbox</label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="half-2">
                                                        <div class="form-field">
                                                            <label>Coupon expiry date</label>
                                                            <input type="text">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Apply as cashback</label>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="checkbox1" name="checkbox">
                                                                <label for="checkbox1">Checkbox</label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="next-btn">
                                                <a data-toggle="formtab" href="#residentailAddress">Next</a>
                                            </div>
                                        </div>
                                        <div class="tabs-panels" id="residentailAddress">
                                            <div class="tab-part">
                                                <!-- <h4>Residential Address</h4>
                                                <hr> -->
                                                <div class="devider-row">
                                                    <div class="half-2">
                                                        <div class="form-field">
                                                            <label>Minimum spend</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Maximum spend</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Products</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Exclude Produts</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Product categories</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Allowed emails</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                    <!--    <div class="half-2">
                                                        <div class="form-field">
                                                            <label>State</label>
                                                            <input type="text" placeholder="Delhi">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Zip Code</label>
                                                            <input type="text" placeholder="201003">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Occupation</label>
                                                            <input type="text" placeholder="Developer">
                                                        </div>
                                                    </div> -->
                                                </div>
                                                
                                            </div>
                                            <div class="next-btn">
                                                <a data-toggle="formtab" href="#jobDescription">Next</a>
                                            </div>
                                        </div>
                                        <div class="tabs-panels" id="jobDescription">
                                            <div class="tab-part">
                                                
                                                <div class="devider-row">
                                                    <div class="half-2">
                                                        <div class="form-field">
                                                            <label>Usage limit per coupon</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        <div class="form-field">
                                                            <label>Usage limit per user</label>
                                                            <input type="text" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                    <!-- <div class="half-2">
                                                        <div class="form-field">
                                                            <label>Coupon expiry date</label>
                                                            <input type="text">
                                                        </div>
                                                        
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="next-btn">
                                                <a data-toggle="formtab" href="#bankInfo">Next</a>
                                            </div>
                                        </div>
                                        
                                        <div class="note">
                                            <p>* You must fill all blank spaces.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <p>Lorem ipsum dolor sit amet, consectetur. 2018-19 all rights are reserved.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Form Elements -->
        </div>
    </div>
</div>
<!-- end page-wrapper -->
<script>
$('a[data-toggle="formtab"]').click(function(){
var targetId = $(this).attr('href');
$('.tabs-panels').removeClass('active')
$('a[data-toggle="formtab"]').removeClass('active');

$(targetId).addClass('active');
$('a[href="'+targetId+'"]').addClass('active')

});
</script>