<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/18/17
 * Time: 9:44 AM
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

    <title>Home | Room For ImPRovement</title>

    <link rel="icon" href="/includes/icons/favicon.png" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="/includes/bootcomplete.js-master/dist/bootcomplete.css" rel="stylesheet">

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
    <script src="/includes/bootcomplete.js-master/dist/jquery.bootcomplete.js"></script>


</head>

<body>

<div id="wrapper">
    <?php
        include "navigation.php";
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="pull-left">Recent Entries</h5>
                        <a href="addInfo.php?action=addEntry"><button class="btn btn-outline btn-primary  pull-right" title="Create a new Entry"><i class="fa fa-plus"></i></button></a>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    $eventSQL = "SELECT * FROM userEvents userev 
                     INNER JOIN events eve
                     ON userev.eventID = eve.eventID
                     INNER JOIN category cat 
                     ON eve.categoryID = cat.categoryID
                     INNER JOIN units unit
                     ON userev.unitID = unit.unitID
                     WHERE userev.userID = 
                     ".$_SESSION['user_id']." ORDER BY userev.dateCreated DESC";

                    $eventQuery = mysqli_query($conn, $eventSQL);

                    ?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php
                        if(mysqli_num_rows($eventQuery) > 0){

                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Quantity</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($result = mysqli_fetch_assoc($eventQuery)) {
                                        ?>
                                        <tr>
                                            <td><?= $result['eventTitle'] ?></td>
                                            <td><?= $result['quantity'] ?> <?= $result['unitTitle'] ?></td>
                                            <td><?= $result['time'] ?></td>
                                            <td><?= explode(" ",$result['dateOfEvent'])[0] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }else{
                            ?>
                            <div class="panel-heading text-center">
                                You haven't participated in any activities yet
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <a href="addInfo.php?action=addEntry" style="text-decoration: none;">
                                    <button type="button" class="btn btn-outline btn-primary btn-lg btn-block">Create an Entry</button>
                                </a>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        <?php
                        }
                        ?>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="pull-left">Your Goals</h5>
                        <a href="addInfo.php?action=addGoal"><button class="btn btn-outline btn-primary pull-right" title="Create a new Goal"><i class="fa fa-plus"></i></button></a>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    $goalSQL = "SELECT * FROM userGoals us
                      INNER JOIN units un 
                      ON us.unitID = un.unitID
                      INNER JOIN events ev 
                      ON us.eventID = ev.eventID
                     WHERE us.userID=".$_SESSION['user_id'];

                    $goalQuery = mysqli_query($conn, $goalSQL);

                    ?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php
                        if(mysqli_num_rows($goalQuery) > 0){

                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Quantity</th>
                                        <th>Time</th>
                                        <th>Deadline</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($goalResult = mysqli_fetch_assoc($goalQuery)) {
                                        ?>
                                        <tr>
                                            <td><?= $goalResult['eventTitle'] ?></td>
                                            <td><?= $goalResult['quantity'] ?> <?= $goalResult['unitTitle'] ?></td>
                                            <td><?= $goalResult['time'] ?></td>
                                            <td><?= explode(" ",$goalResult['goalDeadline'])[0] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="panel-heading text-center">
                                You haven't added any personal goals yet.
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <a href="addInfo.php?action=addGoal" style="text-decoration: none">
                                    <button type="button" class="btn btn-outline btn-primary btn-lg btn-block">Add a Goal</button>
                                </a>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                            <?php
                        }
                        ?>
                </div>
            </div>
        </div>
            <?php
            if(mysqli_num_rows($eventQuery) > 0){
                ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Another action</a>
                                            </li>
                                            <li><a href="#">Something else here</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>

                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bell fa-fw"></i> Notifications Panel
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                        <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                        <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                        <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-money fa-fw"></i> Payment Received
                                        <span class="pull-right text-muted small"><em>Yesterday</em>
                                    </span>
                                    </a>
                                </div>
                                <!-- /.list-group -->
                                <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                            </div>
                            <!-- /.panel-body -->
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
            <?php
            }else {
                ?>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        More content soon to come!
                    </div>
                </div>
            </div>
                <?php
            }
            ?>
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

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
