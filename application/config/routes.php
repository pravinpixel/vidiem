<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';


$route['category'] = 'home/category';
$route['exclusive-products/(:any)'] = 'home/exclusiveProduct/$1';
$route['exclusive-products'] = 'home/exclusiveProductAllData';
// $route['product/(:any)'] = 'home/product/$1';

$route['product'] = 'home/product';
$route['compare'] = 'home/compare';
$route['cart'] = 'home/cart';
$route['checkout'] = 'home/checkout';
$route['payment'] = 'home/payment';
$route['about-us'] = 'home/about_us'; 
$route['contact-us'] = 'home/contact_us';
$route['cancellation-policy'] = 'home/cancellation_policy';
$route['disclaimer'] = 'home/Disclaimer';
$route['privacy-policy'] = 'home/privacy_policy';
$route['return-refund-policy'] = 'home/return_refund_policy';
$route['shipping-delivery'] = 'home/shipping_delivery';
$route['sitemap'] = 'home/Sitemap';
$route['terms-conditions'] = 'home/terms_conditions';
$route['search'] = 'home/search';
$route['offers/(:any)'] = 'home/offers/$1';
$route['offers'] = 'home/offers';
$route['book-home-service'] = 'home/book_home_service';
$route['events'] = 'home/Events';
$route['event/(:any)'] = 'home/event/$1';
$route['event'] = 'home/event';
$route['videos'] = 'home/Videos';
$route['Recipe'] = 'home/recipe';
$route['recipe-videos'] = 'home/Recipe_Videos';
$route['Recipesearch'] = 'home/recipe_search';
$route['press-release'] = 'home/press_release';
$route['product-registration'] = 'home/product_registration';
$route['complaint-registration'] = 'home/complaint_registration';
$route['user-manual'] = 'home/user_manual';
$route['faqs'] = 'home/faqs';
$route['demo-videos'] = 'home/demo_videos';
$route['dealer-locator'] = 'home/dealer_locator';
$route['service-centers'] = 'home/service_centers';

$route['service-centers-new'] = 'home/service_centers_new';

$route['warranty'] = 'home/warranty';
$route['google_login'] = 'home/google_login';

$route['buy-now/(:any)'] = 'home/buy_now/$1';
$route['buy-now'] = 'home/buy_now';

// Address
$route['order-success/(:any)'] = 'home/order_success_page/$1';
$route['order-success'] = 'home/order_success_page';
$route['track-order'] = 'home/track_order';
$route['add-address/(:any)'] = 'user/add_address/$1';
$route['add-address'] = 'user/add_address';
$route['edit-address/(:any)/(:any)'] = 'user/edit_address/$1/$2';
$route['edit-address/(:any)'] = 'user/edit_address/$1';
$route['edit-address'] = 'user/edit_address';
$route['delete-address/(:any)'] = 'user/delete_address/$1';
$route['delete-address'] = 'user/delete_address';


// Register and Sign-Up
$route['sign-in'] = 'home/sign_in';
$route['register'] = 'home/register';
$route['guest-login'] = 'home/guest_login';
$route['verify-otp'] = 'home/verify_otp';
$route['register'] = 'home/register';
$route['forgot_password'] = 'home/forgot_password';
$route['forgot-password-otp'] = 'home/forgot_otp';
$route['newtempregister'] = 'home/newtempregister';

// User Dashboard
$route['user/dashboard'] = 'user/Dashboard';
$route['user/settings'] = 'user/Settings';
$route['user/address'] = 'user/Address';
$route['user/credit_slips'] = 'user/CreditSlips';
$route['logout'] = 'home/Logout';

// Order invoice
$route['invoice/(:any)'] = 'home/invoice/$1';
$route['testmail'] = 'home/testmail';
$route['testnew'] = 'home/testnew';

/*** Dealer routes */
$route['dealer-list'] = 'dealer/passwordLinkList';
$route['vidiem-dealer'] = 'dealer/index';
$route['vidiem-dealer/login'] = 'dealer/login';
$route['vidiem-dealer/qrlogin'] = 'qrdealer/login';

/*** Dealer admin and counter persons login */
$route['dealer-admin'] = 'Dealers/dashboard/index';
$route['dealer-admin/view/orders'] = 'Dealers/dashboard/ajax_single_view';
$route['dealer-admin/logout'] = 'Dealers/dealers/logout';
$route['dealer-admin/cancel_order'] = 'Dealers/dealers/cancelOrder';
$route['dealer-admin/do_counter_payment'] = 'Dealers/dealers/doCounterPayment';
$route['Admin/dealer/do_counter_payment'] = 'Home/doCounterAdminPayment';
$route['dealer-admin/payment/update/(:any)'] = 'Dealers/dashboard/orderPayment/$1';
$route['dealer-admin/dealers'] = 'Dealers/dealers/index';
$route['dealer-admin/dealers/add'] = 'Dealers/dealers/add_edit';
$route['dealer-admin/dealers/add/(:any)'] = 'Dealers/dealers/add_edit/$1';
$route['dealer-admin/dealers/(:any)/location'] = 'Dealers/Location/index/$1';

$route['dealer-admin/(:any)/location/add'] = 'Dealers/Location/add_edit/$1';
$route['dealer-admin/(:any)/location/add/(:any)'] = 'Dealers/Location/add_edit/$1/$2';
$route['dealer-admin/location/save'] = 'Dealers/Location/save';
$route['dealer-admin/dealers/reports'] = 'Dealers/Report/index';

// Dashboard Redirect 
//$route['Admin'] = 'Admin/home';
$route['Admin/forgot_password'] = 'Admin/home/forgot_password';
$route['Admin/logout'] = 'Admin/home/logout';

// Master Short Cut
$route['destroy'] = 'home/destroy';
$route['vidiem-adc'] = 'home/vidiem_adc';
$route['vidiem-iris'] = 'home/vidiem_iris';
$route['vidiem-tusker'] = 'home/vidiem_tusker';

$route['vidiem-by-you-customization'] = 'home/vidiem_for_you';
$route['vidiem-by-you'] = 'home/vidiemStartCustomize';
$route['customize-cart'] = 'home/customize_cart';
$route['customize-checkout'] = 'home/customize_checkout';
$route['custom-order-success/(:any)'] = 'home/custom_order_success_page/$1';
$route['custom-order-success'] = 'home/custom_order_success_page';
$route['vidiem-by-you-recustomize'] = 'home/vidiem_by_you_recustomize';

// Order invoice
$route['custominvoice/(:any)'] = 'home/custominvoice/$1';
$route['googlefeedxml'] = 'home/googlexmlgenrate';

$route['404_override'] = 'home/page_not_found';
$route['translate_uri_dashes'] = FALSE;
$route['user/test'] = 'user/test';
//$route['cron/cron-uncompleted-orders'] ='home/uncompletedorder_cron';
$route['cron/cron-uncompleted-orders'] = 'cronjobs/uncompletedorder_cron';
$route['trackingorder'] = 'trackingorder/index';

$route['Admin/dealer_management/add'] = 'Admin/Dealer_management/add';
$route['Admin/dealer_management/(:any)/location'] = 'Admin/Dealer_management/location_index/$1';
$route['Admin/dealer_management/location_save'] = 'Admin/Dealer_management/location_save';
$route['Admin/dealer_management/(:any)/location/add'] = 'Admin/Dealer_management/location_add/$1';
$route['Admin/dealer_management/(:any)/location/add/(:any)'] = 'Admin/Dealer_management/location_add/$1/$2';
$route['Admin/dealer_management/(:any)/location_delete_status_update/(:any)'] = 'Admin/Dealer_management/location_delete_status_update/$1/$2';

$route['test-mail'] = 'tracking/test_mail';
$route['test-sms'] = 'tracking/test_sms';
$route['Admin/payment/update/(:any)'] = 'Home/adminOrderPayment/$1';
$route['home/AjaxProductFilter'] = 'home/AjaxProductFilter';
// print_r($_REQUEST); exit;
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$except = true;
if(strpos($actual_link,"/Admin")!==false)  $except = false;
if(strpos($actual_link,"/dealer") !==false) $except = false;
if(strpos($actual_link,"/user") !==false) $except = false;
if($except) {
$route['(:any)/(:any)']['get'] = 'home/product/$1/$2';
$route['(:any)']['get'] = 'home/category/$1';
} 

