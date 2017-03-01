<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/26/17
 * Time: 7:34 PM
 */

include "../includes/php/base.php";
include "../includes/php/general.php";

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
    header("location: login.php");
}


$action = get_value('action');

switch($action){
    case 'insertEditEntry':
        $time = get_value('hours').":".get_value('minutes').":".get_value('seconds');
        $date = get_value('date')." ".get_value('time');

        $addEntrySQL = "UPDATE userEvents SET userID='".mysqli_real_escape_string($conn,$_SESSION['user_id'])."', categoryID='".mysqli_real_escape_string($conn,get_value('category'))."', eventID='".mysqli_real_escape_string($conn,get_value('activity'))."', unitID='".mysqli_real_escape_string($conn,get_value('units'))."', quantity='".mysqli_real_escape_string($conn,get_value('quantity'))."', sets='".mysqli_real_escape_string($conn,get_value('sets'))."', time='".mysqli_real_escape_string($conn,$time)."', dateOfEvent='".mysqli_real_escape_string($conn,$date)."' WHERE userEventID = ".mysqli_real_escape_string($conn,get_value('userEventID'));
        $addEntryQuery = mysqli_query($conn, $addEntrySQL);

        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
        }else{
            header("location: /pages/index.php");
        }
        break;

    case 'insertEditActivity':
        $addActivitySQL = "UPDATE events SET eventTitle = '".mysqli_real_escape_string($conn,get_value('activity'))."', eventDescription='".mysqli_real_escape_string($conn,get_value('description'))."', categoryID='".mysqli_real_escape_string($conn,get_value('category'))."', createdByUserID='".mysqli_real_escape_string($conn,$_SESSION['user_id'])."' WHERE eventID = ".mysqli_real_escape_string($conn,get_value('eventID'));
        $addActiveQuery = mysqli_query($conn, $addActivitySQL);

        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
            echo $error;
        }else{
            header("location: /pages/index.php");
        }
        break;
    case 'insertEditGoal':
        $time = str_pad(get_value('hours'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('minutes'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('seconds'),2,"0",STR_PAD_LEFT);
        $date = get_value('date')." 00:00:00";

        $addEntrySQL = "UPDATE userGoals SET userID='".mysqli_real_escape_string($conn,$_SESSION['user_id'])."', categoryID='".mysqli_real_escape_string($conn,get_value('category'))."', eventID='".mysqli_real_escape_string($conn,get_value('activity'))."', unitID='".mysqli_real_escape_string($conn,get_value('units'))."', quantity='".mysqli_real_escape_string($conn,get_value('quantity'))."', reps='".mysqli_real_escape_string($conn,get_value('reps'))."', sets='".mysqli_real_escape_string($conn,get_value('sets'))."', time='".mysqli_real_escape_string($conn,$time)."', goalDeadline='".mysqli_real_escape_string($conn,$date)."', goalDescription='".mysqli_real_escape_string($conn, get_value('description'))."', measureID='".mysqli_real_escape_string($conn, get_value('measure'))."' WHERE userGoalID = ".mysqli_real_escape_string($conn,get_value('userGoalID'));
        $addEntryQuery = mysqli_query($conn, $addEntrySQL);

        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
            echo $error;
        }else{
            header("location: /pages/index.php");
        }
        break;
        break;
    case 'insertDeleteEntry':
        $sql = "DELETE FROM userEvents WHERE userEventID =".mysqli_real_escape_string($conn,get_value('id'))." AND userID = ".mysqli_real_escape_string($conn,$_SESSION['user_id']);
        $query = mysqli_query($conn, $sql);
        header("location: /pages/index.php");
        break;
    case 'insertDeleteActivity':
        $sql = "DELETE FROM events WHERE eventID =".mysqli_real_escape_string($conn,get_value('id'))." AND userID = ".mysqli_real_escape_string($conn,$_SESSION['user_id']);
        $query = mysqli_query($conn, $sql);
        header("location: /pages/index.php");
        break;
    case 'insertDeleteGoal':
        $sql = "DELETE FROM userGoals WHERE userGoalID =".mysqli_real_escape_string($conn,get_value('id'))." AND userID = ".mysqli_real_escape_string($conn,$_SESSION['user_id']);
        $query = mysqli_query($conn, $sql);
        header("location: /pages/index.php");
        break;

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

    <style>
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            display: none;
            min-width: 160px;
            _width: 160px;
            padding: 4px 0;
            margin: 2px 0 0 0;
            list-style: none;
            background-color: #ffffff;
            border-color: #ccc;
            border-color: rgba(0, 0, 0, 0.2);
            border-style: solid;
            border-width: 1px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            *border-right-width: 2px;
            *border-bottom-width: 2px;
        }
        .ui-menu-item > a.ui-corner-all {
            display: block;
            padding: 3px 15px;
            clear: both;
            font-weight: normal;
            line-height: 18px;
            color: #555555;
            white-space: nowrap;
        }
        .ui-state-hover, &.ui-state-active {
                              color: #ffffff;
                              text-decoration: none;
                              background-color: #0088cc;
                              border-radius: 0px;
                              -webkit-border-radius: 0px;
                              -moz-border-radius: 0px;
                              background-image: none;
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
                <?php
                switch($action){
                    case 'editActivity':
                        ?>
                        <h1 class="page-header">Edit Activity</h1>
                        <?php
                        break;
                    case 'editEntry':
                        ?>
                        <h1 class="page-header">Edit Entry</h1>
                        <?php
                        break;
                    case'editGoal':
                        ?>
                        <h1 class="page-header">Edit Goal</h1>
                        <?php
                        break;
                    case 'deleteGoal':
                        ?>
                        <h1 class="page-header">Delete Goal</h1>
                        <?php
                        break;
                    case 'deleteEntry':
                        ?>
                        <h1 class="page-header">Delete Entry</h1>
                        <?php
                        break;
                    case 'deleteActivity':
                        ?>
                        <h1 class="page-header">Delete Activity</h1>
                        <?php
                        break;
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        switch ($action) {
                            case "":
                                header("location: index.php");
                                break;
                            case "editActivity":
                                ?>
                                <form action="editInfo.php?action=insertEditActivity" method="post" id="editForm">
                                    <input type="hidden" name="eventID" value="<?= get_value('id') ?>">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <?php
                                                $categorySQL = "SELECT categoryTitle, categoryID FROM category";
                                                $categoryQuery = mysqli_query($conn, $categorySQL);
                                                ?>

                                                <select id="categorySelect" name="category" class="form-control" required>
                                                    <option value="" >Select A Category...</option>
                                                    <?php
                                                    while($result = mysqli_fetch_assoc($categoryQuery)){
                                                        ?>
                                                        <option value="<?= $result['categoryID'] ?>" ><?= $result['categoryTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group" id="groupActivity" hidden>
                                                <label>Activity</label>
                                                <input type="text" class="form-control" id="activity" name="activity" placeholder="Activity Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupDescription" hidden>
                                            <div class=" col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                                <label>Description</label>
                                                <textarea style="resize: none" placeholder="Enter Activity Description" title="Description" class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group" id="submitGroup" hidden>
                                            <div class="col-lg-2 col-lg-offset-5 col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3">
                                                <input type="submit"  value="Create Entry" class="btn btn-primary btn-outline form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                break;
                            case "editEntry":

                                $eventSQL = "SELECT * FROM userEvents userev 
                                             INNER JOIN events eve
                                             ON userev.eventID = eve.eventID
                                             INNER JOIN category cat 
                                             ON eve.categoryID = cat.categoryID
                                             INNER JOIN units unit
                                             ON userev.unitID = unit.unitID
                                             WHERE userev.userID = 
                                             ".$_SESSION['user_id']." AND userEventID = ".get_value('id');

                                $eventQuery = mysqli_query($conn, $eventSQL);
                                if(mysqli_num_rows($eventQuery) == 0){
                                    header("location: /pages/index.php");
                                }
                                $eventResult = mysqli_fetch_assoc($eventQuery);
                                ?>
                                <form action="editInfo.php?action=insertEditEntry" method="post" id="editForm">
                                    <input type="hidden" name="userEventID" value="<?= get_value('id') ?>">

                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <?php
                                                $categorySQL = "SELECT categoryTitle, categoryID FROM category";
                                                $categoryQuery = mysqli_query($conn, $categorySQL);
                                                ?>

                                                <select id="categorySelect" name="category" class="form-control" required>
                                                    <option value="" >Select A Category...</option>
                                                    <?php
                                                    while($result = mysqli_fetch_assoc($categoryQuery)){
                                                        ?>
                                                        <option value="<?= $result['categoryID'] ?>" <?= $eventResult['categoryID'] == $result['categoryID'] ? "selected" : "" ?>><?= $result['categoryTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group" id="groupActivity">
                                                <label>Activity</label>
                                                <select class="form-control" id="activity" name="activity">
                                                    <option value="" ></option>
                                                    <?php
                                                    $actSql = "SELECT eventID, eventTitle FROM events WHERE categoryID=".$eventResult['categoryID'];
                                                    $actquery = mysqli_query($conn, $actSql);
                                                    while($actResult = mysqli_fetch_assoc($actquery)) {
                                                        ?>
                                                        <option value="<?= $actResult['eventID'] ?>" <?= $actResult['eventID'] == $eventResult['eventID'] ? "selected" : "" ?>><?= $actResult['eventTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupUnits" >
                                            <div class=" col-xs-4 col-xs-offset-0 col-md-2 col-md-offset-3 col-lg-2 col-lg-offset-3">
                                                <label>Quantity</label>
                                                <input type="number" step="any" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?= $eventResult['quantity'] ?>">
                                            </div>
                                            <div class=" col-xs-4 col-md-2 col-lg-2">
                                                <label>Units</label>
                                                <select class="form-control" id="units" name="units">
                                                    <option value=""></option>
                                                    <?php
                                                    $unitSQL = "SELECT * FROM units";
                                                    $unitQuery = mysqli_query($conn, $unitSQL);
                                                    while($result = mysqli_fetch_assoc($unitQuery)){
                                                        ?>
                                                        <option value="<?= $result['unitID'] ?>" <?= $eventResult['unitID'] == $result['unitID'] ? "selected" : ""  ?>><?= $result['unitTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-xs-2">
                                                <label for="sets">Reps</label>
                                                <input type="number" name="reps" min="1" class="form-control" id="reps" value="1">
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-xs-2">
                                                <label for="sets">Sets</label>
                                                <input type="number" name="sets" min="1" class="form-control" id="sets" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="timeRow" >
                                        <div class="form-group">
                                            <div class="col-lg-2 col-lg-offset-3 col-md-2 col-md-offset-3 col-xs-4 col-xs-offset-0">
                                                <label for="hours">Hours</label>
                                                <input type="number" min="0" name="hours" class="form-control" id="hours" value="<?= explode(":", $eventResult['time'])[0] == 00 ? "0" : explode(":", $eventResult['time'])[0] ?>">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="minutes">Minutes</label>
                                                <input type="number" min="0" name="minutes" class="form-control" id="minutes" value="<?= explode(":", $eventResult['time'])[1] == 00 ? "0" : ltrim(explode(":", $eventResult['time'])[1], '0') ?>">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="seconds">Seconds</label>
                                                <input type="number" step="any" name="seconds" min="0" class="form-control" id="seconds" value="<?= explode(":", $eventResult['time'])[2] == 00 ? "0" : ltrim(explode(":", $eventResult['time'])[2], '0') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupTime" >
                                            <div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-xs-6 col-xs-offset-0">
                                                <label>Date</label>
                                                <input class="form-control" name="date" type="date" id="date" value="<?= explode(' ',$eventResult['dateOfEvent'])[0] ?>"  required>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <label>Time</label>
                                                <input class="form-control" name="time" type="time" id="time" value="<?= explode(' ',$eventResult['dateOfEvent'])[1] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group" id="submitGroup" >
                                            <div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
                                                <input type="submit"  value="Save Entry" class="btn btn-primary btn-outline form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                break;
                            case "editGoal":
                                $sql = "SELECT * FROM userGoals WHERE userGoalID =".get_value('id');
                                $query = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($query) == 0){
                                    header("location: /pages/index.php");
                                }
                                $goalResult = mysqli_fetch_assoc($query);
                                ?>
                                <form action="editInfo.php?action=insertEditGoal" method="post" id="editForm">
                                    <input type="hidden" name="userGoalID" value="<?= get_value('id') ?>">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <?php
                                                $categorySQL = "SELECT categoryTitle, categoryID FROM category";
                                                $categoryQuery = mysqli_query($conn, $categorySQL);
                                                ?>

                                                <select id="categorySelect" name="category" class="form-control" required>
                                                    <option value="" >Select A Category...</option>
                                                    <?php
                                                    while($result = mysqli_fetch_assoc($categoryQuery)){
                                                        ?>
                                                        <option value="<?= $result['categoryID'] ?>" <?= $goalResult['categoryID'] == $result['categoryID'] ? "selected" : "" ?>><?= $result['categoryTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                                            <div class="form-group" id="groupActivity" >
                                                <label>Activity</label>
                                                <select class="form-control" id="activity" name="activity">
                                                    <option value="" ></option>
                                                    <?php
                                                    $actSql = "SELECT eventID, eventTitle FROM events WHERE categoryID=".$goalResult['categoryID'];
                                                    $actquery = mysqli_query($conn, $actSql);
                                                    while($actResult = mysqli_fetch_assoc($actquery)) {
                                                        ?>
                                                        <option value="<?= $actResult['eventID'] ?>" <?= $actResult['eventID'] == $goalResult['eventID'] ? "selected" : "" ?>><?= $actResult['eventTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupDescription" >
                                            <div class=" col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                                <label>Description</label>
                                                <textarea style="resize: none" placeholder="Enter Activity Description" title="Description" class="form-control" name="description"><?= $goalResult['goalDescription'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupUnits" >
                                            <div class=" col-xs-4 col-xs-offset-0 col-md-2 col-md-offset-3 col-lg-2 col-lg-offset-3">
                                                <label>Quantity</label>
                                                <input type="number" step="any" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?= $goalResult['quantity'] ?>">
                                            </div>
                                            <div class=" col-xs-4 col-md-2 col-lg-2">
                                                <label>Units</label>
                                                <select class="form-control" id="units" name="units">
                                                    <option value=""></option>
                                                    <?php
                                                    $unitSQL = "SELECT * FROM units";
                                                    $unitQuery = mysqli_query($conn, $unitSQL);
                                                    while($result = mysqli_fetch_assoc($unitQuery)){
                                                        ?>
                                                        <option value="<?= $result['unitID'] ?>" <?= $goalResult['unitID'] == $result['unitID'] ? "selected" : "" ?>><?= $result['unitTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-xs-2">
                                                <label for="sets">Reps</label>
                                                <input type="number" name="reps" min="1" class="form-control" id="reps" value="1">
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-xs-2">
                                                <label for="sets">Sets</label>
                                                <input type="number" name="sets" min="1" class="form-control" id="sets" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="timeRow">
                                        <div class="form-group">
                                            <div class="col-lg-2 col-lg-offset-3 col-md-2 col-md-offset-3 col-xs-4 col-xs-offset-0">
                                                <label for="hours">Hours</label>
                                                <input type="number" min="0" name="hours" class="form-control" id="hours" value="<?= explode(":", $goalResult['time'])[0] == 00 ? "0" : explode(":", $goalResult['time'])[0] ?>">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="minutes">Minutes</label>
                                                <input type="number" min="0" name="minutes" class="form-control" id="minutes" value="<?= explode(":", $goalResult['time'])[1] == 00 ? "0" : explode(":", $goalResult['time'])[1] ?>">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="seconds">Seconds</label>
                                                <input type="number" step="any" name="seconds" min="0" class="form-control" id="seconds" value="<?= explode(":", $goalResult['time'])[2] == 00 ? "0" : explode(":", $goalResult['time'])[2] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupMeasurement" >
                                            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                                                <label>Goal Measurement</label>
                                                <a href="#" data-toggle="popover" title="Goal Measurement" data-placement="right" data-content="This will be used to track how close you are to your goal. E.g. Total Quantity would be a goal to run 500 miles before a certain date."><i class="fa fa-info-circle"></i></a>
                                                <select name="measure" class="form-control" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $measure = "SELECT * FROM measure WHERE isActive =1";
                                                    $measureQ = mysqli_query($conn, $measure);
                                                    while($measureR = mysqli_fetch_assoc($measureQ)) {
                                                        ?>
                                                        <option value="<?= $measureR['measureID'] ?>" <?= $measureR['measureID'] == $goalResult['measureID'] ? "selected" : "" ?>><?= $measureR['measureTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupTime">
                                            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                                                <label>Goal Date</label>
                                                <input class="form-control" name="date" type="date" id="date" placeholder="mm/dd/yyyy" value="<?= explode(" ", $goalResult['goalDeadline'])[0] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group" id="submitGroup">
                                            <div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
                                                <input type="submit"  value="Save Goal" class="btn btn-primary btn-outline form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                break;
                            case "deleteGoal":
                                ?>
                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
                                    <div class="panel panel-red">
                                        <div class="panel-heading text-center">
                                            Delete Goal
                                        </div>
                                        <div class="panel-body text-center">
                                            <p>Are you sure you want to delete this goal?</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover text-left">
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
                                                    $goalSQL = "SELECT * FROM userGoals us
                                                                  INNER JOIN units un 
                                                                  ON us.unitID = un.unitID
                                                                  INNER JOIN events ev 
                                                                  ON us.eventID = ev.eventID
                                                                 WHERE us.userID=".$_SESSION['user_id']." 
                                                                 AND us.userGoalID = ".get_value('id');

                                                    $goalQuery = mysqli_query($conn, $goalSQL);
                                                    if(mysqli_num_rows($goalQuery) == 0){
                                                        header("location: /pages/index.php");
                                                    }
                                                    $goalResult = mysqli_fetch_assoc($goalQuery)
                                                    ?>
                                                    <tr>
                                                        <td><?= $goalResult['eventTitle'] ?></td>
                                                        <td><?= $goalResult['quantity'] ?> <?= $result['unitTitle'] ?></td>
                                                        <td><?= $goalResult['time'] ?></td>
                                                        <td><?= explode(" ",$goalResult['goalDeadline'])[0] ?></td>
                                                    </tr>
                                                    <?php

                                                    ?>
                                                    </tbody>
                                                </table>
                                                <div class="col-lg-12">
                                                    <form action="/pages/editInfo.php" method="POST" >
                                                        <input type="hidden" name="id" value="<?= $goalResult['userGoalID'] ?>">
                                                        <input type="hidden" name="action" value="insertDeleteGoal">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
                                                                    <input type="submit" class="btn btn btn-danger form-control" value="Delete Goal">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.col-lg-4 -->
                                </div>
                                <?php
                                break;
                            case "deleteEntry":
                                ?>
                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
                                    <div class="panel panel-red">
                                        <div class="panel-heading text-center">
                                            Delete Entry
                                        </div>
                                        <div class="panel-body text-center">
                                            <p>Are you sure you want to delete this entry?</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover text-left">
                                                    <thead>
                                                    <tr>
                                                        <th>Activity</th>
                                                        <th>Quantity</th>
                                                        <th>Sets</th>
                                                        <th>Time</th>
                                                        <th>Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $eventSQL = "SELECT * FROM userEvents userev 
                                                                 INNER JOIN events eve
                                                                 ON userev.eventID = eve.eventID
                                                                 INNER JOIN category cat 
                                                                 ON eve.categoryID = cat.categoryID
                                                                 INNER JOIN units unit
                                                                 ON userev.unitID = unit.unitID
                                                                 WHERE userev.userID = 
                                                                 ".$_SESSION['user_id']." AND userEventID = ".get_value('id');
                                                    $eventQuery = mysqli_query($conn, $eventSQL);
                                                    if(mysqli_num_rows($eventQuery) == 0){
                                                        header("location: /pages/index.php");
                                                    }
                                                    $entryResult = mysqli_fetch_assoc($eventQuery)
                                                    ?>
                                                    <tr>
                                                        <td><?= $entryResult['eventTitle'] ?></td>
                                                        <td><?= $entryResult['quantity'] ?> <?= $entryResult['unitTitle'] ?></td>
                                                        <td><?= $entryResult['sets'] ?></td>
                                                        <td><?= $entryResult['time'] ?></td>
                                                        <td><?= explode(" ",$entryResult['dateOfEvent'])[0] ?></td>
                                                    </tr>
                                                    <?php

                                                    ?>
                                                    </tbody>
                                                </table>
                                                <div class="col-lg-12">
                                                    <form action="/pages/editInfo.php" method="POST" >
                                                        <input type="hidden" name="id" value="<?= $entryResult['userEventID'] ?>">
                                                        <input type="hidden" name="action" value="insertDeleteEntry">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
                                                                    <input type="submit" class="btn btn btn-danger form-control" value="Delete Entry">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.col-lg-4 -->
                                </div>
                                <?php
                                break;
                            case "deleteActivity":
                                ?>
                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
                                    <div class="panel panel-red">
                                        <div class="panel-heading text-center">
                                            Delete Goal
                                        </div>
                                        <div class="panel-body text-center">
                                            <p>Are you sure you want to delete this goal?</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover text-left">
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
                                                    $goalSQL = "SELECT * FROM userGoals us
                                                                  INNER JOIN units un 
                                                                  ON us.unitID = un.unitID
                                                                  INNER JOIN events ev 
                                                                  ON us.eventID = ev.eventID
                                                                 WHERE us.userID=".$_SESSION['user_id'];

                                                    $goalQuery = mysqli_query($conn, $goalSQL);
                                                    $goalResult = mysqli_fetch_assoc($goalQuery)
                                                    ?>
                                                    <tr>
                                                        <td><?= $goalResult['eventTitle'] ?></td>
                                                        <td><?= $goalResult['quantity'] ?> <?= $result['unitTitle'] ?></td>
                                                        <td><?= $goalResult['time'] ?></td>
                                                        <td><?= explode(" ",$goalResult['goalDeadline'])[0] ?></td>
                                                    </tr>
                                                    <?php

                                                    ?>
                                                    </tbody>
                                                </table>
                                                <div class="col-lg-12">
                                                    <form action="/pages/editInfo.php" method="POST" >
                                                        <input type="hidden" name="id" value="<?= $goalResult['goalID'] ?>">
                                                        <input type="hidden" name="action" value="insertDeleteGoal">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4">
                                                                    <input type="submit" class="btn btn btn-danger form-control" value="Delete Goal">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.col-lg-4 -->
                                </div>
                                <?php
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="//code.jquery.com/jquery-2.1.3.js"></script>


<script src = "https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<link href="http://jquery-ui-bootstrap.github.io/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>
<script src="/includes/bootcomplete.js-master/dist/jquery.bootcomplete.js"></script>

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


<script type="text/javascript">

    $('#categorySelect').change(function(){
        if($('#categorySelect').val() != ""){
            $('#groupActivity').show();
        }else{
            $('#groupActivity').hide();
        }
        $.getJSON('/pages/ajax.php?action=getEvents&category='+$('#categorySelect').val(), function(result){
            $('#activity').empty();
            $('#activity').append($('<option>').text("").attr('value', " "));
            $.each(result, function(i, value) {
                $('#activity').append($('<option>').text(value['label']).attr('value', value['id']));
            });
        });
    });
    $('[data-toggle="popover"]').popover();

</script>


</body>

</html>

