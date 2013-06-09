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
			<input type="text" name="id" value="<?php echo $_GET['id']; ?>" />
			<select name="primitives">
				<option value="node" <?php ( $_GET['primitives'] == 'node' ? 'selected="selected"' : '' ); ?>>node</option>
				<option value="way" <?php ( $_GET['primitives'] == 'node' ? 'selected="selected"' : '' ); ?>>way</option>
				<option value="relation" <?php ( $_GET['primitives'] == 'node' ? 'selected="selected"' : '' ); ?>>relation</option>
			</select>
			<input type="submit" name="submit" value="Valider" />
		</form>
	</body>
</html>
