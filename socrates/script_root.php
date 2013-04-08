<?php
$n = substr_count( $_SERVER["REQUEST_URI"], "/", strlen( $_SERVER['SCRIPT_NAME'] ) );
$root_path = "";
for ( $i = 0; $i < $n; $i++ ) {
	$root_path = $root_path . "../";
}