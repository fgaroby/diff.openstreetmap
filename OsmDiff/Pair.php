<?php
class Pair
{
	public $from;
	
	public $to;
	
	public function __construct( $from = null, $to = null )
	{
		if( $from === null )
			$from = new Tag();
		if( $to === null )
			$to = new Tag();
		
		$this->from = $from;
		$this->to = $to;
	}
	
	
	public function isAdded()
	{
		return $this->isEmpty( $this->from ) && !$this->isEmpty( $this->to );
	}
	
	
	public function isModified()
	{
		return !$this->isEmpty( $this->from ) && $this->isEmpty( $this->to ) && $this->from != $this->to;
	}
	
	
	public function isDeleted()
	{
		return $this->isEmpty( $this->from ) && $this->isEmpty( $this->to );
	}
	
	
	public function isEmpty( $tag )
	{
		return $tag === null || $tag->isEmpty();
	}
}