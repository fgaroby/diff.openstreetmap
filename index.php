<?php
		error_reporting( E_ALL );
		require_once( './config.inc.php' );
		
		if( isset( $_GET['id'] ) )
		{
			$from = isset( $_GET['from'] ) ? $_GET['from'] : null;
			$to = isset( $_GET['to'] ) ? $_GET['to'] : null;
			
			// Redirection
			if( isset( $_GET['submit'] ) )
			{
				echo str_replace( 'index.php', 'diff/' . $_GET['primitive'] . '/' . $_GET['id'] . ( $from !== null ? '/' . $from . ( $to !== null ? '/' . $to : '' ) : '' ), $_SERVER['PHP_SELF'] );
				header( 'location : ' . str_replace( 'index.php', 'diff/' . $_GET['primitive'] . '/' . $_GET['id'] . '/' . $from . '/' . $to, $_SERVER['PHP_SELF'] ) );
			}
			require_once( './OsmDiff/OsmDiff.php' );
			$osm = new OsmDiff( $_GET['id'], $_GET['primitive'], $from, $to );
			$match = $osm->diff();
			$from = $osm->getFrom();
			$to = $osm->getTo();
				
?>
<html>
	<head>
		<base href="<?php $_SERVER['SERVER_NAME']; ?>/diff.openstreetmap/" >
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" media="all" href="./styles/main.css" />
		<link rel="stylesheet" type="text/css" media="all" href="./styles/diff.css" />
		<script type="text/javascript" src="./js/jquery-2.0.2.js"></script>
		<script type="text/javascript" src="./js/diff.js"></script>
		<title>Diff OpenStreetMap</title>
	</head>
	<body>
		<input type="text" name="id" id="id" value="<?php echo ( isset( $_GET['id'] ) ? $_GET['id'] : '' ) ; ?>" />
		<select name="primitive" id="primitive">
			<option value="node" <?php echo ( isset( $_GET['primitive'] ) && $_GET['primitive'] == 'node' ? 'selected="selected"' : '' ); ?>>node</option>
			<option value="way" <?php echo ( isset( $_GET['primitive'] ) && $_GET['primitive'] == 'way' ? 'selected="selected"' : '' ); ?>>way</option>
			<option value="relation" <?php echo ( isset( $_GET['primitive'] ) && $_GET['primitive'] == 'relation' ? 'selected="selected"' : '' ); ?>>relation</option>
		</select>
		<input type="button" name="submit" value="Valider" onclick="valider();" />
			<table class="diff">
				<caption><?php echo ucfirst( $osm->getType() ) . ' : <a href="' . $browse . $osm->getType() . '/' . $osm->getId() . '">' . $osm->getId() . '</a>'; ?></caption>
				<tr>
					<th colspan="2">Version
						<select name="from" id="fromSelect" onchange="updateVersion();">
						<?php
							for( $i = 1; $i <= $osm->getHistory()->count(); $i++)
								echo '<option value="' . $i . '" ' . ( $i > $to->getVersion() - 1 ? 'disabled="disabled"' : ( $i == $from->getVersion() ? 'selected="selected"' : '' ) ) . '>' . $i . '</option>';
						?>
						</select>
					</th>
					<th colspan="2">Version
					<select name="to" id="toSelect" onchange="updateVersion();">
						<?php
							for( $i = 1; $i <= $osm->getHistory()->count(); $i++)
								echo '<option value="' . $i . '" ' . ( $i <= $from->getVersion() ? 'disabled="disabled"' : ( $i == $to->getVersion() ? 'selected="selected"' : '' ) ) . '>' . $i . '</option>';
						?>
						</select>
					</th>
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
		}
?>
	</body>
</html>
