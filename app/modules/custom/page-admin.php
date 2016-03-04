<?php

class Page_Admin
{
	public function __construct() {
		
		self::first_menu();
	}

	private static function first_menu() {

		$page_view = View::make('pages/menu-test');
		
		$sections[] = Section::make('section-slug-name', 'Section Title');
		$sections[] = Section::make('section-slug-name-2', 'Section Title 2');
		$field = new Field();
		//$text = $field->text('street-address');
		//var_dump($text);
		$settings['section-slug-name'] = array(
			$field->text('street-address'),
			//Field::text('phone'),
			//Field::media('theme-logo')
		);

		$settings['section-slug-name-2'] = array(
			//Field::text('street-address'),
			$field->text('phone'),
			//Field::media('theme-logo')
		);

		$custom = Page::make( 'custom-page', 'Theme options' )->set( array(
			'capability'    => 'manage_options',
			'icon'          => 'dashicons-admin-site',
			'position'      => 20,
			'tabs'          => true
		));
		$custom->addSections($sections);
		$custom->addSettings($settings);
		
		//var_dump($custom);

		$sub_first = Page::make('custom-sub-page-first', 'Submenu 1', 'custom-page')->set( array(
			'capability'    => 'manage_options',
			'tabs'          => false
		));

		$sub_second = Page::make('custom-sub-page-second', 'Submenu 2', 'custom-page')->set( array(
			'capability'    => 'manage_options',
			'tabs'          => false
		));
	}

}

new Page_Admin();
