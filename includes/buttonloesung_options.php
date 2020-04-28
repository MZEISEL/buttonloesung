<?php

// Create menu Link
function buttonloesung_options_menu_link(){
	add_options_page(
		'Buttonloesung Options', //Titel
		'Buttonloesung', //Titel des Menuelinks
		'manage_options', //Kompatibilität manage_options ist vorgeschrieben
		'buttonloesung-options', //Url der options page
		'buttonloesung_options_content' //Funktionsname der Hauptfunktion
	);
}

// Create Options Page Content
function buttonloesung_options_content(){

	// Init Options Global
	global $buttonloesung_options;
	if($buttonloesung_options["setDefaultText"]){
		$buttonloesung_options['agb_text'] = 'Mit deiner Bestellung erklärst du dich mit unseren <a href="#"> Allgemeinen Geschäftsbedingungen</a>, <a href="#">Wiederrufsbestimmungen</a> und <a href="#"> Datenschutzbestimmungen</a> einverstanden.';
	}

//Erzeugen eines Output-Buffer
	ob_start(); ?>
		<div class="wrap">
			<h1>Buttonloesung für deutsche Online-Shops</h2>
			<p>Dieses Plugin unterstützt sie bei der Einrichtung eines rechtskräftige Online Shops, indem einige Elemente auf der Checkout-Seite den deutschen Rechtsbestimmungen angepasst werden.</p>
			<p>Weitere Informationen dazu finden sie unter folgendem <a href="#">Link</a>.</p>
			<form method="post" action="options.php">
				<?php settings_fields('buttonloesung_settings_group'); ?>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[button_text]">Text des Kaufbuttons:</label></th>
							<td>
								<select name="buttonloesung_settings[button_text]" id="buttonloesung_settings[button_text]">
								  <option value="Zahlungspflichtig bestellen">Zahlungspflichtig bestellen</option>
								  <option value="Kostenpflichtig bestellen">Kostenpflichtig bestellen</option>
								  <option value="Kaufen" selected>Kaufen</option>
								  <option value="Zahlungspflichtigen Vertrag abschließen">Zahlungspflichtigen Vertrag abschließen</option>
								</select>
								<p class="description">Auswahl einer der erlaubten Bezeichnungen für den Kaufbutton</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[shippingdateestimatemin]">Vorraussichtliche Lieferung in:</label></th>
							<td>
								<input type="text" name="buttonloesung_settings[shippingdateestimatemin]" id="buttonloesung_settings[shippingdateestimatemin]" rows="1" cols="2" value="<?php echo esc_html($buttonloesung_options["shippingdateestimatemin"])?>"></input>
							 bis
								<input type="text" name="buttonloesung_settings[shippingdateestimatemax]" id="buttonloesung_settings[shippingdateestimatemax]" rows="1" cols="2" value="<?php echo esc_html($buttonloesung_options["shippingdateestimatemax"])?>"></input>
							 Tagen.
						 </td>
						</tr>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[agb_text]">HTML-Text der AGBs:</label></th>
							<td>
								<textarea name="buttonloesung_settings[agb_text]" id="buttonloesung_settings[agb_text]" rows="5" cols="100"><?php echo esc_html($buttonloesung_options["agb_text"])?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[setDefaultText]">Standardtext nutzen:</label></th>
							<td>
								<input name="buttonloesung_settings[setDefaultText]" type="checkbox" id="buttonloesung_settings[setDefaultText]" value="1" <?php checked('1', $buttonloesung_options['setDefaultText']); ?>>
								<p class="description">Standardtext für die AGBs nutzen. <br>
								Dieser wird beim Speichern automatisch gesetzt.
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[language]">Nur für deutsche locale aktivieren:</label></th>
							<td>
								<input name="buttonloesung_settings[language]" type="checkbox" id="buttonloesung_settings[language]" value="1" <?php checked('1', $buttonloesung_options['language']); ?>>
								<p class="description">Wenn gewählt, wird das Plugin nur für eine beim Seitenbesucher ausgewählte Spracheinstellung von deutsch aktiviert. <br>
									Wichtig: Das Plugin ist nur funktional mit Multilingualitäts-Plugins die den locale-Parameter setzen (z.b. Polylang).</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="buttonloesung_settings[productpicturecheckout]">Produktfotos auf Checkout Seite hinzufügen:</label></th>
							<td>
								<input name="buttonloesung_settings[productpicturecheckout]" type="checkbox" id="buttonloesung_settings[productpicturecheckout]" value="1" <?php checked('1', $buttonloesung_options['productpicturecheckout']); ?>>
								<p class="description">Wenn gewählt, werden die Produktfotos auf der Kasse Seite angezeigt.</p>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Optionen Speichern"></p>
			</form>
		</div>
	<?php
	echo ob_get_clean();
}
add_action('admin_menu', 'buttonloesung_options_menu_link'); //Fügt die Options Page der Admin section hinzu

// Register Settings
function buttonloesung_register_settings(){
	register_setting('buttonloesung_settings_group', 'buttonloesung_settings');
}
add_action('admin_init', 'buttonloesung_register_settings'); //Fügt den Settings in der Datenbank das Feld für unsere Optionsn hinzu
