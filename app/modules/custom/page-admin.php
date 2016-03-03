<?php

class Page_Admin
{
	public function __construct() {
		
		self::first_menu();
	}

	private static function first_menu() {

		$page_view = View::make('/pages/menu-test');
		var_dump($page_view);
	
		$custom = Page::make('custom-page', 'Theme options', null, $page_view)->set( array(
			'capability'    => 'manage_options',
			'icon'          => 'dashicons-admin-site',
			'position'      => 20,
			'tabs'          => true
		));

		$sub_first = Page::make('custom-sub-page-first', 'Submenu 1', 'custom-page')->set( array(
			'capability'    => 'manage_options',
			'tabs'          => true
		));

		$sub_second = Page::make('custom-sub-page-second', 'Submenu 2', 'custom-page')->set( array(
			'capability'    => 'manage_options',
			'tabs'          => true
		));
	}

}

new Page_Admin();
