<?php
class Tag
{
	public $key;
	
	public $value;
	
	public function __construct( $key, $value )
	{
		$this->key = $key;
		$this->value = $value;
	}
}