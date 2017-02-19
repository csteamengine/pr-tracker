<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/19/17
 * Time: 8:51 AM
 */
?>
<?php


include "../includes/php/base.php";
include "../includes/php/general.php";
$action = get_value('action');
if(isset($action)){
    switch ($action){
        case "login":
            $loginSql = "SELECT * FROM users WHERE email='".get_value('email')."'";
            $loginQuery = mysqli_query($conn, $loginSql);

            if(mysqli_num_rows($loginQuery) > 0){
                $result = mysqli_fetch_assoc($loginQuery);
                if(password_verify(get_value('password'),$result['password'])){
                    $_SESSION['logged_in'] = true;
                    header("location: index.php");
                }else{
                    $error = "failed_login";
                }
            }else{
                $error = "failed_login";
            }
            break;
        case "create_account":

            break;
        case "logout":
            $_SESSION['logged_in'] = false;

            break;
        default:

            break;

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/pages/createAccount.php?action=createAccount" method="post">
                        <?php
                        if(isset($error) && $error == "failed_login"){
                            ?>
                            <h4 class="text-warning">Email or Password was incorrect.</h4>
                            <?php
                        }
                        ?>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password Confirm" name="password_verify" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                        <h5 class="center-block">Already have an account? <a href="/pages/login.php" >Login.</a></h5 class="center-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

