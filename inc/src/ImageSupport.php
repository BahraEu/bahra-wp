<?php

function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
	$mime_types['psd'] = 'image/vnd.adobe.photoshop'; //Adding photoshop files
	$mime_types['ai'] = 'image/vnd.adobe.illustrator';
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);