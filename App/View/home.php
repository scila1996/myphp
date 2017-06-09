<!DOCTYPE HTML>
<html>
	<head>
		<title> Test PHP </title>
		<link rel="stylesheet" href="/extensions/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/extensions/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="/extensions/jquery-1.12.4.min.js"></script>
		<script src="/extensions/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default navbar-static-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">WebSiteName</a>
					</div>
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Page 1</a></li>
						<li><a href="#">Page 2</a></li>
						<li><a href="#">Page 3</a></li>
					</ul>
				</div>
			</nav>
			<div class="row">
				<div class="col-xs-12">
					<form method="post" class="form-group">
						<div class="form-group form-inline">
							<input name="data" class="form-control" placeholder="Input Data" />
							<button type="submit" name="submit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span></button>
						</div>
					</form>
					<pre>{{ content }}</pre>
				</div>
			</div>
		</div>
	</body>
</html>