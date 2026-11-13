<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->get('/', 'Home::index');

// Only storefront/customer routes belong in this application. Category
// catch-all routes are deferred until their Home actions are migrated.
$frontendRoutes = [
    'product-details/(:segment)'                     => 'Home::product_details/$1',
    'product-quick/(:segment)'                       => 'Home::product_quick/$1',
    'product-type/(:segment)'                        => 'Home::product_type/$1',
    'shop'                                           => 'Home::shop',
    'about-us'                                       => 'Home::about_us',
    'contact-us'                                     => 'Home::contact_page',
    'halloween'                                      => 'Halloween::index',
    'christmas'                                      => 'Christmas::index',
    'happynewyear'                                   => 'HappyNewYear::index',
    'valentine'                                      => 'Valentine::index',
    'register'                                       => 'Account::register',
    'country-name'                                   => 'Currency::findcountryname',
    'profile'                                        => 'Profile::index',
    'my-order'                                       => 'Profile::order_list',
    'my-order/(:segment)'                            => 'Profile::order_list_by_id/$1',
    'order-status'                                   => 'Profile::order_status',
    'upload-order'                                   => 'Profile::upload_order',
    'recently-view'                                  => 'Profile::recently_view',
    'my-address'                                     => 'Profile::address_list',
    'edit-my-address'                                => 'Profile::edit_address_list',
    'favorite'                                       => 'Profile::favorite_details',
    'my-credits'                                     => 'Profile::my_credits',
    'my-coupon'                                      => 'Profile::my_coupon',
    'my-profile'                                     => 'Profile::my_profile',
    'edit-my-profile'                                => 'Profile::edit_my_profile',
    'my-profile-shopping-cart'                       => 'Profile::profile_shopping_cart',
    'my-news-letter'                                 => 'Profile::news_letter',
    'my-reviews'                                     => 'Profile::my_reviews',
    'my-wishlist'                                    => 'Profile::wishlist_list',
    'free'                                           => 'Coupon::adds_form',
    'terms-of-use'                                   => 'Home::terms_of_use',
    'privacy-policy'                                 => 'Home::privacy_policy',
    'faq'                                            => 'Home::faq',
    'sitemap'                                        => 'Home::sitemap',
    'warranty-information'                           => 'Home::warranty_page',
    'shipping-policy'                                => 'Home::shipping_policy',
    'returns-info'                                   => 'Home::return_page',
    'complaints'                                     => 'Home::complaints_page',
    'delivery-info'                                  => 'Home::delivery_page',
    'sustainability'                                 => 'Home::sustainability_page',
    'applicants'                                     => 'Applicant::index',
    'blog'                                           => 'Blog::blog',
    'tags'                                           => 'Blog::tagsAll',
    'blog/category'                                  => 'Blog::blogByCategory',
    'blog/category/(:segment)'                       => 'Blog::blogByCategorySlug/$1',
    'blog/(:segment)'                                => 'Blog::singleBlog/$1',
    'tags/(:segment)'                                => 'Blog::blogByTags/$1',
    'Country_controller'                             => 'Country::countries',
    'show-cart'                                      => 'Cart::show_cart',
    'checkout'                                       => 'Checkout::checkout',
    'Checkout/checkout'                              => 'Checkout::checkout',
    'order-success'                                  => 'Checkout::order_success',
    'checkout-billing'                               => 'Newcheckout::billing',
    'checkout-payment'                               => 'Newcheckout::payment',
    'search'                                         => 'Search::index',
    'search_filter'                                  => 'Search::filterdata',
    'track-order-status'                             => 'OrderStatus::track_order_status',
    'Search/filterdata/(:segment)'                   => 'Search::filterdata/$1',
    'Home/shop/(:segment)'                           => 'Home::shop/$1',
    'Blog/blog/(:segment)'                           => 'Blog::blog/$1',
    'Blog/blog'                                      => 'Blog::blog',
    'Blog/blogByCategory'                            => 'Blog::blogByCategory',
    'Blog/tagsAll'                                   => 'Blog::tagsAll',
];

foreach ($frontendRoutes as $route => $handler) {
    $routes->get($route, $handler);
}
$postRoutes = [
    'makeusernew'                         => 'Account::makeNewUser',
    'regotpmatch'                         => 'Account::reg_otp_match',
    'reg_resend_otp'                      => 'Account::reg_resend_otp',
    'reset_resend_otp'                    => 'Account::reset_resend_otp',
    'userlogin'                           => 'Account::userLogin',
    'forget_account_password'             => 'Account::forget_password',
    'forget_account_reset_new'            => 'Account::forget_password_new_set',
    'forget_otp_match'                    => 'Account::forget_password_otp_match',
    'logout'                              => 'Account::user_logout',
    'currency-convert'                    => 'Currency::currencyConverter',
    'Country_controller_state'             => 'Country::states',
    'Country_controller_city'              => 'Country::cities',
    'update-profile-address'              => 'Profile::update_address',
    'update-profile'                      => 'Profile::update_profile',
    'update-profile-image'                => 'Profile::updateProfileImage',
    'change-account-password'             => 'Profile::change_account_password',
    'add-reviews'                         => 'Profile::add_reviews',
    'add-product-seller'                  => 'Profile::add_product_seller',
    'add-wishlist'                        => 'Profile::add_wishlist',
    'delete-wishlist-list'                => 'Profile::delete_wishlist_list',
    'news-letter'                         => 'Profile::news_letter_status',
    'news-letter-profile'                 => 'Profile::profile_news_letter_status',
    'discount-form-free'                  => 'Coupon::discount_form_submit',
    'contact-form'                        => 'Home::insert_contact_info',
    'applicant-save'                      => 'Applicant::applicant_submit',
    'commentOnBlog'                       => 'Blog::commentFormSubmit',
    'replyOnComment'                      => 'Blog::replyCommentFormSubmit',
    'likeCommentedData'                   => 'Blog::likeCommentedDataInsert',
    'likebloginsert'                      => 'Blog::likeBlog',
    'add-to-cart'                         => 'Cart::add_to_cart',
    'add-to-cart-details'                 => 'Cart::add_to_cart_details',
    'delete-to-cart/(:segment)'           => 'Cart::delete_to_cart/$1',
    'delete-to-cart-header/(:segment)'    => 'Cart::delete_to_cart_header/$1',
    'update-cart-qty'                     => 'Cart::update_cart_quantity',
    'update-cart-qty-payment'              => 'Cart::update_cart_quantity_payment',
    'update-cart-qty-shipping'             => 'Cart::update_cart_shipping_method',
    'delete-to-cart-payment/(:segment)'    => 'Cart::delete_to_cart_payment/$1',
    'cart-coupon-discount'                => 'Cart::cartCouponDiscount',
    'search_filter'                        => 'Search::filterdata',
    'product-color-data-value-get'         => 'Cart::get_color_data',
    'product-size-data-value-get'          => 'Cart::get_size_data',
    'checkout-shipping-save'               => 'Newcheckout::shipping_save',
    'checkout-billing-save'                => 'Newcheckout::billing_save',
];
foreach ($postRoutes as $route => $handler) {
    $routes->post($route, $handler);
}
$routes->post('fetch-attr-image-proid', 'Cart::get_attribute_images');
$routes->post('credentials-sent', 'Customer::sent_credentials');
$routes->get('reset-account-password-mail', 'Customer::resetAccountPasswordMail');
$routes->post('reset-account-password-mail-update', 'Customer::resetAccountPasswordMailUpdate');
$routes->get('my-stripe', 'StripeController::index');
$routes->post('stripe-shipping-details', 'StripeController::shipping_in_session');
$routes->post('stripePost', 'StripeController::stripePost');
$routes->post('currency-exchange-rate-added', 'Currency::exchangedRateAddedCrone');
$routes->post('send-email-to-return-cart', 'CroneMailSent::sendEmailToCartReturn');
$routes->get('return-cart', 'Cart::ReturnCart');
$routes->post('order-completed-success', 'Checkout::order_payment_success');
$routes->post('order-place', 'Checkout::order_place');

require APPPATH . 'Config/BackendRoutes.php';

// Keep category fallbacks last so explicit storefront routes always win.
$routes->get('(:segment)/(:segment)/(:segment)', 'Home::show_product_by_sub_sub_cat_id/$1/$2/$3');
$routes->get('(:segment)/(:segment)', 'Home::show_product_by_sub_cat_id/$1/$2');
$routes->get('(:segment)', 'Home::show_product_by_cat_id/$1');
$routes->set404Override('App\Controllers\Home::_404_page');
