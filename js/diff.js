function updateVersion()
{
	from = $( '#fromSelect option:selected' ).val();
	to = $( '#toSelect option:selected' ).val();
	
	$( location ).attr( 'href', getURL( from, to ) );
}


function getURL( from, to )
{
	pathArray = window.location.href.split( '/' );
	var url = '';
	
	var i = 0;
	while( pathArray[i] != 'diff' )
	{
		url += pathArray[i] + '/';
		i ++;
	}
	
	primitive = $( '#primitives option:selected' ).val();
	id = $( '#id' ).val();
	url += 'diff/' + primitive + '/' + id + '/' + from + '/' + to;

	return url;
}