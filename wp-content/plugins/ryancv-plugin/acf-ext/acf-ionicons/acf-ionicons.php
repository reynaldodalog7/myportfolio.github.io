<?php

/*
 * Advanced Custom Fields: Ionicons
*/

function include_field_types_ionicons( $version ) {
	include_once( 'acf-ionicons-v5.php' );
}
add_action( 'acf/include_field_types', 'include_field_types_ionicons' );

?>