<?php

global $buttonloesung_options;

//Reordering the checkout page elements
add_action( 'woocommerce_checkout_order_review', 'buttonloesung_reordering_checkout_order_review', 1 );
function buttonloesung_reordering_checkout_order_review(){
  //First remove the order review and payment
  remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
  remove_action('woocommerce_checkout_order_review','woocommerce_checkout_payment', 20);
  remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_terms_and_conditions', 30);
  //Then add it in a different order
  add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment');
  add_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review');
  //Add buybutton to the end
  add_action( 'woocommerce_checkout_order_review', 'buttonloesung_output_payment_button');
  remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
}

function buttonloesung_output_payment_button() {
    $order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );
    echo '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />';
}

//Remove the button from the order review section to add it at the bottom
add_filter( 'woocommerce_order_button_html', 'buttonloesung_remove_woocommerce_order_button_html', 10, 1);
function buttonloesung_remove_woocommerce_order_button_html() {
  return '';
}

//Change the Your order checkout label to Zahlungsmethoden
function buttonloesung_wc_billing_field_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Your order' :
$translated_text = __( 'Zahlungsmethoden', 'woocommerce' );
break;
case 'Deine Bestellung' :
$translated_text = __( 'Zahlungsmethoden', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'buttonloesung_wc_billing_field_strings', 20, 3 );

//Adds a Heading for the Order review
function buttonloesung_add_order_review_heading(){
  $output = "<h3>Bestellungszusammenfassung</h3>";
  echo $output;
}
add_action("woocommerce_review_order_after_payment", "buttonloesung_add_order_review_heading");

//Adds a heading for the AGB
function buttonloesung_add_agb_heading(){
  global $buttonloesung_options;
  $output = "<h3>Geschäftsbedingungen</h3>";
  $output .= $buttonloesung_options['agb_text'];
  echo $output;
}
add_action("woocommerce_checkout_before_terms_and_conditions", "buttonloesung_add_agb_heading");

//Removes the default terms and conditions Text
function buttonloesung_remove_terms_conditions(){
  remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
}
add_action( 'init', 'buttonloesung_remove_terms_conditions');

//Add product picture to checkout page
if ($buttonloesung_options['productpicturecheckout'] == 1){
  add_filter( 'woocommerce_cart_item_name', 'buttonloesung_product_thumbnail_in_checkout', 20, 3 );
  function buttonloesung_product_thumbnail_in_checkout( $product_name, $cart_item, $cart_item_key ){
      if ( is_checkout() ) {

          $thumbnail   = $cart_item['data']->get_image(array( 70, 70));
          $image_html  = '<div class="product-item-thumbnail" style="float: left; padding-right: 8px">'.$thumbnail.'</div> ';

          $product_name = $image_html . $product_name;
      }
      return $product_name;
  }
}
