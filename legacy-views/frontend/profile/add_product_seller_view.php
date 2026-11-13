<style type="text/css">
   .form-style-2{
   max-width: 500px;
   padding: 20px 12px 10px 20px;
   font: 13px Arial, Helvetica, sans-serif;
   }
   .form-style-2-heading{
   font-weight: bold;
   font-style: italic;
   border-bottom: 2px solid #ddd;
   margin-bottom: 20px;
   font-size: 15px;
   padding-bottom: 3px;
   }
   .form-style-2 label{
   display: block;
   margin: 0px 0px 15px 0px;
   }
   .form-style-2 label > span{
   width: 100px;
   font-weight: bold;
   /* float: left;*/
   padding-top: 8px;
   padding-right: 5px;
   }
   .form-style-2 span.required{
   color:red;
   }
   .form-style-2 .tel-number-field{
   width: 40px;
   text-align: center;
   }
   .form-style-2 input.input-field, .form-style-2 .select-field{
   width: 100%;
   }
   .form-style-2 input.input-field,
   .form-style-2 .tel-number-field,
   .form-style-2 .textarea-field,
   .form-style-2 .select-field{
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
   border: 1px solid #C2C2C2;
   box-shadow: 1px 1px 4px #EBEBEB;
   -moz-box-shadow: 1px 1px 4px #EBEBEB;
   -webkit-box-shadow: 1px 1px 4px #EBEBEB;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   padding: 7px;
   outline: none;
   }
   .form-style-2 .input-field:focus,
   .form-style-2 .tel-number-field:focus,
   .form-style-2 .textarea-field:focus,
   .form-style-2 .select-field:focus{
   border: 1px solid #0C0;
   }
   .form-style-2 .textarea-field{
   height:100px;
   width: 55%;
   }
   .form-style-2 input[type=submit],
   .form-style-2 input[type=button]{
   border: none;
   padding: 8px 15px 8px 15px;
   background: #FF8500;
   color: #fff;
   box-shadow: 1px 1px 4px #DADADA;
   -moz-box-shadow: 1px 1px 4px #DADADA;
   -webkit-box-shadow: 1px 1px 4px #DADADA;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   }
   .form-style-2 input[type=submit]:hover,
   .form-style-2 input[type=button]:hover{
   background: #EA7B00;
   color: #fff;
   }
</style>
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="shop-inner">
               <!-- <div class="page-title">
                  <h2>My Profile</h2>
                  </div> -->
               <div class="container">
                  <div class="form-style-2">
                     <div class="form-style-2-heading">My Profile</div>
                     <form action="" method="post">
                        <label for="field1"><span> Product Name or Title <span class="required">(*)</span></span>
                        <input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field1"><span> Product Short Description With Bullet Points <span class="required">(*)</span></span><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field2"><input type="text" class="input-field" name="field2" value="" /></label>
                        <label for="field1"><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field1">
                           <span> Product Categories <span class="required">(*)</span></span>
                           <aside>
                              <h4>Mobile</h4>
                              <div>
                                 <input type="checkbox" name="startingReserves" value="starting" id="starting">Symphony
                                 <input type="checkbox" name="startingReserves" value="reserves" id="reserves">Apple
                                 <input type="checkbox" name="injured" value="injured" id="injured">Samsung
                                 <input type="checkbox" name="startingReserves" value="starting" id="starting">Google
                                 <input type="checkbox" name="startingReserves" value="reserves" id="reserves">Htc
                                 <input type="checkbox" name="injured" value="injured" id="injured">Nokia
                                 <input type="checkbox" name="injured" value="injured" id="injured">Huawei
                                 <input type="checkbox" name="startingReserves" value="starting" id="starting">Lg
                                 <input type="checkbox" name="startingReserves" value="reserves" id="reserves">Tablets
                                 <input type="checkbox" name="injured" value="injured" id="injured">Accessories
                                 <input type="checkbox" name="injured" value="injured" id="injured">Mobile Back Cover
                              </div>
                              <br>
                              <h4>Garden</h4>
                              <div>
                                 <div><input type="checkbox" name="position" value="guard" id="guard">All Garden</div>
                                 <div><input type="checkbox" name="position" value="forward" id="forward"> Gardening</div>
                                 <div><input type="checkbox" name="position" value="center" id="center">Barbecue & Outdoor Dining</div>
                                 <div><input type="checkbox" name="position" value="guard" id="guard">Mowers & Outdoor Power Tools</div>
                                 <div><input type="checkbox" name="position" value="forward" id="forward">Outdoor Furniture</div>
                                 <div><input type="checkbox" name="position" value="center" id="center">Pools, Hot Tubs & Supplies</div>
                              </div>
                              <h3>NBA Team</h3>
                              <div>
                                 <div><input type="checkbox" name="nbaTeam" value="bos" id="bos">Boston Celtics</div>
                                 <div><input type="checkbox" name="nbaTeam" value="cle" id="cle">Cleveland Cavaliers</div>
                                 <div><input type="checkbox" name="nbaTeam" value="cha" id="cha">Charlotte Hornets</div>
                                 <div><input type="checkbox" name="nbaTeam" value="det" id="det">Detroit Pistons</div>
                                 <div><input type="checkbox" name="nbaTeam" value="gsw" id="gsw">Golden State Warriors</div>
                                 <div><input type="checkbox" name="nbaTeam" value="hou" id="hou">Houston Rockets</div>
                                 <div><input type="checkbox" name="nbaTeam" value="ind" id="ind">Indiana Pacers</div>
                                 <div><input type="checkbox" name="nbaTeam" value="mia" id="mia">Miami Heat
                                 </div>
                                 <div><input type="checkbox" name="nbaTeam" value="mil" id="mil">Milwaukee Bucks</div>
                                 <div><input type="checkbox" name="nbaTeam" value="min" id="min">Minnesota Timberwolves</div>
                              </div>
                           </aside>
                           <!-- <input type="radio" id="male" name="gender" value="male">
                              Male
                              <input type="radio" id="female" name="gender" value="female">
                              Female -->
                           <input type="radio" id="other" name="gender" value="other">
                           Other
                        </label>
                        <label for="field4">
                           <span>Product Type Like(featured,recent,special)<span class="required">(*)</span></span>
                           <select name="field4" class="select-field">
                              <option value="General Question">India</option>
                              <option value="Advertise">USA</option>
                              <option value="Partnership">UK</option>
                           </select>
                        </label>
                        <label for="field1"><span>Product Tags</span><input type="text" class="input-field" name="field1" value="" /></label>
                        </select></label>
                        <label for="field1"><span> Product Search Keywords </span><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field1"><span> Product Regular Price</span><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field1"><span> Product Sale Price </span><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field1"><span> Product Quantity </span><input type="text" class="input-field" name="field1" value="" /></label>
                        <label for="field4">
                           <span>Product Brand</span>
                           <select name="field4" class="select-field">
                              <option value="General Question">Select one</option>
                              <option value="Advertise">Asus</option>
                              <option value="Partnership">Nokia</option>
                           </select>
                        </label>
                        <label for="field4">
                           <span>Product Shipping Charge</span>
                           <select name="field4" class="select-field">
                              <option value="General Question">Yes</option>
                              <option value="Advertise">Yes</option>
                              <option value="Partnership">No</option>
                           </select>
                        </label>
                        <label for="field4"><span>Product Dimensions</span><br>
                        <input type="number" placeholder="Weight(kg)" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                        <input type="number" placeholder="Length(cm)" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                        <input type="number" placeholder="Width(cm)" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                        <input type="number" placeholder="Height(cm)" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                        </label>
                        <div class="col-xs">
                           <label for="field1">
                              <span>Product More Details</span><input type="text" class="input-field" name="field1" value="" />
                              <select>
                                 <option value="0">----- Select -----</option>
                                 <option value="127">2016</option>
                                 <option value="126">2015</option>
                                 <option value="82">2014</option>
                                 <option value="93">1949</option>
                                 ?&gt;
                              </select>
                              <select name="year">
                                 <option value="0">----- Select -----</option>
                                 <option value="127">2016</option>
                                 <option value="126">2015</option>
                                 <option value="82">2014</option>
                                 <option value="93">1949</option>
                                 ?&gt;
                              </select>
                              <input type="number" placeholder="Price" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                              <input type="number" placeholder="Quantity" ng-model="currentLevel" ng-click="up()" class="button button-calm">
                           </label>
                        </div>
                        <label for="field4">
                           <span>Product Status</span>
                           <select name="field4" class="select-field">
                              <option value="General Question">Enable</option>
                              <option value="Advertise">Enable</option>
                              <option value="Partnership">Disable</option>
                           </select>
                        </label>
                        <label for="field4">
                           <span>Product Availability</span>
                           <select name="field4" class="select-field">
                              <option value="General Question">In Stock</option>
                              <option value="Advertise">Out Of Stock</option>
                              <option value="Partnership">Up Comming</option>
                           </select>
                        </label>
                        <label for="story">Product Description</label>
                        <textarea rows="5" cols="50">
                        It was a dark and stormy night...
                        </textarea>
                        <div class="col-sm-6"><label for="img">Upload Product Image:</label>
                           <input type="file" id="img" name="img" accept="image/*">
                        </div>
                        <div class="col-sm-6"><label for="img">Upload Product Image feature1:</label>
                           <input type="file" id="img" name="img" accept="image/*">
                        </div>
                        <div class="col-sm-6"><label for="img">Upload Product Image feature2:</label>
                           <input type="file" id="img" name="img" accept="image/*">
                        </div>
                        <div class="col-sm-6"><label for="img">Upload Product Image feature3:</label>
                           <input type="file" id="img" name="img" accept="image/*">
                        </div>
                        <div class="col-sm-6"><label for="img">Upload Product Image feature4:</label>
                           <input type="file" id="img" name="img" accept="image/*">
                           <label><span> </span><input type="submit" value="Save" /></label>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>