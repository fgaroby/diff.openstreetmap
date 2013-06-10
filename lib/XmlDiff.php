<?php
class XmlDiff
{
	private $xml1;

	private $xml2;


	public function __construct( $xmlFrom, $xmlTo )
	{
		if( !$xmlFrom instanceof DOMDocument )
			$xmlFrom = DOMDocument::loadXML( $xmlFrom );
		$this->xml1 = $xmlFrom;

		if( !$xmlTo instanceof DOMDocument )
			$xmlTo = DOMDocument::loadXML( $xmlto );
		$this->xml2 = $xmlTo;
	}


	public function diff()
	{
		foreach( $this->xml1->documentElement->childNodes as $node )
		{
			if( $node instanceof DOMElement )
			{
				$xml = $node->ownerDocument->saveXML( $node );
				var_dump( $xml );
			}
		}
	}
}