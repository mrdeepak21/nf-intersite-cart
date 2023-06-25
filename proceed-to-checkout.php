<?php
require_once('wp-load.php');

//Check if the cart is empty
if ( WC()->cart->is_empty() ) {wp_redirect(site_url()); exit("Cart is emplty <a href='/'>Return to shop!</a>");}

// Function to retrieve WooCommerce cart items from cookie
function getWooCommerceCartItems() {
	if (function_exists('WC')) {
	  // Get the WooCommerce cart object
	  $cart = WC()->cart;
  
	  // Get the cart cookie name
	  $cookieName = 'woocommerce_cart_hash';
  
	  // Check if the cart cookie exists
	  if (isset($_COOKIE[$cookieName])) {
		// Retrieve the cart data from the cookie
		$cartData = $_COOKIE[$cookieName];
  
  
		// Restore the cart from the cookie data
		$cart->get_cart_from_session();
  
		// Get the cart items
		$cartItems = $cart->get_cart();
  
		return $cartItems;
	  }
	}
  
	return array(); // Return an empty array if the cart cookie is not found or WooCommerce is not active
  }
  
  // Usage example
  $cartItems = getWooCommerceCartItems();
  $last_key = end(array_keys($cartItems));
  
$order = '[';
foreach ($cartItems as $cartItemKey => $cartItem) {
	$p_id = get_field("custom_product_id", $cartItem['product_id']);
$order .= '{"product_id":'.$p_id.',"qty":'. $cartItem['quantity'].'}';
$order.= $cartItemKey == $last_key?'':',';
}
  $order .= ']';

  print_r ('<h1>Processing, please wait...</h1>');

 wp_redirect('https://spiritualfood.in/uf-checkout.php?data='.base64_encode($order),302,'user');
exit;