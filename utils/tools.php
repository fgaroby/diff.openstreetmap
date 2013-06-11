<?php
function in_array_r( $needle, $haystack, $strict = false )
{
	foreach( $haystack as $item )
	{
		if( ( $strict ? $item === $needle : $item == $needle ) || ( is_array( $item ) && in_array_r( $needle, $item, $strict ) ) )
			return $item;
	}

	return null;
}