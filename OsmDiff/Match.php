<?php
class Match implements Iterator
{
	private $tags;
	
	private $position;

	public function __construct()
	{
		$this->tags = array();
		$this->position = 0;
	}


	public function add( Pair $pair )
	{
		
		$this->tags[$this->position++] = $pair;
		
		return $this;
	}
	
	
	public function get( $position = 0 )
	{
		return $this->tags[$position];
	}


	public function rewind()
	{
		$this->position = 0;
	}

	public function current()
	{
		return $this->tags[$this->position];
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		return ++$this->position;
	}

	public function valid()
	{
		return $this->position < sizeof( $this->tags );
	}

}