<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/26/17
 * Time: 9:32 AM
 */

include "../includes/php/base.php";
include "../includes/php/general.php";

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
    <style type="text/css">

        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 422px;
        }
        .tt-suggestion {
            font-size: 22px;  /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }
        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }
        .tt-suggestion p {
            margin: 0;
        }
    </style>
</head>

<body>

<div id="wrapper">
    <?php
    include "navigation.php";



    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header row">
                    <h1>
                        <div class="col-lg-6 col-md-6 col-xs-8 col-lg-offset-0 col-md-offset-0 col-xs-offset-3">
                            Your Activities
                        </div>
                        <div class="col-lg-5 col-lg-offset-1 col-md-offset-1 col-md-5 col-xs-6 col-xs-offset-3" >
                            <form action="activities.php" method="get" class="input-group custom-search-form">
                                <span class="input-group-btn">
                                    <a href="addInfo.php?action=addEntry">
                                        <button class="btn btn-outline btn-primary" title="Create a new Entry"><i class="fa fa-plus"></i></button>
                                    </a>
                                </span>
                                <span class="input-group-btn">

                                </span>
                                <input name="event" list="eventList" type="text" class="form-control" id="searchForm" placeholder="Search For Activities...">
                                <datalist id="eventList">
                                    <?php
                                    $events = "SELECT * FROM events WHERE isActive=1 ORDER BY eventTitle ASC";
                                    $eventQuery = mysqli_query($conn, $events);
                                    while($resultEvent = mysqli_fetch_assoc($eventQuery)) {
                                        ?>
                                        <option value="<?= $resultEvent['eventTitle'] ?>"></option>
                                        <?php
                                    }
                                    ?>
                                </datalist>
                                <span class="input-group-btn">

                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>


                            </form>
                        </div>
                    </h1>
                </div>
            </div>
            <?php

            $eventSQL = "SELECT * FROM userEvents userev 
                         INNER JOIN events eve
                         ON userev.eventID = eve.eventID
                         INNER JOIN category cat 
                         ON eve.categoryID = cat.categoryID
                         WHERE userev.userID = 
                         ".$_SESSION['user_id']." GROUP BY eve.eventID ORDER BY userev.dateCreated DESC";

            $eventQuery = mysqli_query($conn, $eventSQL);
            if(mysqli_num_rows($eventQuery) > 0){

                $event = get_value('event');
                if(!empty($event)){
                    $eventSQL = "SELECT * FROM userEvents userev
                         INNER JOIN events eve
                         ON userev.eventID = eve.eventID
                         INNER JOIN category cat
                         ON eve.categoryID = cat.categoryID
                         WHERE userev.userID =
                         ".$_SESSION['user_id']." AND eve.eventTitle ='".str_replace('+', ' ', get_value('event'))."' GROUP BY eve.eventID ORDER BY userev.dateCreated DESC";

                    $eventQuery = mysqli_query($conn, $eventSQL);
                }
                ?>
                <div class="row">
            <?php
                while($eventResult = mysqli_fetch_assoc($eventQuery)) {

                    ?>

                        <div class="col-lg-6 col-md-6 col-lg-offset-0 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">
                                    <h5 class="pull-left"><?= $eventResult['eventTitle'] ?></h5>
                                    <a href="addInfo.php?action=addEntry&category=<?= $eventResult['categoryID'] ?>&event=<?= $eventResult['eventID'] ?>"><button class="btn btn-outline btn-primary  pull-right" title="Create a new Entry"><i class="fa fa-plus"></i></button></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Activity</th>
                                                <th>Quantity</th>
                                                <th>Reps</th>
                                                <th>Sets</th>
                                                <th>Time</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $newSQL = "SELECT * FROM userEvents userev 
                                                 INNER JOIN events eve
                                                 ON userev.eventID = eve.eventID
                                                 INNER JOIN category cat 
                                                 ON eve.categoryID = cat.categoryID
                                                 WHERE userev.userID = 
                                                 ".$_SESSION['user_id']." AND eve.eventID = ".$eventResult['eventID']." ORDER BY userev.dateCreated DESC";
                                            $newQuery = mysqli_query($conn, $newSQL);
                                            while($newResult = mysqli_fetch_assoc($newQuery)) {
                                                ?>
                                                <tr>
                                                    <td><?= $newResult['eventTitle'] ?></td>
                                                    <td><?= $newResult['quantity'] ?> <?= $newResult['unitTitle'] ?></td>
                                                    <td><?= $newResult['reps'] ?></td>
                                                    <td><?= $newResult['sets'] ?></td>
                                                    <td><?= $newResult['time'] ?></td>
                                                    <td><?= explode(" ",$newResult['dateOfEvent'])[0] ?></td>
                                                    <td>
                                                        <a href="/pages/editInfo.php?action=editEntry&id=<?= $newResult['userEventID'] ?>"><i class="fa fa-pencil" title="Edit Entry"></i></a>
                                                        <a href="/pages/editInfo.php?action=deleteEntry&id=<?= $newResult['userEventID'] ?>"><i class="fa fa-trash" title="Delete Entry"></i></a>
                                                    </td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                        </div>

                    <?php

                }
                ?>
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

</body>

</html>
