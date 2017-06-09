<!DOCTYPE HTML>
<html>
	<head>
		<title> Test PHP </title>
		<link rel="stylesheet" href="/extensions/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/extensions/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" />
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
							<input name="data" class="form-control" />
						</div>
						<button type="submit" name="submit" value="1" class="btn btn-primary"> CLICK </button>
					</form>
					{{ content }}
				</div>
			</div>
		</div>
	</body>
</html>