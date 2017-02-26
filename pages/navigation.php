<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 2/25/17
 * Time: 2:16 PM
 */
?>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle navbar-inverse" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Room For ImPRovement</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="login.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li>
                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="events.php"><i class="fa fa-bar-chart-o fa-fw"></i> Your Events</a>
                </li>
                <li>
                    <a href="records.php"><i class="fa fa-clock-o fa-fw"></i>Personal Records</a>
                </li>
                <li>
                    <a href="goals.php"><i class="fa fa-crosshairs fa-fw"></i>Personal Goals</a>
                </li>
                <li>
                    <a href="friends.php"><i class="fa fa-group fa-fw"></i>Friends</a>
                </li>
                <li>
                    <a href="messages.php"><i class="fa fa-comments fa-fw"></i>Messages</a>
                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
