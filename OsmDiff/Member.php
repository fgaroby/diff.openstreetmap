<?php
class Member extends Tag
{
	public function __construct( $type, $id, $role = null )
	{
		parent::__construct( '<img src="./images/data/' . $type . '.png" />&nbsp;' . $id, $role );
	}
}