function valider()
{
	primitive = $( '#primitive option:selected' ).val();
	id = $( '#id' ).val();
	
	goTo( primitive, id, null, null );
}


function updateVersion()
{
	primitive = $( '#primitive option:selected' ).val();
	id = $( '#id' ).val();
	from = $( '#fromSelect option:selected' ).val();
	to = $( '#toSelect option:selected' ).val();
	
	goTo( from, to );
}


function goTo( primitive, id, from, to )
{
	path = location.pathname.substring( 0, location.pathname.indexOf( 'index.php' ) );

	url = path + 'diff/' + primitive + '/' + id;
	
	if( from )
	{
		url += '/' + from;
		if( to)
			url += '/' + to;
	}

	$( location ).attr( 'href', url );
}