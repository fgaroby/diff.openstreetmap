<?php
class MemberTag extends Tag
{
	public function __construct( $type, $id, $role = null )
	{
		parent::__construct( '<img src="./images/' . $type . '.png" />&nbsp;' . $id, $role );
	}
}