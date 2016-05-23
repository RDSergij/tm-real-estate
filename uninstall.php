<?php
/**
 * Uninstall data
 *
 * @package  TM Real Estate
 * @author   Guriev Eugen & Sergyj Osadchij
 * @license  GPL-2.0+
 */

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

require_once 'tm-real-estate.php';

TM_Real_Estate::uninstall();