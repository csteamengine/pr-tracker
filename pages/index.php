<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/18/17
 * Time: 9:44 AM
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
            <?php
                $nextGoal = "SELECT * FROM userGoals WHERE isActive = 1 AND userID = ".$_SESSION['user_id']." AND goalDeadline >= CURDATE() ORDER BY goalDeadline ASC";
                $nextGoalQuery = mysqli_query($conn, $nextGoal);
                if(mysqli_num_rows($nextGoalQuery) == 0){
                ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-crosshairs fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">0</div>
                                        <div>No goals yet.</div>
                                    </div>
                                </div>
                            </div>
                            <a href="addInfo.php?action=addGoal">
                                <div class="panel-footer">
                                    <span class="pull-left">Create one now!</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }else{
                    $nextGoalResult = mysqli_fetch_assoc($nextGoalQuery);
                    $date1=date_create($nextGoalResult['goalDeadline']);
                    $date2=date_create('now');
                    $diff=date_diff($date2,$date1);

            ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-crosshairs fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?= $diff->format("%a") ?></div>
                                        <div>Day<?= $diff->format("%a") > 1 ? "s" : ""  ?> until next goal</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php

                }
            $completedGoals = "SELECT COUNT(userID) as totalComplete  FROM userGoals WHERE isActive = 1 AND completed=1 AND userID = ".$_SESSION['user_id'];
            $completedQuery = mysqli_query($conn, $completedGoals);
            $completedResult = mysqli_fetch_assoc($completedQuery);

            ?>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-check-square-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $completedResult['totalComplete'] ?></div>
                                <div>Goals completed</div>
                            </div>
                        </div>
                    </div>
                    <a href="/pages/goals.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php

            $nextGoal = "SELECT * FROM userEvents WHERE isActive = 1 AND userID = ".$_SESSION['user_id']." ORDER BY dateOfEvent DESC";
            $nextGoalQuery = mysqli_query($conn, $nextGoal);
            if(mysqli_num_rows($nextGoalQuery) == 0){
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">0</div>
                                    <div>No entries yet.</div>
                                </div>
                            </div>
                        </div>
                        <a href="addInfo.php?action=addActivity">
                            <div class="panel-footer">
                                <span class="pull-left">Create one now!</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }else{
                $nextGoalResult = mysqli_fetch_assoc($nextGoalQuery);
                $date1=date_create($nextGoalResult['dateOfEvent']);
                $date2=date_create('now');
                $diff=date_diff($date1,$date2);

                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar-check-o fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $diff->format("%a") ?></div>
                                    <div>Day<?= $diff->format("%a") > 1 || $diff->format("%a") == 0 ? "s" : ""  ?> since last entry</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php

            }
            $totalEvents = "SELECT  COUNT(DISTINCT eventID) as totalCount FROM userEvents WHERE isActive = 1 AND userID = ".$_SESSION['user_id'];
            $totalQuery = mysqli_query($conn, $totalEvents);
            $totalResult = mysqli_fetch_assoc($totalQuery);

            ?>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bar-chart fa-4x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $totalResult['totalCount'] ?></div>
                                <div>Different activities</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="pull-left">Recent Entries</h5>
                        <div class="pull-right" style="margin-left: 10px">
                            <a href="/pages/activities.php">
                                <button type="button" class="btn btn-primary btn-outline">View All Entries</button>
                            </a>
                        </div>

                        <a href="addInfo.php?action=addEntry"><button class="btn btn-outline btn-primary  pull-right" title="Create a new Entry"><i class="fa fa-plus"></i></button></a>
                        <div class="clearfix"></div>
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
                     ".$_SESSION['user_id']." and userev.isActive=1 ORDER BY userev.dateOfEvent DESC LIMIT 5";

                    $eventQuery = mysqli_query($conn, $eventSQL);

                    ?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php
                        if(mysqli_num_rows($eventQuery) > 0){

                            ?>
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
                                while($result = mysqli_fetch_assoc($eventQuery)) {

                                    $average = getAverage($result);
                                    ?>
                                    <tr>
                                        <td><?= $result['eventTitle'] ?></td>
                                        <td><?= $result['quantity'] ?> <?= $result['unitTitle'] ?></td>
                                        <td><?= $result['reps'] ?></td>
                                        <td><?= $result['sets'] ?></td>
                                        <td><?= $result['time'] == "00:00:00" ? "N/A" : $result['time'] ?></td>
                                        <td>
                                            <?= $average ?>
                                        </td>
                                        <td><?= explode(" ",$result['dateOfEvent'])[0] ?></td>
                                        <td class="text-center">
                                            <a href="/pages/editInfo.php?action=editEntry&id=<?= $result['userEventID'] ?>"><i class="fa fa-pencil" title="Edit Entry"></i></a>
                                            <a href="/pages/editInfo.php?action=deleteEntry&id=<?= $result['userEventID'] ?>"><i class="fa fa-trash" title="Delete Entry"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>

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
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="pull-left">Your Goals</h5>
                        <div class="pull-right" style="margin-left: 10px">
                            <a href="/pages/activities.php">
                                <button type="button" class="btn btn-primary btn-outline">View All Goals</button>
                            </a>
                        </div>
                        <a href="addInfo.php?action=addGoal"><button class="btn btn-outline btn-primary pull-right" title="Create a new Goal"><i class="fa fa-plus"></i></button></a>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    $goalSQL = "SELECT *, us.measureID as theMeasure FROM userGoals us
                      INNER JOIN units un 
                      ON us.unitID = un.unitID
                      INNER JOIN events ev 
                      ON us.eventID = ev.eventID
                     WHERE us.userID=".$_SESSION['user_id']."  AND us.isActive =1 ORDER BY us.goalDeadline ASC LIMIT 5";

                    $goalQuery = mysqli_query($conn, $goalSQL);

                    ?>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php
                        if(mysqli_num_rows($goalQuery) > 0){

                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-Goals">
                                <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Quantity</th>
                                    <th>Reps</th>
                                    <th>Sets</th>
                                    <th>Time</th>
                                    <th>Average</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                while($goalResult = mysqli_fetch_assoc($goalQuery)) {
                                    $average = getGoalAverage($goalResult);
                                    ?>
                                    <tr>
                                        <td><?= $goalResult['eventTitle'] ?></td>
                                        <td><?= $goalResult['quantity'] ?> <?= $goalResult['unitTitle'] ?></td>
                                        <td><?= $goalResult['reps'] ?></td>
                                        <td><?= $goalResult['sets'] ?></td>
                                        <td><?= $goalResult['time'] == "00:00:00" ? "N/A" : $goalResult['time'] ?></td>
                                        <td><?= $average ?></td>
                                        <td><?= explode(" ",$goalResult['goalDeadline'])[0] ?></td>
                                        <td>
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-<?= ($count*20)."%" == '100%' ? "success" : "info" ?>" style="width: <?= ($count*20)."%" ?>">
                                                    <?= ($count*20)."%" == '100%' ? "Completed" : ($count*20)."%" ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="/pages/editInfo.php?action=editGoal&id=<?= $goalResult['userGoalID'] ?>"><i class="fa fa-pencil" title="Edit Goal"></i></a>
                                            <a href="/pages/editInfo.php?action=deleteGoal&id=<?= $goalResult['userGoalID'] ?>"><i class="fa fa-trash" title="Delete Goal"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $count++;
                                    if($count == 6){
                                        $count =1;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
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

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    More content soon to come!
                </div>
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

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-Goals').DataTable({
            responsive: true,
            'paging': false,
            'searching': false,
            'info': false,
            "order": [[ 6, "asc" ]]
        });
    });
    $(document).ready(function() {
        $('#dataTables-Entries').DataTable({
            responsive: true,
            'paging': false,
            'searching': false,
            'info': false,
            "order": [[ 6, "desc" ]]
        });
    });
</script>
</body>

</html>

<?php
