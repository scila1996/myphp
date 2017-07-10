<!DOCTYPE HTML>
<html>
	<head>
		<title> <?php echo $title ?> </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default navbar-static-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="/"> Thống kê tin đăng </a>
					</div>
					<ul class="nav navbar-nav">
						<li class="<?php echo $menu->customer ?>"><a href="<?php echo $url->customer ?>"> Khách Đăng Tin </a></li>
						<li class="<?php echo $menu->cms ?>"><a href="<?php echo $url->cms ?>"> Quản trị CMS </a></li>
						<li class="<?php echo $menu->update ?>"><a href="<?php echo $url->update ?>"> Cập nhật tin đăng </a></li>

					</ul>
				</div>
			</nav>
			<div class="row">
				<div class="col-xs-12">
					<?php echo $content ?>
				</div>
			</div>
		</div>
	</body>
	<script>
		$(document).ready(function () {
			$('body').on('click', 'a', function () {
				$(this).blur();
			});
			$('.datepicker').datepicker({
				todayHighlight: true,
				format: "yyyy-mm-dd",
				autoclose: true
			});
		});
	</script>
</html>