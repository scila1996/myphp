<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <title> Thống kê </title>
    </head>
    <body>
        <div class="container" style="margin-top: 25px">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <form class="panel panel-info" method="post">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-log-in"></span>
                            <strong> &nbsp; Đăng nhập vào ứng dụng </strong>
                        </div>
                        <div class="panel-body">
                            <?php if ($message): ?>
                                <div class="alert alert-<?php echo $message["type"] ?>">
                                    <?php echo $message["str"] ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" class="form-control" placeholder="Tài khoản" name="user" autofocus />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input type="password" class="form-control" placeholder="Mật khẩu" name="pass" />
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info" name="submit" value="1"><strong><span class="glyphicon glyphicon-check"></span> Đăng nhập </strong></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>