<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" media="all" href="./styles/main.css" />
		<link rel="stylesheet" type="text/css" media="all" href="./styles/diff.css" />
		<title>Diff OpenStreetMap</title>
	</head>
	<body>
		<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="id" value="<?php echo $_GET['id']; ?>" />
			<select name="primitives">
				<option value="node" <?php echo ( $_GET['primitives'] == 'node' ? 'selected="selected"' : '' ); ?>>node</option>
				<option value="way" <?php echo ( $_GET['primitives'] == 'way' ? 'selected="selected"' : '' ); ?>>way</option>
				<option value="relation" <?php echo ( $_GET['primitives'] == 'relation' ? 'selected="selected"' : '' ); ?>>relation</option>
			</select>
			<input type="submit" name="submit" value="Valider" />
		</form>
		
<?php
		error_reporting( E_ALL );
		require_once( './config.inc.php' );
		
		if( isset( $_GET['id'] ) )
		{
			require_once( './OsmDiff/OsmDiff.php' );
			$osm = new OsmDiff( $_GET['id'], $_GET['primitives'], $_GET['from'], $_GET['to'] );
			$match = $osm->diff();
			$from = $osm->getFrom();
			$to = $osm->getTo();
				
?>
		
			<table class="diff">
				<caption><?php echo ucfirst( $osm->getType() ) . ' : <a href="' . $browse . $osm->getType() . '/' . $osm->getId() . '">' . $osm->getId() . '</a>'; ?></caption>
				<tr>
					<th colspan="2">Version <?php echo $from->getVersion(); ?></th>
					<th colspan="2">Version <?php echo $to->getVersion(); ?></th>
				</tr>
				<tr>
					<th>Clés</th>
					<th>Valeurs</th>
					<th>Clés</th>
					<th>Valeurs</th>
				</tr>
<?php

				foreach( $match as $pair )
				{
					echo '	<tr ' . ( $pair->isAdded() ? 'class="added"' : ( $pair->isModified() ? 'class="modified"' : ( $pair->isDeleted() ? 'class="deleted"' : 'class="unchanged"') ) ) . '>
								<td>' . $pair->from->key . '</td>
								<td>' . $pair->from->value . '</td>
								<td>' . $pair->to->key . '</td>
								<td>' . $pair->to->value . '</td>
							</tr>';
				}
?>
			</table>
<?php

			//if( )
		}
?>
	</body>
</html>
