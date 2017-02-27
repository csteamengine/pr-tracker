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
                        $_SESSION['username'] = $result['username'];
                        $_SESSION['FULLNAME'] = $result['firstName']." ".$result['lastName'];
                        if($_SESSION['FULLNAME'] == " "){
                            $_SESSION['FULLNAME'] = $result['username'];
                        }
                        $_SESSION['user_id'] = $result['userID'];
                        header("location: index.php");
                    }else{
                        $error = "failed_login";
                    }
                }else{
                    $loginSql = "SELECT * FROM users WHERE username='".get_value('email')."'";
                    $loginQuery = mysqli_query($conn, $loginSql);
                    if(mysqli_num_rows($loginQuery) > 0){
                        $result = mysqli_fetch_assoc($loginQuery);
                        if(password_verify(get_value('password'),$result['password'])){
                            $_SESSION['logged_in'] = true;
                            $_SESSION['username'] = $result['username'];
                            $_SESSION['FULLNAME'] = $result['firstName']." ".$result['lastName'];
                            if($_SESSION['FULLNAME'] == " "){
                                $_SESSION['FULLNAME'] = $result['username'];
                            }
                            $_SESSION['user_id'] = $result['userID'];
                            header("location: index.php");
                        }else{
                            $error = "failed_login";
                        }
                    }
                }
                break;
            case "createAccount":
                $loginSql = "SELECT * FROM users WHERE username='".get_value('username')."'";
                $loginQuery = mysqli_query($conn, $loginSql);

                if(mysqli_num_rows($loginQuery) > 0){
                    $error = "failed_login";
                    header("location: createAccount.php?error=username_taken");
                }else if(mysqli_num_rows($loginQuery) == 0){
                    $sql = "INSERT INTO users (username, email, firstName, lastName, password) VALUE ('".get_value('username')."', '".get_value('email')."','".get_value('fName')."','".get_value('lName')."','".password_hash(get_value('password'), PASSWORD_BCRYPT)."')";
                    $query = mysqli_query($conn, $sql);
                    $_SESSION['logged_in'] = true;
                    $_SESSION['FULLNAME'] = get_value('username');
                    $_SESSION['user_id'] = mysqli_insert_id($conn);
                    header("location: index.php");
                }
                break;
            case "logout":
                $_SESSION['logged_in'] = false;
                $_SESSION['FBID'] = null;
                $_SESSION['FULLNAME'] = null;
                $_SESSION['EMAIL'] = null;
                $_SESSION['user_id'] = null;
                $_SESSION['username'] = null;
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
    <meta name="google-signin-client_id" content="912882948798-mckg0lgj9laoq367unqi1s85do6t8bs1.apps.googleusercontent.com">
    <title>Login | Room For ImPRovement</title>

    <link rel="icon" href="/includes/icons/favicon.png" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Social Buttons CSS -->
    <link href="../vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">

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
    <script src="https://apis.google.com/js/platform.js" async defer></script>


</head>

<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1846305968942250',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


</script>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <a href="/includes/facebook/fbconfig.php" class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> Sign in with Facebook
                        </a>
<!--                        <a class="btn btn-block btn-social btn-google-plus">-->
<!--                            <i class="fa fa-google-plus g-signin2"></i> Sign in with Google-->
<!--                        </a>-->
                        <hr>
                        <form role="form" action="/pages/login.php?action=login" method="post">
                            <?php
                            if(isset($error) && $error == "failed_login"){
                                ?>
                                <h4 class="text-warning">Email or Password was incorrect.</h4>
                            <?php
                            }
                            ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail or Username" name="email" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                            </fieldset>
                            <h5 class="center-block">New to PR Tracker? <a href="/pages/createAccount.php" >Create Account.</a></h5 class="center-block">
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
