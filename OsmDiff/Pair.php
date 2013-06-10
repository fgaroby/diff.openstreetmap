<?php
class Pair
{
	public $from;
	
	public $to;
	
	public function __construct( $from, $to )
	{
		$this->from = $from;
		$this->to = $to;
	}
	
	
	public function isAdded()
	{
		return $this->from === null && $this->to !== null;
	}
	
	
	public function isModified()
	{
		return $this->from != $this->to && $this-> from !== null & $this->to !== null;
	}
	
	
	public function isDeleted()
	{
		return $this->from !== null && $this->to === null;
	}
}