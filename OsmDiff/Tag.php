<?php
class Tag
{
	public $key;
	
	public $value;
	
	public function __construct( $key = null, $value = null )
	{
		$this->key = $key;
		$this->value = $value;
	}
	
	
	public function isEmpty()
	{
		return $this->key === null && $this->value === null;
	}
}