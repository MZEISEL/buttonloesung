<?php

//Changes the text of the order button on standerd payment methods
function buttonloesung_my_woo_order_button_text(){
  global $buttonloesung_options;
  return $buttonloesung_options["button_text"];
}
add_filter('woocommerce_order_button_text','buttonloesung_my_woo_order_button_text');
