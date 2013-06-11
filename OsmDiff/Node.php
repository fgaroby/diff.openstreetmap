<?php
class Node extends Tag
{
	public function __construct( $id, $role = null )
	{
		parent::__construct( '<img src="./images/data/node.png" />&nbsp;' . $id, $role );
	}
}