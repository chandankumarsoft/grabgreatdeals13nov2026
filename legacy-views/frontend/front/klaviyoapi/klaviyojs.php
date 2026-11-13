<script
  async type="text/javascript" src="//static.klaviyo.com/onsite/js/klaviyo.js?company_id=TRss7p">  	
 </script>
 <?php 
    if ($this->session->userdata('cus_id') !='') { 
    	$cutomer_information = $this->db->select('TC.cus_name,TC.cus_email,TC.date_of_birth,TCO.country')->from('tbl_customer TC')->join('country TCO','TC.cus_country = TCO.id','left')->where('cus_id',$this->session->userdata('cus_id'))->get()->row();
 ?>
	 <script>
	  var _learnq = _learnq || [];

	  _learnq.push(['identify', {
	    '$email' : '<?php echo trim($cutomer_information->cus_email);  ?>',
	    '$first_name' : '<?php echo trim($cutomer_information->cus_name);  ?>',
	    '$last_name' : '<?php echo trim($cutomer_information->cus_name);  ?>',
	  }]);

	  _learnq.push(['track', 'Elected President', {
	    'Country' : '<?php echo (trim($cutomer_information->country)!=NULL) ? trim($cutomer_information->country) : "defaultcountry";  ?>'
	  }]);
	</script>
    <?php     
    if ($this->uri->segment(1)=="product-details") {  
     
    ?>
    	      	<script type="text/javascript">
				   var _learnq = _learnq || [];
				   var item = {
				     "ProductName": "<?php echo trim($product_info->pro_title); ?>",
				     "ProductID": "<?php echo trim($product_info->pro_id); ?>",
				     "SKU": "<?php echo trim($product_info->product_sku_name); ?>",
				     "Categories": <?php echo json_encode($this->CategoryModel->findAllCatNameByProID($product_info->pro_id)); ?>,
				     "ImageURL": "<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/' . $product_info->pro_image; ?>",
				     "URL": "<?php echo base_url()?>product-details/<?php echo $product_info->pro_title_slug; ?>",
				     "Brand": "<?php echo trim($product_info->pro_brand); ?>",
				     "Price": <?php echo preg_replace( '/[^0-9.]/', '', currencyConverterFunction($product_info->pro_price)); ?>,
				     "CompareAtPrice": <?php echo preg_replace( '/[^0-9.]/', '', currencyConverterFunction($product_info->pro_offer_price)); ?>,
				     "currencytype": "<?php echo $this->session->userdata('currency_code_session'); ?>",
				   };
				 
				   _learnq.push(["track", "Viewed Product", item]);
				</script>
    <?php } ?>    


				<?php if ($this->uri->segment(1) == "show-cart")
				{
				    $cart_content = $this->cart->contents();
				    $cartDataItem = array();
				    $carti = 0;
				    foreach ($cart_content as $item)
				    {
				    	if ($carti==0) {
				    		$cartTotalKlaviyo =preg_replace( '/[^0-9.]/', '', currencyConverterFunction($this->cart->total())); 
				    		$cartsinglename   =$item["name"];
				    		$cartsingleid  =$item["id"];
				    		$cartsinglesku  =$item['options']['product_sku'];
				    		$cartsinglecategory  =json_encode($this->CategoryModel->findAllCatNameByProID($item['id']));
				    		$cartsingleurl  =base_url() . 'product-details/' . $item["pro_title_slug"];
				    		$cartsinglecheckouturl  =base_url() . 'checkout/';
				    		$cartsingleimageurl  ='https://www.seller.grabgreatdeals.com/' . 'uploads/' . $item['options']['pro_image'];
				    		$cartsingleprice  =preg_replace( '/[^0-9.]/', '', currencyConverterFunction($item["price"]));
				    		$cartsinglepqty  =$item["qty"];
				    	}
				        $cartDataItem[$carti]['ProductID']   = $item['id'];
				        $cartDataItem[$carti]['SKU']         = $item['options']['product_sku'];
				        $cartDataItem[$carti]['ProductName'] = $item["name"];
				        $cartDataItem[$carti]['Quantity']    = $item["qty"];
	$cartDataItem[$carti]['ItemPrice']   = preg_replace( '/[^0-9.]/', '', currencyConverterFunction($item["price"]));
	$cartDataItem[$carti]['RowTotal']    = preg_replace( '/[^0-9.]/', '', currencyConverterFunction($item["subtotal"]));
				        $cartDataItem[$carti]['ProductURL']  = base_url() . 'product-details/' . $item["pro_title_slug"];
				        $cartDataItem[$carti]['ImageURL']    = 'https://www.seller.grabgreatdeals.com/' . 'uploads/' . $item['options']['pro_image'];
				        $cartDataItem[$carti]['ProductCategories'] = json_encode($this->CategoryModel->findAllCatNameByProID($item['id']));
				        $carti++;
				    }
                    $cartpronamei=0;
                    $cartpronamearr=array();
                    foreach ($cart_content as $itemproductname)
				    {
                         $cartpronamearr[]=$itemproductname['name'];
                         $cartpronamei++;
				    }

				?>

    	      	<script type="text/javascript">
			   _learnq.push(["track", "Added to Cart", {
			     "$value": <?php echo $cartTotalKlaviyo; ?>,
			     "AddedItemProductName": "<?php echo $cartsinglename; ?>",
			     "AddedItemProductID": "<?php echo $cartsingleid; ?>",
			     "AddedItemSKU": "<?php echo $cartsinglesku; ?>",
			     "AddedItemCategories": <?php echo $cartsinglecategory; ?>,
			     "AddedItemImageURL": "<?php echo $cartsingleimageurl; ?>",
			     "AddedItemURL": "<?php echo $cartsingleurl; ?>",
			     "AddedItemPrice": <?php echo $cartsingleprice; ?>,
			     "AddedItemQuantity": <?php echo $cartsingleid; ?>,
			     "ItemNames": <?php echo json_encode($cartpronamearr); ?>,
			     "CheckoutURL": "<?php echo $cartsinglecheckouturl; ?>",
			     "Items": <?php echo json_encode($cartDataItem) ?>
			   }]);
			 </script>
    <?php } ?>
     

     				<?php if ($this->uri->segment(1) == "checkout")
				{
				    $checkout_content = $this->cart->contents();
				    $checkoutDataItem = array();
				    $checkouti = 0;
				    foreach ($checkout_content as $checkoutitem)
				    {
				    	if ($checkouti==0) {
				    		$checkoutTotalKlaviyo =preg_replace( '/[^0-9.]/', '', currencyConverterFunction($this->cart->total())); 
				    		$checkoutsinglename   =$checkoutitem["name"];
				    		$checkoutsingleid  =$checkoutitem["id"];
				    		$checkoutsinglesku  =$checkoutitem['options']['product_sku'];
				    		$checkoutsinglecategory  =json_encode($this->CategoryModel->findAllCatNameByProID($checkoutitem['id']));
				    		$checkoutsingleurl  =base_url() . 'product-details/' . $checkoutitem["pro_title_slug"];
				    		$checkoutsinglecheckouturl  =base_url() . 'checkout/';
				    		$checkoutsingleimageurl  ='https://www.seller.grabgreatdeals.com/' . 'uploads/' . $checkoutitem['options']['pro_image'];
				    		$checkoutsingleprice  =preg_replace( '/[^0-9.]/', '', currencyConverterFunction($checkoutitem["price"]));
				    		$checkoutsinglepqty  =$checkoutitem["qty"];
				    	}
				        $checkoutDataItem[$checkouti]['ProductID']   = $checkoutitem['id'];
				        $checkoutDataItem[$checkouti]['SKU']         = $checkoutitem['options']['product_sku'];
				        $checkoutDataItem[$checkouti]['ProductName'] = $checkoutitem["name"];
				        $checkoutDataItem[$checkouti]['Quantity']    = $checkoutitem["qty"];
	$checkoutDataItem[$checkouti]['ItemPrice']   = preg_replace( '/[^0-9.]/', '', currencyConverterFunction($checkoutitem["price"]));
	$checkoutDataItem[$checkouti]['RowTotal']    = preg_replace( '/[^0-9.]/', '', currencyConverterFunction($checkoutitem["subtotal"]));
				        $checkoutDataItem[$checkouti]['ProductURL']  = base_url() . 'product-details/' . $checkoutitem["pro_title_slug"];
				        $checkoutDataItem[$checkouti]['ImageURL']    = 'https://www.seller.grabgreatdeals.com/' . 'uploads/' . $checkoutitem['options']['pro_image'];
				        $checkoutDataItem[$checkouti]['ProductCategories'] = json_encode($this->CategoryModel->findAllCatNameByProID($checkoutitem['id']));
				        $checkouti++;
				    }
                    $checkoutpronamei=0;
                    $checkoutpronamearr=array();
                    foreach ($checkout_content as $itemproductname)
				    {
                         $checkoutpronamearr[]=$itemproductname['name'];
                         $checkoutpronamei++;
				    }

				?>

    	      	<script type="text/javascript">
			   _learnq.push(["track", "Started Checkout", {
			     "$event_id": "1000123_1387299423",
			     "$value": <?php echo $checkoutTotalKlaviyo; ?>,			    
			     "ItemNames": <?php echo json_encode($checkoutpronamearr); ?>,
			     "CheckoutURL": "<?php echo $checkoutsinglecheckouturl; ?>",
			     "Categories": <?php echo $checkoutsinglecategory; ?>,
			     "Items": <?php echo json_encode($checkoutDataItem) ?>
			   }]);
			 </script>
    <?php } ?>
 <?php } ?>
