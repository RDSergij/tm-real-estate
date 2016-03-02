<?php

interface I_Field
{
	/**
	 * Handle the HTML code for metabox output.
	 *
	 * @return string
	 */
	public function metabox();

	/**
	 * Handle the HTML code for page/settings output.
	 *
	 * @return string
	 */
	public function page();

	/**
	 * Handle the HTML code for user output.
	 *
	 * @return string
	 */
	public function user();
}