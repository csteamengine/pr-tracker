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

if($action == 'getCategories'){
    $sql = "SELECT categoryTitle FROM category WHERE categoryTitle LIKE '%".get_value('value')."%'";
    $query = mysqli_query($conn, $sql);

    $json = array();

    while($result = mysqli_fetch_assoc($query)){
        array_push($json, $result['categoryTitle']);
    }
    echo json_encode($json);
    exit;
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
        <div class="container">
            <?php
            switch ($action) {
                case "":
                    header("location: index.php");
                    break;
                case "addActivity":
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add Activity</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="addInfo.php?action=submit" method="post" id="editForm">
                                <div class="form-group">
                                    <label>Category</label>
                                    <?php
                                    $categorySQL = "SELECT categoryTitle FROM category";
                                    $categoryQuery = mysqli_query($conn, $categorySQL);
                                    ?>

                                    <select id="categorySelect" class="form-control" required>
                                        <option value="" >Select A Category...</option>
                                        <?php
                                        while($result = mysqli_fetch_assoc($categoryQuery)){
                                            ?>
                                                <option value="<?= $result['categoryTitle'] ?>" ><?= $result['categoryTitle'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Activity Title</label>
                                    <input class="form-control" id="activity" type="text" placeholder="Activity Title">
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    break;
                case "addRecord":
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add Record</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="addInfo.php?action=submit" method="post" id="editForm">
                                <div class="form-group">
                                    <label>Category</label>
                                    <?php
                                    $categorySQL = "SELECT categoryTitle FROM category";
                                    $categoryQuery = mysqli_query($conn, $categorySQL);
                                    ?>

                                    <select id="categorySelect" class="form-control" required>
                                        <option value="" >Select A Category...</option>
                                        <?php
                                        while($result = mysqli_fetch_assoc($categoryQuery)){
                                            ?>
                                            <option value="<?= $result['categoryTitle'] ?>" ><?= $result['categoryTitle'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    break;
                case "addGoal":
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Add Goal</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="addInfo.php?action=submit" method="post" id="editForm">
                                <div class="form-group">
                                    <label>Category</label>
                                    <?php
                                    $categorySQL = "SELECT categoryTitle FROM category";
                                    $categoryQuery = mysqli_query($conn, $categorySQL);
                                    ?>

                                    <select id="categorySelect" class="form-control" required>
                                        <option value="" >Select A Category...</option>
                                        <?php
                                        while($result = mysqli_fetch_assoc($categoryQuery)){
                                            ?>
                                            <option value="<?= $result['categoryTitle'] ?>" ><?= $result['categoryTitle'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    break;
            }
            ?>
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src = "https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<link href="http://jquery-ui-bootstrap.github.io/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>


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

</body>

</html>

