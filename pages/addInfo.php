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
    case 'getCategories':
        $sql = "SELECT categoryTitle FROM category WHERE categoryTitle LIKE '%".get_value('value')."%'";
        $query = mysqli_query($conn, $sql);

        $json = array();

        while($result = mysqli_fetch_assoc($query)){
            array_push($json, $result['categoryTitle']);
        }
        echo json_encode($json);
        exit;
        break;

    case 'insertEntry':
        $time = str_pad(get_value('hours'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('minutes'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('seconds'),2,"0",STR_PAD_LEFT);
        $date = get_value('date')." ".get_value('time');


        $addEntrySQL = "INSERT INTO userEvents (userID, categoryID, eventID, unitID, quantity, sets, time, dateOfEvent) VALUES ('".$_SESSION['user_id']."','".get_value('category')."','".get_value('activity')."','".get_value('units')."','".get_value('quantity')."','".get_value('sets')."','".$time."','".$date."')";
        $addEntryQuery = mysqli_query($conn, $addEntrySQL);

        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
        }else{
            header("location: /pages/index.php");
        }
        break;

    case 'insertActivity':
        $addActivitySQL = "INSERT INTO events (eventTitle, eventDescription, categoryID, createdByUserID) VALUES ('".get_value('activity')."','".get_value('description')."','".get_value('category')."','".$_SESSION['user_id']."')";
        $addActiveQuery = mysqli_query($conn, $addActivitySQL);
        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
            echo $error;
        }else{
            header("location: /pages/index.php");
        }
        break;
    case 'insertFriend':

        break;
    case 'insertGoal':
        $time = str_pad(get_value('hours'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('minutes'),2,"0",STR_PAD_LEFT).":".str_pad(get_value('seconds'),2,"0",STR_PAD_LEFT);
        $date = get_value('date')." 00:00:00";


        $addEntrySQL = "INSERT INTO userGoals (userID, categoryID, eventID, unitID, quantity, sets, time, goalDeadline, goalDescription) VALUES ('".$_SESSION['user_id']."','".get_value('category')."','".get_value('activity')."','".get_value('units')."','".get_value('quantity')."','".get_value('sets')."','".$time."','".$date."', '".get_value('description')."')";
        $addEntryQuery = mysqli_query($conn, $addEntrySQL);

        if(mysqli_error($conn) != ""){
            $error = mysqli_error($conn);
            echo $error;
        }else{
            header("location: /pages/index.php");
        }
        break;
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

    $eventSQL = "SELECT * FROM userGoals 
     WHERE userev.userID = 
     ".$_SESSION['user_id'];

    $eventQuery = mysqli_query($conn, $eventSQL);


    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
                switch($action){
                    case 'addActivity':
                        ?>
                        <h1 class="page-header">Add Activity</h1>
                        <?php
                        break;
                    case 'addEntry':
                        ?>
                        <h1 class="page-header">Add Entry</h1>
                        <?php
                        break;
                    case 'addRecord':
                        ?>
                        <h1 class="page-header">Add Record</h1>
                        <?php
                        break;
                    case'addGoal':
                        ?>
                        <h1 class="page-header">Add Goal</h1>
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
            case "addActivity":
                ?>
                <form action="addInfo.php?action=insertActivity" method="post" id="editForm">
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
            case "addEntry":
                ?>
                                <form action="addInfo.php?action=insertEntry" method="post" id="editForm">
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
                                                <select class="form-control" id="activity" name="activity" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupUnits" hidden>
                                            <div class=" col-xs-4 col-xs-offset-0 col-md-2 col-md-offset-3 col-lg-2 col-lg-offset-3">
                                                <label>Quantity</label>
                                                <input type="number" step="any" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
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
                                                        <option value="<?= $result['unitID'] ?>"><?= $result['unitTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="sets">Sets</label>
                                                <input type="number" name="sets" min="1" class="form-control" id="sets" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="timeRow" hidden>
                                        <div class="form-group">
                                            <div class="col-lg-2 col-lg-offset-3 col-md-2 col-md-offset-3 col-xs-4 col-xs-offset-0">
                                                <label for="hours">Hours</label>
                                                <input type="number" min="0" name="hours" class="form-control" id="hours" value="0">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="minutes">Minutes</label>
                                                <input type="number" min="0" name="minutes" class="form-control" id="minutes" value="0">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-xs-4">
                                                <label for="seconds">Seconds</label>
                                                <input type="number" step="any" name="seconds" min="0" class="form-control" id="seconds" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group" id="groupTime" hidden>
                                            <div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-xs-6 col-xs-offset-0">
                                                <label>Date</label>
                                                <input class="form-control" name="date" type="date" id="date" required>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <label>Time</label>
                                                <input class="form-control" name="time" type="time" id="time">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group" id="submitGroup" hidden>
                                            <div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
                                                <input type="submit"  value="Create Entry" class="btn btn-primary btn-outline form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                <?php
                break;
            case "addFriend":
                ?>

                <form action="addInfo.php?action=insertFriend" method="post" id="editForm">
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
            case "addGoal":
                ?>
                <form action="addInfo.php?action=insertGoal" method="post" id="editForm">
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
                                <select class="form-control" id="activity" name="activity"></select>
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
                    <div class="row">
                        <div class="form-group" id="groupUnits" hidden>
                            <div class=" col-xs-4 col-xs-offset-0 col-md-2 col-md-offset-3 col-lg-2 col-lg-offset-3">
                                <label>Quantity</label>
                                <input type="number" step="any" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
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
                                        <option value="<?= $result['unitID'] ?>"><?= $result['unitTitle'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-4">
                                <label for="sets">Sets</label>
                                <input type="number" name="sets" min="1" class="form-control" id="sets" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="timeRow" hidden>
                        <div class="form-group">
                            <div class="col-lg-2 col-lg-offset-3 col-md-2 col-md-offset-3 col-xs-4 col-xs-offset-0">
                                <label for="hours">Hours</label>
                                <input type="number" min="0" name="hours" class="form-control" id="hours" value="0">
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-4">
                                <label for="minutes">Minutes</label>
                                <input type="number" min="0" name="minutes" class="form-control" id="minutes" value="0">
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-4">
                                <label for="seconds">Seconds</label>
                                <input type="number" step="any" name="seconds" min="0" class="form-control" id="seconds" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group" id="groupTime" hidden>
                            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                                <label>Goal Date</label>
                                <input class="form-control" name="date" type="date" id="date" placeholder="mm/dd/yyyy">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group" id="submitGroup" hidden>
                            <div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
                                <input type="submit"  value="Create Goal" class="btn btn-primary btn-outline form-control">
                            </div>
                        </div>
                    </div>
                </form>
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

<script>

    $('#editForm').submit(function(){

    });
</script>

<?php
switch($action){
    case 'addEntry':
        ?>
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
            $('#activity').change(function(){
                if($('#activity').val() == ""){
                    $('#groupUnits').hide();
                    $('#timeRow').hide();
                    $('#groupTime').hide();
                    $('#submitGroup').hide();
                }else{
                    $('#groupTime').show();
                    $('#timeRow').show();
                    $('#groupUnits').show();
                    $('#submitGroup').show();
                }
            })
        </script>
        <?php
        break;
    case 'addActivity':
        ?>
        <script type="text/javascript">

            $('#categorySelect').change(function(){
                if($('#categorySelect').val() != ""){
                    $('#groupActivity').show();
                    $('#groupDescription').show();
                    $('#submitGroup').show();
                }else{
                    $('#groupDescription').hide();
                    $('#submitGroup').hide();
                    $('#groupActivity').hide();
                }
            });
        </script>
        <?php
        break;
    case 'addFriend':
        ?>

        <?php
        break;
    case 'addGoal':
            ?>
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
                $('#activity').change(function(){
                    if($('#activity').val() == ""){
                        $('#groupUnits').hide();
                        $('#timeRow').hide();
                        $('#groupTime').hide();
                        $('#submitGroup').hide();
                        $('#groupDescription').hide();
                    }else{
                        $('#groupDescription').show();
                        $('#groupTime').show();
                        $('#timeRow').show();
                        $('#groupUnits').show();
                        $('#submitGroup').show();
                    }
                })
            </script>
            <?php
            break;
?>

<?php
}
?>


</body>

</html>

