<?php

$text_field = Field::text(
	'author',
	array( 'title' => 'Book author' ),
	array( 'class' => 'custom-text-class' )
);

echo $text_field->metabox();