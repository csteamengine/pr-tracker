<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/26/17
 * Time: 10:23 AM
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

    <title>Goals | Room For ImPRovement</title>

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

</head>

<body>

<div id="wrapper">
    <?php
    include "navigation.php";

    $eventSQL = "SELECT * FROM userGoals 
     WHERE userID = 
     ".$_SESSION['user_id'];

    $eventQuery = mysqli_query($conn, $eventSQL);


    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Goals</h1>
            </div>
            <?php
            if(mysqli_num_rows($eventQuery) > 0){
                ?>
                <div class="col-lg-8 col-lg-offset-2 col-md-offset-2 col-md-8 col-xs-10 col-xs-offset-1">
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
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-Goals">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th>Quantity</th>
                                            <th>Time</th>
                                            <th>Deadline</th>
                                            <th>Progress</th>
                                            <th>Action</th>
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
                                                <td>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info" style="width: 80%">
                                                                Low Disk Space: 80% full
                                                            </div>
                                                        </div>
                                                </td>
                                                <td>
                                                    <a href="/pages/editInfo.php?action=editGoal&id=<?= $goalResult['userGoalID'] ?>"><i class="fa fa-pencil" title="Edit Goal"></i></a>
                                                    <a href="/pages/editInfo.php?action=deleteGoal&id=<?= $goalResult['userGoalID'] ?>"><i class="fa fa-trash" title="Delete Goal"></i></a>
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
            }else{
                ?>
                <div class="col-lg-4 col-lg-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            You haven't created any goals yet.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href="addInfo.php?action=addGoal" style="text-decoration: none">
                                <button type="button" class="btn btn-outline btn-primary btn-lg btn-block">Create new Goal</button>
                            </a>
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

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
<script>
$(document).ready(function() {
    $('#dataTables-Goals').DataTable({
        responsive: true
    });
});
</script>
</body>

</html>
