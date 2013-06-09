<?php
require_once( './config.inc.php' );

if( isset( $_GET['submit'] ) )
{
	
}
?>
<html>
	<head>
	</head>
	<body>
		<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="id" />
			<select name="primitives">
				<option value="node">node</option>
				<option value="way">way</option>
				<option value="relation">relation</option>
			</select>
			<input type="submit" name="submit" value="Valider" />
		</form>
	</body>
</html>
