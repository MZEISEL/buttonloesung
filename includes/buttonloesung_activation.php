<?php
function buttonloesung_install(){
  global $buttonloesung_options;
  $buttonloesung_options["button_text"] = "Kaufen";
  $buttonloesung_options["agb_text"] = 'Mit deiner Bestellung erklärst du dich mit unseren <a href="#"> Allgemeinen Geschäftsbedingungen</a>, <a href="#">Wiederrufsbestimmungen</a> und <a href="#"> Datenschutzbestimmungen</a> einverstanden.';
}
register_activation_hook(__FILE__, "buttonloesung_install");
