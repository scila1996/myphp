<!DOCTYPE HTML>
<html>
    <head>
        <title> Error </title>
    </head>
    <body>
        <div>
            <h4> Exception : <span style="color: #048CAD"> <?php echo get_class($e) ?> </span></h4>
            <hr />
            <table>
                <tbody>
                    <tr><td><b> Message </b></td><td> <?php echo $e->getMessage() ?> </td></tr>
                    <tr><td><b> Code </b></td><td> <?php echo $e->getCode() ?> </td></tr>
                    <tr><td><b> File </b></td><td> <?php echo $e->getFile() ?> </td></tr>
                    <tr><td><b> Line Number </b></td><td> <?php echo $e->getLine() ?> </td></tr>
                </tbody>
            </table>
            <hr />
            <pre><?php echo $e->getTraceAsString() ?></pre>
            <hr />
            <p><strong> Error Time</strong>: <?php echo date("F j, Y, g:i a") ?> </p>
            <em> Please report this error to "Administrator". </em>
        </div>
    </body>
</html>
