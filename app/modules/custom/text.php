<?php

$text_field = Field::text(
	'author',
	array( 'title' => 'Book author' ),
	array( 'class' => 'custom-text-class' )
);

echo $text_field->metabox();
echo '<br>';

$text_area = Field::textarea('excerpt');
echo $text_area->metabox();
echo '<br>';

$select = Field::select(
	'my-field', 
	[
    'europe'    => [
        'bel'   => 'Belgium',
        'fra'   => 'France'
    	],
	    'america'   => [
	        'usa'   => 'United States'
	    ]
	]
);

echo $select->metabox();
echo '<br>';

$radio = Field::radio('choices', ['red', 'green', 'blue']);

echo $radio->metabox();
echo '<br>';

$checkbox = Field::checkbox('colors', ['red', 'green', 'blue']);

echo $checkbox->metabox();
echo '<br>';

$password = Field::password('password_field');

echo $password->metabox();
echo '<br>';

$number = Field::number( 'password_field' );

echo $number->metabox();
echo '<br>';
