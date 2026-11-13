<?php

// Login endpoints stay public; protected backend routes use the /admin prefix.
$routes->get('Login', 'Backend\Login::index');
$routes->get('login', 'Backend\Login::index');
$routes->get('admin/login', 'Backend\Login::index');
$routes->post('checklogin', 'Backend\Login::checklogin');
$routes->get('login_error', 'Backend\Login::login_error');
$routes->get('admin-signup', 'Backend\Login::admin_signup');
$routes->post('admin-signup', 'Backend\Login::admin_signup');
$routes->get('admin', 'Backend\Admin::admindashboard', ['filter' => 'adminAuth']);

$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes): void {
    $routes->post('logoutadmin', 'Backend\Login::adminlogout');
    $routes->get('register-form', 'Backend\Admin::registerform');
    $routes->post('makeadminnew', 'Backend\Admin::makeadmin');
    $routes->get('contact-message-list', 'Backend\Contact::get_all_contact_message');
    $routes->post('delete-contact/(:segment)', 'Backend\Contact::delete_contact_by_id/$1');
    $routes->get('view-contact/(:segment)', 'Backend\Contact::view_contact_by_id/$1');
    $routes->get('complaints-message-list', 'Backend\Contact::get_all_complaints_message');
    $routes->get('applicants-message-list', 'Backend\Contact::get_all_applicants_message');
    $routes->get('customer-details', 'Backend\Contact::customer_details');
    $routes->get('customer-details-edit', 'Backend\Contact::customer_details_update');
    $routes->post('customer-details-edit-save', 'Backend\Contact::customer_details_update_save');
    $routes->post('customer-details-delete/(:segment)', 'Backend\Contact::customer_details_delete/$1');
    $routes->get('discount-email-list', 'Backend\CouponAdmin::get_all_discount_email_list');
    $routes->post('delete-discount-email/(:segment)', 'Backend\CouponAdmin::delete_discount_email_id/$1');
    $routes->get('sms-details', 'Backend\CouponAdmin::get_all_sms_list');
    $routes->get('add-coupon', 'Backend\CouponAdmin::index');
    $routes->post('add-coupon-record', 'Backend\CouponAdmin::add_coupon_record');
    $routes->get('coupon-record-list', 'Backend\CouponAdmin::coupon_record_list');
    $routes->match(['get', 'post'], 'edit-discount-coupon/(:segment)', 'Backend\CouponAdmin::edit_discount_coupon/$1');
    $routes->post('delete-discount-coupon/(:segment)', 'Backend\CouponAdmin::delete_discount_coupon/$1');
    $routes->get('add-shipping-charge', 'Backend\ShippingAdmin::index');
    $routes->post('add-shipping-charge-record', 'Backend\ShippingAdmin::add_shipping_record');
    $routes->get('shipping-charge-record-list', 'Backend\ShippingAdmin::shipping_record_list');
    $routes->get('edit-shipping-charge/(:segment)', 'Backend\ShippingAdmin::edit_shipping_charge/$1');
    $routes->post('update-shipping-charge', 'Backend\ShippingAdmin::update_shipping_charge');
    $routes->post('delete-shipping-charge/(:segment)', 'Backend\ShippingAdmin::delete_shipping_charge/$1');
    $routes->get('add-shipping-charge-to-products', 'Backend\ShippingAdmin::add_shipping_charge_to_products');
    $routes->post('save-shipping-charge-to-products', 'Backend\ShippingAdmin::save_shipping_charge_to_products');
    $routes->get('shipping-charge-products-list', 'Backend\ShippingAdmin::shipping_charge_products_list');
    $routes->get('edit-shipping-product-list-charge/(:segment)', 'Backend\ShippingAdmin::edit_shipping_product_list_charge/$1');
    $routes->post('edit-save-shipping-charge-to-products', 'Backend\ShippingAdmin::edit_save_shipping_charge_to_products');
    $routes->post('delete-save-shipping-charge-to-products', 'Backend\ShippingAdmin::delete_save_shipping_charge_to_products');
    $routes->get('manage-order', 'Backend\OrderAdmin::manage_order');
    $routes->get('view-order/(:segment)', 'Backend\OrderAdmin::view_order/$1');
    $routes->post('delete-order/(:segment)', 'Backend\OrderAdmin::delete_order/$1');
    $routes->post('send-orderno-to-customer', 'Backend\OrderAdmin::sendOrderNoToCus');
    $routes->get('product-review/(:segment)', 'Backend\ReviewAdmin::product_review/$1');
    $routes->post('product-review-update', 'Backend\ReviewAdmin::product_review_update');
    $routes->get('add-blog', 'Backend\BlogAdmin::index');
    $routes->post('insert-blog', 'Backend\BlogAdmin::insert_blog_data');
    $routes->get('blog-list', 'Backend\BlogAdmin::show_blog_list');
    $routes->get('edit-blog', 'Backend\BlogAdmin::edit_blog_form');
    $routes->post('update-blog', 'Backend\BlogAdmin::update_blog');
    $routes->post('delete-blog', 'Backend\BlogAdmin::delete_blog');
    $routes->post('add-tagsofblog', 'Backend\BlogAdmin::addtagsofblog');
    $routes->post('add-categoryofblog', 'Backend\BlogAdmin::addcategoryofblog');
    $routes->post('fetchalltagsofblog', 'Backend\BlogAdmin::fetchalltags');
    $routes->post('fetchallcategoryofblog', 'Backend\BlogAdmin::fetchallcategory');

    $routes->get('add-category', 'Backend\Category::add_category_form');
    $routes->post('save-category', 'Backend\Category::save_category');
    $routes->post('save-sub-category', 'Backend\Category::save_sub_category');
    $routes->post('save-sub-sub-category', 'Backend\Category::save_sub_sub_category');
    $routes->get('category-list', 'Backend\Category::show_category_list');
    $routes->get('sub-category-list', 'Backend\Category::show_sub_category_list');
    $routes->get('sub-of-sub-category-list', 'Backend\Category::show_sub_sub_category_list');
    $routes->get('edit-category/(:segment)', 'Backend\Category::edit_category/$1');
    $routes->get('edit-sub-category/(:segment)', 'Backend\Category::edit_sub_category/$1');
    $routes->get('edit-sub-sub-category/(:segment)', 'Backend\Category::edit_sub_sub_category/$1');
    $routes->post('update-category/(:segment)', 'Backend\Category::update_category/$1');
    $routes->post('update-sub-category/(:segment)', 'Backend\Category::update_sub_category/$1');
    $routes->post('update-sub-sub-category/(:segment)', 'Backend\Category::update_sub_sub_category/$1');
    $routes->post('delete-category/(:segment)', 'Backend\Category::delete_category/$1');
    $routes->post('delete-sub-category/(:segment)', 'Backend\Category::delete_sub_category/$1');
    $routes->post('delete-sub-sub-category/(:segment)', 'Backend\Category::delete_sub_sub_category/$1');
    $routes->post('sub-category-ajax', 'Backend\Category::get_sub_subcat');
    $routes->post('sub-sub-category-ajax', 'Backend\Category::get_sub_sub_subcat');

    $routes->get('add-brand', 'Backend\Brand::add_brand_form');
    $routes->post('save-brand', 'Backend\Brand::save_brand');
    $routes->get('brand-list', 'Backend\Brand::show_brand_list');
    $routes->get('edit-brand/(:segment)', 'Backend\Brand::edit_brand/$1');
    $routes->post('update-brand/(:segment)', 'Backend\Brand::update_brand/$1');
    $routes->post('delete-brand/(:segment)', 'Backend\Brand::delete_brand/$1');

    $routes->get('add-baner', 'Backend\Baner::add_baner_form');
    $routes->post('save-baner', 'Backend\Baner::insert_baner');
    $routes->get('baner-list', 'Backend\Baner::show_baner_list');
    $routes->get('edit-baner/(:segment)', 'Backend\Baner::edit_baner_form/$1');
    $routes->post('update-baner', 'Backend\Baner::update_baner');
    $routes->post('delete-baner', 'Backend\Baner::delete');

    $routes->match(['get', 'post'], 'add-product-tags', 'Backend\Attribute::add_tags');
    $routes->get('product-tags-list', 'Backend\Attribute::show_tags');
    $routes->get('edit-product-tags/(:segment)', 'Backend\Attribute::edit_product_tags/$1');
    $routes->post('update-product-tags', 'Backend\Attribute::update_product_tags');
    $routes->post('delete-product-tags/(:segment)', 'Backend\Attribute::delete_product_tags/$1');

    $routes->match(['get', 'post'], 'add-product-type', 'Backend\Attribute::add_type');
    $routes->get('product-type-list', 'Backend\Attribute::show_type');
    $routes->get('edit-product-type/(:segment)', 'Backend\Attribute::edit_product_type/$1');
    $routes->post('update-product-type', 'Backend\Attribute::update_product_type');
    $routes->post('delete-product-type/(:segment)', 'Backend\Attribute::delete_product_type/$1');

    $routes->match(['get', 'post'], 'add-product-sizes', 'Backend\Attribute::add_sizes');
    $routes->get('product-sizes-list', 'Backend\Attribute::show_sizes');
    $routes->get('edit-product-sizes/(:segment)', 'Backend\Attribute::edit_product_sizes/$1');
    $routes->post('update-product-sizes', 'Backend\Attribute::update_product_sizes');
    $routes->post('delete-product-sizes/(:segment)', 'Backend\Attribute::delete_product_sizes/$1');

    $routes->match(['get', 'post'], 'add-product-color', 'Backend\Attribute::add_product_color');
    $routes->get('product-color-list', 'Backend\Attribute::show_color_list');
    $routes->get('edit-product-color/(:segment)', 'Backend\Attribute::edit_product_color/$1');
    $routes->post('update-product-color', 'Backend\Attribute::update_product_color');
    $routes->post('delete-product-color/(:segment)', 'Backend\Attribute::delete_product_color/$1');

    $routes->match(['get', 'post'], 'add-product-search_keywords', 'Backend\Attribute::add_product_search_keywords');
    $routes->get('product-search_keywords-list', 'Backend\Attribute::show_search_keywords_list');
    $routes->get('edit-product-search_keywords/(:segment)', 'Backend\Attribute::edit_product_search_keywords/$1');
    $routes->post('update-product-search_keywords', 'Backend\Attribute::update_product_search_keywords');
    $routes->post('delete-product-search_keywords/(:segment)', 'Backend\Attribute::delete_product_search_keywords/$1');

    $routes->get('colorconvert', 'Backend\Attribute::colorconvertvalue');
    $routes->get('edit-product-attr-image', 'Backend\Attribute::product_attr_image');
    $routes->post('product-attr-image-save', 'Backend\Attribute::product_attr_image_save');
    $routes->post('product-attr-image-delete', 'Backend\Attribute::product_attr_image_delete');
    $routes->post('product-feature-image-delete', 'Backend\Attribute::product_feature_image_delete');

    $routes->get('product-list', 'Backend\ProductCatalog::show_product_list');
    $routes->get('search_filter_backend', 'Backend\ProductCatalog::filter_backend_product_details');
    $routes->get('search_by_product_name', 'Backend\ProductCatalog::filterdata_by_product_name');
    $routes->post('search_by_product_name', 'Backend\ProductCatalog::filterdata_by_product_name');
    $routes->get('add-product', 'Backend\Product::add_product_form');
    $routes->post('save-product', 'Backend\Product::insert_product');
    $routes->get('edit-product', 'Backend\Product::edit_product');
    $routes->post('update-product', 'Backend\Product::update_product');
    $routes->post('delete-product/(:segment)', 'Backend\Product::delete_product/$1');
    $routes->post('delete-multi-product', 'Backend\Product::delete_multi_product');
    $routes->get('add-product-to-upsell', 'Backend\Product::add_product_to_upsell');
    $routes->post('add-product-to-upsell-insert', 'Backend\Product::add_product_to_upsell_insert');
    $routes->post('add-product-to-upsell-delete/(:segment)', 'Backend\Product::add_product_to_upsell_delete/$1');
    $routes->get('product-preview', 'Backend\Product::product_preview');
    $routes->get('add-video', 'Backend\Product::add_product_video_form');
    $routes->post('save-product-video', 'Backend\Product::save_product_video');
    $routes->get('video-list', 'Backend\Product::video_list');
    $routes->get('edit-product-video/(:segment)', 'Backend\Product::video_edit_product/$1');
    $routes->post('update-product-video', 'Backend\Product::update_product_video');
    $routes->post('video-list-delete/(:segment)', 'Backend\Product::video_delete/$1');
});
