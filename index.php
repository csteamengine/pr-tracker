<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/18/17
 * Time: 9:44 AM
 */

include "includes/php/base.php";

if((isset($_SESSION['logged_in']) && !$_SESSION['logged_in'])){
    header("location /pages/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=pages/index.html">
    <title>SB Admin 2</title>
    <script language="javascript">
        window.location.href = "pages/index.php"
    </script>
</head>
<body>
Go to <a href="old_pages/index.php">/pages/index.html</a>
</body>
</html>
