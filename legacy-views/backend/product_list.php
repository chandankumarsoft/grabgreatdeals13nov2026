<style>
  .filter-price {
    width: 220px;
    border: 0;
    padding: 0;
    margin: 0;
  }

  .price-title {
    position: relative;
    color: #fff;
    font-size: 14px;
    line-height: 1.2em;
    font-weight: 400;
    background: #04b173;
    padding: 10px;
  }

  .price-container {
    display: flex;
    border: 1px solid #ccc;
    padding: 2px;
    margin-left: 57px;
    width: 110px;
  }

  .price-field {
    position: relative;
    width: 100%;
    height: 36px;
    box-sizing: border-box;
    padding-top: 15px;
    padding-left: 0px;
  }

  .price-field input[type=range] {
    position: absolute;
  }

  /* Reset style for input range */
  .price-field input[type=range] {
    width: 100%;
    height: 7px;
    border: 1px solid #000;
    outline: 0;
    box-sizing: border-box;
    border-radius: 5px;
    pointer-events: none;
    -webkit-appearance: button;
  }

  .price-field input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
  }

  .price-field input[type=range]:active,
  .price-field input[type=range]:focus {
    outline: 0;
  }

  .price-field input[type=range]::-ms-track {
    width: 188px;
    height: 2px;
    border: 0;
    outline: 0;
    box-sizing: border-box;
    border-radius: 5px;
    pointer-events: none;
    background: transparent;
    border-color: transparent;
    color: red;
    border-radius: 5px;
  }

  /* Style toddler input range */
  .price-field input[type=range]::-webkit-slider-thumb {
    /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    margin: 0;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 10px;
    width: 10px;
    margin-top: -4px;
    background-color: #fff;
    cursor: pointer;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
  }

  .price-field input[type=range]::-moz-range-thumb {
    /* Firefox */
    position: relative;
    appearance: none;
    margin: 0;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 10px;
    width: 10px;
    margin-top: -5px;
    background-color: #fff;
    cursor: pointer;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
  }

  .price-field input[type=range]::-ms-thumb {
    /* IE */
    position: relative;
    appearance: none;
    margin: 0;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 10px;
    width: 10px;
    margin-top: -5px;
    background-color: #242424;
    cursor: pointer;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
  }

  /* Style track input range */
  .price-field input[type=range]::-webkit-slider-runnable-track {
    /* WebKit/Blink */
    width: 188px;
    height: 2px;
    cursor: pointer;
    background: #555;
    border-radius: 5px;
  }

  .price-field input[type=range]::-moz-range-track {
    /* Firefox */
    width: 188px;
    height: 2px;
    cursor: pointer;
    background: #242424;
    border-radius: 5px;
  }

  .price-field input[type=range]::-ms-track {
    /* IE */
    width: 188px;
    height: 2px;
    cursor: pointer;
    background: #242424;
    border-radius: 5px;
  }

  /* Style for input value block */
  .price-wrap {
    display: flex;
    color: #242424;
    font-size: 14px;
    line-height: 1.2em;
    font-weight: 400;
    margin-bottom: 10px;
  }

  .price-wrap-1,
  .price-wrap-2 {
    display: flex;
    margin-left: 0px;
  }

  .price-title {
    margin-right: 5px;
  }

  .price-wrap_line {
    margin: 6px 0px 5px 5px;
  }

  .price-wrap #one,
  .price-wrap #two {
    width: 30px;
    text-align: right;
    margin: 0;
    padding: 0;
    margin-right: 2px;
    background: 0;
    border: 0;
    outline: 0;
    color: #242424;
    font-family: 'Karla', 'Arial', sans-serif;
    font-size: 14px;
    line-height: 1.2em;
    font-weight: 400;
  }

  .price-wrap label {
    text-align: right;
    margin-top: 6px;
    padding-left: 5px;
  }

  /* Style for active state input */

  .price-field input[type=range]:hover::-webkit-slider-thumb {
    box-shadow: 0 0 0 0.5px #242424;
    transition-duration: 0.3s;
  }

  .price-field input[type=range]:active::-webkit-slider-thumb {
    box-shadow: 0 0 0 0.5px #242424;
    transition-duration: 0.3s;
  }

  .td-overflow {
    overflow-x: hidden;
    overflow-y: hidden;
    height: 130px;
  }

  .filter-size-set {
    width: 10%;
  }
</style>
<div id="page-wrapper">
  <div class="row">
    <!--  page header -->
    <div class="col-lg-12">
      <h1 class="page-header">Products Details</h1>
    </div>
    <!-- end  page header -->
  </div>
  <div class="row">
    <div class="col-lg-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default">
        <div class="panel-heading">
          Product List
        </div>
        <?php if (isset($success_message)) { ?>
          <p class="text-success">
            <?php echo $success_message; ?>
          </p>
        <?php } ?>
        <?php if (!empty($this->session->flashdata('flsh_msg'))) { ?>
          <div class="alert alert-success">
            <h4 class="success"><?php echo $this->session->flashdata('flsh_msg') ?></h4>
          </div>

        <?php } ?>
        <?php if (!empty($this->session->userdata('pro_image')) || !empty($this->session->userdata('product_image_feature1')) || !empty($this->session->userdata('product_image_feature2')) || !empty($this->session->userdata('product_image_feature3')) || !empty($this->session->userdata('product_image_feature4'))) {
        ?>
          <div class="alert alert-danger">
            <?php if (!empty($this->session->userdata('pro_image'))) {
              echo $this->session->userdata('pro_image') . "</br>";
              $this->session->unset_userdata('pro_image');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature1'))) {
              echo $this->session->userdata('product_image_feature1') . "</br>";
              $this->session->unset_userdata('product_image_feature1');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature2'))) {
              echo $this->session->userdata('product_image_feature2') . "</br>";
              $this->session->unset_userdata('product_image_feature2');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature3'))) {
              echo $this->session->userdata('product_image_feature3') . "</br>";
              $this->session->unset_userdata('product_image_feature3');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature4'))) {
              echo $this->session->userdata('product_image_feature4') . "</br>";
              $this->session->unset_userdata('product_image_feature4');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature5'))) {
              echo $this->session->userdata('product_image_feature5') . "</br>";
              $this->session->unset_userdata('product_image_feature5');
            } ?>
            <?php if (!empty($this->session->userdata('product_image_feature6'))) {
              echo $this->session->userdata('product_image_feature6') . "</br>";
              $this->session->unset_userdata('product_image_feature6');
            } ?>
          </div>
        <?php
        } ?>
        <div class="panel-body">
          <form action="<?php echo base_url(); ?>admin/search_by_product_name" method="post" class="search-wrapper cf" style="
            float: right;margin-top: -45px;">
            <input type="text" name="filter_data_name_value" placeholder="Product By Name Search Here" required="" style="min-width:200px;">
            <button type="submit">Search</button>
          </form>
          <form action="<?php echo base_url(); ?>admin/search_filter_backend" method="get">
            <select style="margin-bottom:20px;border-radius:10px;height:45px;" class="filter-size-set" name="category_name">
              <option value="">-- Select a category --</option>
              <?php
              $url_cat_get_value = $this->input->get('category_name');
              $selected_category_data = $this->db->select('*')->from('tbl_category')->get()->result();
              foreach ($selected_category_data as $selected_category_data_value) :
                if ($selected_category_data_value->parent_id == 0) : ?>
                  <option value="<?php echo $selected_category_data_value->category_id;  ?>" <?php if ($url_cat_get_value == $selected_category_data_value->category_id) {
                                                                                                echo "selected";
                                                                                              } ?>><?php echo $selected_category_data_value->category_name; ?></option>
                  <?php
                  foreach ($selected_category_data as $selected_sub_category_data_value) :
                    if ($selected_category_data_value->category_id == $selected_sub_category_data_value->parent_id) : ?>
                      <option value="<?php echo $selected_sub_category_data_value->category_id; ?>" style="padding-left: 5px;" <?php if ($url_cat_get_value == $selected_sub_category_data_value->category_id) {
                                                                                                                                  echo "selected";
                                                                                                                                } ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $selected_sub_category_data_value->category_name; ?></option>
                      <?php
                      foreach ($selected_category_data as $selected_sub_sub_category_data_value) :
                        if ($selected_sub_category_data_value->category_id == $selected_sub_sub_category_data_value->parent_id) : ?>
                          <option value="<?php echo $selected_sub_sub_category_data_value->category_id; ?>" style="padding-left: 5px;" <?php if ($url_cat_get_value == $selected_sub_sub_category_data_value->category_id) {
                                                                                                                                          echo "selected";
                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $selected_sub_sub_category_data_value->category_name; ?></option>
              <?php
                        endif;
                      endforeach;
                    endif;
                  endforeach;
                endif;
              endforeach;
              ?>
            </select>
            <select class="form-group filter-size-set" style="border-radius:10px;height:45px;" name="product_type_name">
              <option value="">-- Product type --</option>
              <?php
              $url_pro_type_get_value = $this->input->get('product_type_name');
              $select_pro_type = $this->db->select('product_type_name,pro_type_name')->from('tbl_product_type')->get()->result();
              foreach ($select_pro_type as $select_pro_type_value) :
              ?>
                <option value="<?php echo $select_pro_type_value->pro_type_name; ?>" <?php if ($select_pro_type_value->pro_type_name == $url_pro_type_get_value) {
                                                                                        echo "selected";
                                                                                      } ?>><?php echo $select_pro_type_value->product_type_name; ?></option>
              <?php
              endforeach;
              ?>
            </select>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="tag_name">
              <option value="">-- Tags --</option>
              <?php
              $url_tags_name_get_value = $this->input->get('tag_name');
              $selected_tags = $this->db->select('product_tag_name,product_tag_slug')->from('tbl_product_tags')->get()->result();
              foreach ($selected_tags as $selected_tags_value) {
              ?>
                <option value="<?php echo $selected_tags_value->product_tag_slug; ?>" <?php if ($selected_tags_value->product_tag_slug == $url_tags_name_get_value) {
                                                                                        echo "selected";
                                                                                      }; ?>><?php echo $selected_tags_value->product_tag_name; ?></option>
              <?php
              }
              ?>
            </select>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="search_keyword_name">
              <option value="">-- Search Keywords --</option>
              <?php
              $url_search_keyword_name_get_value = $this->input->get('search_keyword_name');
              $selected_search_keywords = $this->db->select('search_key_name,search_key_slug')->from('tbl_product_search_keyword')->get()->result();
              foreach ($selected_search_keywords as $selected_search_keywords_value) {
              ?>
                <option value="<?php echo $selected_search_keywords_value->search_key_slug; ?>" <?php if ($selected_search_keywords_value->search_key_slug == $url_search_keyword_name_get_value) {
                                                                                                  echo "selected";
                                                                                                } ?>><?php echo $selected_search_keywords_value->search_key_name; ?></option>
              <?php
              }
              ?>
            </select>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="brand_name">
              <option value="">-- Brand --</option>
              <?php
              $url_brand_name_get_value = $this->input->get('brand_name');
              $selected_brand = $this->db->select('*')->from('tbl_brand')->get()->result();
              foreach ($selected_brand as $selected_brand_value) {
              ?>
                <option value="<?php echo $selected_brand_value->brand_id; ?>" <?php if ($selected_brand_value->brand_id == $url_brand_name_get_value) {
                                                                                  echo "selected";
                                                                                } ?>><?php echo $selected_brand_value->brand_name; ?></option>
              <?php
              }
              ?>
            </select>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="color_name">
              <option value="">-- Color --</option>
              <?php
              $url_color_name_get_value = $this->input->get('color_name');
              $selected_color = $this->db->select('*')->from('tbl_color')->get()->result();
              foreach ($selected_color as $selected_color_value) {
              ?>
                <option value="<?php echo $selected_color_value->color_id; ?>" <?php if ($selected_color_value->color_id == $url_color_name_get_value) {
                                                                                  echo "selected";
                                                                                } ?>><?php echo $selected_color_value->color; ?></option>
              <?php
              }
              ?>
            </select>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="size_name">
              <option value="">-- Size --</option>
              <?php
              $url_size_name_get_value = $this->input->get('size_name');
              $selected_size = $this->db->select('*')->from('tbl_size')->get()->result();
              foreach ($selected_size as $selected_size_value) {
              ?>
                <option value="<?php echo $selected_size_value->size_id; ?>" <?php if ($selected_size_value->size_id == $url_size_name_get_value) {
                                                                                echo "selected";
                                                                              } ?>><?php echo $selected_size_value->size_name; ?></option>
              <?php
              }
              ?>
            </select>
            <?php $url_pro_status_get_value = $this->input->get('pro_status'); ?>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="pro_status">
              <option value="">-- Status --</option>
              <option value="1" <?php if (1 == $url_pro_status_get_value) {
                                  echo "selected";
                                } ?>>Enable</option>
              <option value="2" <?php if (2 == $url_pro_status_get_value) {
                                  echo "selected";
                                } ?>>Disable</option>
            </select>
            <?php $url_pro_availability_get_value = $this->input->get('pro_availability'); ?>
            <select style="border-radius:10px;height:45px;" class="filter-size-set" name="pro_availability">
              <option value="">-- Availability --</option>
              <option value="1" <?php if (1 == $url_pro_availability_get_value) {
                                  echo "selected";
                                } ?>>In Stock</option>
              <option value="2" <?php if (2 == $url_pro_availability_get_value) {
                                  echo "selected";
                                } ?>>Out Of Stock</option>
              <option value="3" <?php if (3 == $url_pro_availability_get_value) {
                                  echo "selected";
                                } ?>>Up Comming</option>
            </select>
            <!-- <fieldset class="filter-price">
              <div class="price-field">
                <input type="range" min="100" max="500" value="135" id="lower">
                <input type="range" min="100" max="500" value="500" id="upper">
              </div>
              <div class="price-wrap">
                <span class="price-title">FILTER</span>
                <div class="price-container">
                  <div class="price-wrap-1">
                    <label for="one">$</label>
                    <input id="one">
                  </div>
                  <div class="price-wrap_line">-</div>
                  <div class="price-wrap-2">
                    <label for="two">$</label>
                    <input id="two">
                  </div>
                </div>
              </div>
            </fieldset> -->
            <button type="submit" class="btn btn-info btn-lg" id="filter_button" style="margin-bottom: 10px;">Filter</button>
          </form>
          <form action="">
            <select style="border-radius:10px;height:45px;">
              <option value="">delete selected product</option>
            </select>
            <button type="button" class="btn btn-info btn-lg" id="delete_multi_product" style="margin-bottom: 10px;">Apply</button>
          </form>
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th></th>
                  <th>Product ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Availability</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                if (isset($all_product)) {
                  foreach ($all_product as $value) {
                    $i++;
                ?>
                    <tr class="gradeC">
                      <td>
                        <div class="td-overflow"><input type="checkbox" class="multi_pro_id_for_delete" value="<?php echo $value->pro_id ?>"></div>
                      </td>
                      <td><?php echo "$value->pro_id"; ?></td>
                      <td style="vertical-align: middle;"><img src="<?php echo base_url() . 'uploads/' . $value->pro_image; ?>" class="img-rounded" width="120" height="120" /></td>
                      <td>
                        <div class="td-overflow"><?php echo $value->pro_title; ?></div>
                      </td>
                      <td>
                        <div class="td-overflow">
                          <?php
                          $category_data_name = $this->db->select('category_name')
                            ->from('tbl_product_relation PR')
                            ->join('tbl_category C', 'PR.product_cat_id=C.category_id', 'INNER')
                            ->where('PR.product_id', $value->pro_id)
                            ->get()
                            ->result();
                          $category_result_data = '';
                          foreach ($category_data_name as $category_data_name_value) {
                            $category_result_data .= $category_data_name_value->category_name . ',';
                          }
                          echo rtrim($category_result_data, ',');
                          ?>
                        </div>
                      </td>
                      <td>
                        <div class="td-overflow">
                          <?php if ($value->pro_offer_price > 0) { ?>
                            <p><del>$<?php echo $value->pro_price; ?></del></p>
                            <p style="color: #009698;">$<?php echo $value->pro_offer_price; ?></p>
                          <?php } else { ?>
                            <p style="color: #009698;">$<?php echo $value->pro_price; ?></p>
                          <?php } ?>
                        </div>
                      </td>
                      <td>
                        <div class="td-overflow">
                          <?php if ($value->pro_status == 1) {
                            echo "Enable";
                          } else {
                            echo "Disable";
                          } ?>
                        </div>
                      </td>
                      <td>
                        <div class="td-overflow">
                          <?php if ($value->pro_availability == 1) {
                            echo "In Stock($value->pro_quantity)";
                          } elseif ($value->pro_availability == 2) {
                            echo "Out Of Stock";
                          } else {
                            echo "Up Coming";
                          } ?>
                        </div>
                      </td>
                      <td>
                        <div class="td-overflow"><?php echo $value->pro_created_on; ?></div>
                      </td>
                      <td style="display: flex;">
                        <a class="btn btn-info" href="<?php echo base_url() ?>admin/edit-product?pro_id=<?php echo $value->pro_id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a class="btn btn-warning" href="<?php echo base_url() ?>admin/edit-product-attr-image?pro_id=<?php echo $value->pro_id ?>" target="_blank"><i class="fa fa-image" aria-hidden="true"></i></a>
                        <a class="btn btn-primary" href="<?php echo base_url() ?>admin/add-product-to-upsell?pro_id=<?php echo $value->pro_id ?>" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <a class="btn btn-primary" href="<?php echo base_url() ?>admin/product-review/<?php echo $value->pro_id ?>" target="_blank"><i class="fa fa-star" aria-hidden="true"></i></a>
                        <?php if ($this->session->userrole != 5) { ?>
                          <form method="post" action="<?php echo base_url() ?>admin/delete-product/<?php echo (int) $value->pro_id ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');"><button class="btn btn-danger" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
                        <?php } ?>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <p style="margin-top: 30px;">Total products:<?php echo $total_rows; ?></p>
            </div>
            <div class="col-lg-6">
              <?php echo $links; ?>              
            </div>
            </div>
        </div>
      </div>
      <!--End Advanced Tables -->
    </div>
  </div>
</div>
<script>
  var lowerSlider = document.querySelector('#lower');
  var upperSlider = document.querySelector('#upper');
  var lowerValue = document.querySelector('#one');
  var upperValue = document.querySelector('#two');
  if (lowerSlider && upperSlider && lowerValue && upperValue) {
    upperValue.value = upperSlider.value;
    lowerValue.value = lowerSlider.value;
    var lowerVal = parseInt(lowerSlider.value);
    var upperVal = parseInt(upperSlider.value);
    upperSlider.oninput = function() {
      lowerVal = parseInt(lowerSlider.value);
      upperVal = parseInt(upperSlider.value);
      if (upperVal < lowerVal + 4) {
        lowerSlider.value = upperVal - 4;
        if (lowerVal == lowerSlider.min) {
          upperSlider.value = 4;
        }
      }
      upperValue.value = this.value
    };
    lowerSlider.oninput = function() {
      lowerVal = parseInt(lowerSlider.value);
      upperVal = parseInt(upperSlider.value);
      if (lowerVal > upperVal - 4) {
        upperSlider.value = lowerVal + 4;
        if (upperVal == upperSlider.max) {
          lowerSlider.value = parseInt(upperSlider.max) - 4;
        }
      }
      lowerValue.value = this.value
    };
  }
</script>

<script>
  function get_filter(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function() {
      filter.push($(this).val());
    });
    return filter;
  }
  $('#delete_multi_product').click(function() {
    var multi_pro_id = get_filter('multi_pro_id_for_delete');
    if (multi_pro_id == '') {
      swal("select product id", "", "error");
    } else {
      $.ajax({
        method: 'post',
        url: "<?php echo base_url(); ?>admin/delete-multi-product",
        dataType: "json",
        data: {
          multi_pro_id: multi_pro_id,
        },
        success: function(respond) {
          if (respond.success == 'successfully') {
            window.location.href = "<?php echo base_url(); ?>admin/product-list";
          }
        },
      });
    }
  });
</script>