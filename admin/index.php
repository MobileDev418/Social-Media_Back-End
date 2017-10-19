<?php
include ("./header.php");
?>
<body>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<style>
    .t_b{font-weight : bold; }
</style>
<div id="wrapper">
    <?php require_once("./left_navigation.php"); ?>
    <?php
        $feature = dashboardInfo();
    ?>
    <div id="page-wrapper" class="gray-bg">
        <?php require_once("./top_navigation.php") ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2 style="font-weight: bold">Dashboard</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="./view_users.php"><span class="label label-success pull-right">View</span></a>
                        <h5>People</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h1 class="no-margins t_b"><?php echo $feature['count_users']?></h1>
                        <span>Total Active Users</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="./view_events.php"><span class="label label-info pull-right">View</span></a>
                        <h5>Streams</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h1 class="no-margins t_b"><?php echo $feature['count_streams']?></h1>
                        <span>Total Active Streams</span>
                    </div>
                </div>
            </div>
        </div>
        <?php include("./footer.php"); ?>

    </div>
</div>



<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- blueimp gallery -->
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>
    $(document).ready(function(){
        $(".gallery_photo").mouseover(function(){
            var id = $(this).attr("id");
            var new_id = id.replace("photo_","");
            $("#close_"+new_id).fadeIn();
        });
        $(".gallery_photo").mouseout(function(){
            var id = $(this).attr("id");
            var new_id = id.replace("photo_","");
            $("#close_"+new_id).fadeOut();
        });

    });
</script>
</body>

</html>
