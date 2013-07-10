<?php
require_once( dirname( __FILE__ ) . '/../Services/OpenStreetMap.php' );
require_once( dirname( __FILE__ ) . '/Match.php' );
require_once( dirname( __FILE__ ) . '/Tag.php' );
require_once( dirname( __FILE__ ) . '/Member.php' );
require_once( dirname( __FILE__ ) . '/Node.php' );
require_once( dirname( __FILE__ ) . '/Pair.php' );
require_once( dirname( __FILE__ ) . '/../utils/tools.php' );


class OsmDiff
{
	private $id;

	private $type;

	private $object;

	private $from;

	private $to;

	private $history;

	public function __construct( $id, $type, $from = 0, $to = -1 )
	{
		$osm = new Services_OpenStreetMap();

		$this->id = $id;
		$this->type = $type;

		switch( $type )
		{
			case 'node' :
				$this->object = $osm->getNode( $id );
				break;

			case 'way' :
				$this->object = $osm->getWay( $id );
				break;

			case 'relation' :
				$this->object = $osm->getRelation( $id );
				break;
					
			default ;
			throw new InvalidArgumentException( $type . " is not valid ! Only 'node', way' and 'relation' are accepted." );
			break;
		}
		$this->history = $this->object->history();

		$this->initVersions( $from, $to );
	}


	public function __destruct()
	{
		unset( $this->object );
		unset( $this->from );
		unset( $this->to );
		unset( $this->history );
	}


	private function initVersions( $from, $to )
	{
		$history = $this->object->history();
		if( $to > 0 && $to < $history->count() )
			$to = $history->offsetGet( $to - 1 );
		else
			$to = $history->offsetGet( $history->count() - 1 );
			
		if( $from > 0 && $from < $history->count() && $from < $to->getVersion() )
			$from = $history->offsetGet( $from - 1 );
		else
			$from = $history->offsetGet( $to->getVersion() - 2 );

		$this->from = $from;
		$this->to = $to;
	}


	public function getFrom()
	{
		return $this->from;
	}


	public function getTo()
	{
		return $this->to;
	}
	
	
	public function getType()
	{
		return $this->type;
	}
	
	
	public function getId()
	{
		return $this->id;
	}

	
	public function getHistory()
	{
		return $this->history;
	}
	

	public function diff()
	{
		$match = new Match();
		
		// Cas d'un node : on gère ses coordonnées comme des tags
		if( $this->type == 'node' )
		{
			$match->add( new Pair( new Tag( 'Latitude', $this->from->getLat() ), new Tag( 'Latitude', $this->to->getLat() ) ) );
			$match->add( new Pair( new Tag( 'Longitude', $this->from->getLon() ), new Tag( 'Longitude', $this->to->getLon() ) ) );
		}
		
		foreach( $this->from->getTags() as $key => $value )
			$match->add( new Pair( new Tag( $key, $value ), ( $this->to->getTag( $key ) !== null  ? new Tag( $key, $this->to->getTag( $key ) ) : null ) ) );

		foreach( $this->to->getTags() as $key => $value )
		{
			if( $this->from->getTag( $key ) === null )
				$match->add( new Pair( null, new Tag( $key, $this->to->getTag( $key ) ) ) );
		}
		
		// Cas d'une way : on gère ses noeuds comme des tags
		if( $this->type == 'way' )
		{
			$fromNodes = $this->from->getNodes();
			$toNodes = $this->to->getNodes();
			
			foreach( $fromNodes as $fromNode )
				$match->add( new Pair( new Node( $fromNode ), ( in_array( $fromNode, $toNodes ) !== false  ? new Node($fromNode ) : null ) ) );
			foreach( $toNodes as $toNode )
				if( !in_array( $toNode, $fromNodes ) )
					$match->add( new Pair( null, new Node($fromNode ) ) );
		}
		
		
		// Cas d'une relation : on gère ses membres comme des tags
		if( $this->type == 'relation' )
		{
			$fromMembers = $this->from->getMembers();
			$toMembers = $this->to->getMembers();

			foreach( $fromMembers as $key => $fromMember )
			{
				if( $inArray = in_array_r( $fromMember, $toMembers ) )
					$toMember = new Member( $inArray['type'], $inArray['ref'], $inArray['role'] );
				else
					$toMember = null;
				$match->add( new Pair( new Member( $fromMember['type'], $fromMember['ref'], $fromMember['role'] ), $toMember ) );
			}
			foreach( $toMembers as $key => $toMember )
			{
				if( !in_array_r( $toMember, $fromMembers ) )
					$match->add( new Pair( null, new Member( $toMembers[$key]['type'], $toMembers[$key]['ref'], $toMembers[$key]['role'] ) ) );
			}
		}
		return $match;
	}
}