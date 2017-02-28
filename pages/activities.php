<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/26/17
 * Time: 9:32 AM
 */

include "../includes/php/base.php";

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
    header("location: login.php");
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

    <title>Your Events | Room For ImPRovement</title>

    <link rel="icon" href="/includes/icons/favicon.png" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <link href="/includes/bootcomplete.js-master/dist/bootcomplete.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

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

<div id="wrapper">
    <?php
    include "navigation.php";

    $eventSQL = "SELECT * FROM userEvents userev 
     INNER JOIN events eve
     ON userev.eventID = eve.eventID
     INNER JOIN category cat 
     ON eve.categoryID = cat.categoryID
     WHERE userev.userID = 
     ".$_SESSION['user_id'];

    $eventQuery = mysqli_query($conn, $eventSQL);


    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header row">
                    <h1>
                        <div class="col-lg-6 col-md-6 col-xs-8">
                            Your Activities
                        </div>
                        <div class="col-lg-5 col-lg-offset-1 col-md-offset-1 col-md-5 col-xs-6" >
                            <div class="input-group custom-search-form">
                                <span class="input-group-btn">
                                    <a href="addInfo.php?action=addEntry">
                                        <button class="btn btn-outline btn-primary" title="Create a new Entry"><i class="fa fa-plus"></i></button>
                                    </a>
                                </span>
                                <span class="input-group-btn">

                                </span>
                                <input type="text" class="form-control" id="searchForm" placeholder="Search For Activities...">
                                <span class="input-group-btn">

                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </h1>
                </div>
            </div>
            <?php
            if(mysqli_num_rows($eventQuery) > 0){
                ?>
                <div class="col-lg-4 col-lg-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            You haven't added any entries yet
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <button type="button" class="btn btn-outline btn-primary btn-lg btn-block">Create an Entry</button>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <?php
            }else{
                ?>
                <div class="col-lg-4 col-lg-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            You haven't added any entries yet
                        </div>


                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search For Activities...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <hr>
                            <button type="button" class="btn btn-outline btn-primary btn-lg btn-block">Create an Entry</button>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                <?php
            }
            ?>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../data/morris-data.js"></script>

<script src="//netsh.pp.ua/upwork-demo/1/js/typeahead.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
<script src="/includes/bootcomplete.js-master/dist/jquery.bootcomplete.js"></script>
<script type="text/javascript">
    $('#searchForm').keydown(function(){
        $('#searchForm').bootcomplete({
            url:'/pages/ajax.php?action=getAllEvents',
            minLength : 1
        });
    });
</script>
</body>

</html>
