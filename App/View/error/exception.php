<!DOCTYPE HTML>
<html>
	<head>
		<title> Error </title>
		<style>
			.frame
			{
				margin: 5px 5px 50px 5px;
				padding: 25px;
				box-shadow: 0px 0px 5px #C0C0C0;
			}
			.exception-info tr td:first-child
			{
				font-weight: bold;
				padding-right: 15px;
			}
			.exception-info tr td:first-child:after
			{
				content: ':';
			}
			.frame pre
			{
				word-wrap: break-word;
				white-space: pre-wrap;
			}
		</style>
	</head>
	<body>
		<div class="frame">
			<h4> Exception : <span style="color: #048CAD"> <?php echo get_class($e) ?> </span></h4>
			<hr />
			<table class="exception-info">
				<tbody>
					<tr>
						<td> Message </td>
						<td> <?php echo $e->getMessage() ?> </td>
					</tr>
					<tr>
						<td> Code </td>
						<td> <?php echo $e->getCode() ?> </td>
					</tr>
					<tr>
						<td> File </td>
						<td> <?php echo $e->getFile() ?> </td>
					</tr>
					<tr>
						<td> Line Number </td>
						<td> <?php echo $e->getLine() ?> </td>
					</tr>
				</tbody>
			</table>
			<hr />
			<pre><?php echo $e->getTraceAsString() ?></pre>
			<hr />
			<p class="time"><strong> Error Time</strong>: <?php echo date("F j, Y, g:i a"); ?> </p>
			<em> Please report this error to "Administrator" </em>
		</div>
		<?php echo $error ?>
	</body>
</html>
