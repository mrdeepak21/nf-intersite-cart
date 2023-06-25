<?php
require_once('wp-load.php');
$data = $_REQUEST['data'];
if(empty($data)) {wp_redirect('https://upvasfood.com/'); exit;}
$data = json_decode(base64_decode(trim($data)));
if(class_exists( 'woocommerce' )){
WC()->cart->empty_cart();
$status = false;
foreach($data as $item) {
$status .= WC()->cart->add_to_cart($item->product_id, $item->qty );
}
if($status) {
    wp_safe_redirect(wc_get_checkout_url());
    exit;
}
} else {
    exit("Internal error: eCommerce not active.");
    exit;
}