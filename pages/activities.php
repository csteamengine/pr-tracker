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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

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
                    </h1>
                </div>
            </div>
            <?php

            $eventSQL = "SELECT *, userev.measureID as theMeasure FROM userEvents userev 
                     INNER JOIN events eve
                     ON userev.eventID = eve.eventID
                     INNER JOIN category cat 
                     ON eve.categoryID = cat.categoryID
                     INNER JOIN units unit
                     ON userev.unitID = unit.unitID
                     WHERE userev.userID = 
                     ".$_SESSION['user_id']." and userev.isActive=1 ORDER BY userev.dateOfEvent DESC";

            $eventQuery = mysqli_query($conn, $eventSQL);
            if(mysqli_num_rows($eventQuery) > 0){
            ?>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h5 class="pull-left">Your Entries</h5>
                        <a href="addInfo.php?action=addEntry&category=<?= $eventResult['categoryID'] ?>&event=<?= $eventResult['eventID'] ?>"><button class="btn btn-outline btn-primary  pull-right" title="Create a new Entry"><i class="fa fa-plus"></i></button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-Entries">
                            <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Quantity</th>
                                <th>Reps</th>
                                <th>Sets</th>
                                <th>Time</th>
                                <th>Average</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            while($newResult = mysqli_fetch_assoc($eventQuery)) {
                                ?>
                                <tr>
                                    <td><?= $newResult['eventTitle'] ?></td>
                                    <td><?= $newResult['quantity'] ?> <?= $newResult['unitTitle'] ?></td>
                                    <td><?= $newResult['reps'] ?></td>
                                    <td><?= $newResult['sets'] ?></td>
                                    <td><?= $newResult['time'] ?></td>
                                    <td><?= getAverage($newResult) ?></td>
                                    <td><?= explode(" ",$newResult['dateOfEvent'])[0] ?></td>
                                    <td class="text-center">
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

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<script src="//netsh.pp.ua/upwork-demo/1/js/typeahead.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-Entries').DataTable({
            responsive: true,
            "order": [[ 6, "desc" ]]

        });
    });
</script>
</body>

</html>
