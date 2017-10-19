<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="img/<?php echo $_SESSION['photo']; ?>" style="width: 160px;"/>
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"> <strong class="font-bold">Admin</strong></span>
                            <span class="text-muted text-xs block">Administrator <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="./index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-calendar"></i> <span class="nav-label">Venues</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="./editVenue.php">New Venue</a></li>
                    <li><a href="./view_venues.php">Venues</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-list-ul"></i> <span class="nav-label">Categories</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="./editCategory.php">New Category</a></li>
                    <li><a href="./view_categories.php">Categories</a></li>
                </ul>
            </li>
            <li>
                <a href="./view_users.php"><i class="fa fa-user"></i> <span class="nav-label">Users</span></a>
            </li>
            <li>
                <a href="./view_streams.php"><i class="fa fa-calendar"></i> <span class="nav-label">Live Streams</span></span></a>
            </li>
            <li>
                <a href="./settings.php"><i class="fa fa-th-large"></i> <span class="nav-label">Setting</span></a>
            </li>
            <hr style="border: 1px solid #509E95;margin: 0px;">

            <li>
                <a href="#"><i class="fa fa-repeat"></i> <span class="nav-label">Coming soon</span><span class="fa arrow"></span></a>
            </li>
        </ul>

    </div>
</nav>