<?php
/*
	Exposing google maps Advanced Custom Fields 
*/
function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyChF-V0LobUxgDz5ujBRic35HcsyTcDbAM&libraries=places');
}
add_action('acf/init', 'my_acf_init');