<?php

/** Display shipping estimates for WC shipping rates */
function buttonloesung_sv_shipping_method_estimate_label( $label, $method ) {
    
    global $buttonloesung_options;
    $estimatedshippingdaysmin = $buttonloesung_options['shippingdateestimatemin'];
    $estimatedshippingdaysmax = $buttonloesung_options['shippingdateestimatemax'];
    if (($estimatedshippingdaysmin | $estimatedshippingdaysmax) != 0){
        $datemin = new DateTime($currentdate);
        $datemax = new DateTime($currentdate);
        $modifydatemin = '+' . $estimatedshippingdaysmin . 'day';
        $modifydatemax = '+' . $estimatedshippingdaysmax . 'day';
        $datemin->modify($modifydatemin);
        $datemax->modify($modifydatemax);
        $shippingdatemin = $datemin->format('d.m.Y');
        $shippingdatemax = $datemax->format('d.m.Y');
    
        $label .= '<br /><small>';
        if (($estimatedshippingdaysmin == $estimatedshippingdaysmax) || ($estimatedshippingdaysmin == 0)){
            $label .= 'Voraussichtliche Lieferung am ' . $shippingdatemax;
        } elseif (($estimatedshippingdaysmin > $estimatedshippingdaysmax) || ($estimatedshippingdaysmax == 0)){
            $label .= 'Voraussichtliche Lieferung am ' . $shippingdatemin;
        } else {
            $label .= 'Voraussichtliche Lieferung zwischen ' . $shippingdatemin . ' und ' . $shippingdatemax;
        }           
        $label .= '</small>';

        /** insert switch case for different shipping estimates for different shipping methods */
        //$label .= '<br /><small>';
        //switch ( $method->method_id ) {
        //	case 'free_shipping':
        //		$label .= 'Voraussichtliche Lieferung zwischen ' . $shippingdatemin . ' und ' . $shippingdatemax;
        //		break;
        //}
        //$label .= '</small>';

    }
    return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'buttonloesung_sv_shipping_method_estimate_label', 10, 2 );