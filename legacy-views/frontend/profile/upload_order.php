<!-- Main Container -->
<div class="main-container col2-left-layout">
   <div class="container">
      <div class="row">
         <div class="col-main col-sm-9 col-xs-12 col-sm-push-3">
            <div class="shop-inner">
               <div class="page-title">
                  <h2>Import Order VIA CSV</h2>
               </div>
               <div class="container">
                  <div class="table-responsive">
                     <table class="table">
                        <tbody>
                           <tr>
                              <td align="left">Excel Template</td>
                              <td><a href="#">Please Dowload the Excel Template</a></td>
                           </tr>
                           <tr>
                              <td align="left">Choose File</td>
                              <td>
                                 <form action="/action_page.php">
                                    <input type="file" id="myFile" name="filename">
                                    <button type="submit" class="button" style="
                                       margin-top: 10px;"><span>submit</span></button>
                                 </form>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php $this->load->view('profile/profile_sidebar'); ?>
      </div>
   </div>
</div>
<!-- Main Container End -->