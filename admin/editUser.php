<?php
include ("./header.php");
?>
<body>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<div id="wrapper">
    <?php require_once("./left_navigation.php"); ?>

    <div id="page-wrapper" class="gray-bg">
        <?php require_once("./top_navigation.php") ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2 style="font-weight: bold">User Dashboard</h2>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h4>User Info</h4>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <?php
                                $uid = 0;
                                if(isset($_REQUEST['uid']) && $_REQUEST['uid'] > 0 ){
                                    $uid = $_REQUEST['uid'];
                                }else{
                                    redirect_url('./index.php');
                                }
                                $data = getUser($uid);
                                extract($data);
                            ?>
                            <form method="get" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Avatar</label>
                                    <div class="col-sm-6">
                                        <img src="../images/photo/<?php echo $photo_url; ?>" class="form-control" style="width: 70px;height: 70px;padding: 0px; border-radius: 50%;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Firstname</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $firstname; ?>" readonly></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Lastname</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $lastname; ?>" readonly></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Username</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $username; ?>" readonly></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $email; ?> " readonly></div>
                                </div><div class="form-group">
                                    <label class="col-sm-4 control-label">Gender</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $GENDER[$gender]; ?>" readonly></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Birthday</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $birthday; ?> " readonly></div>
                                </div><div class="form-group">
                                    <label class="col-sm-4 control-label">Interested In</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" value="<?php echo $GENDER[$gender]; ?>" readonly></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 150px;">
                <?php
                $uid = 0;
                if(isset($_REQUEST['uid']) && $_REQUEST['uid'] > 0 ){
                    $uid = $_REQUEST['uid'];
                }else{
                    redirect_url('./index.php');
                }
                $photos = getUserPhotos($uid);
                ?>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h4>User Photos</h4>
                        </div>
                        <div class="ibox-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($photos as $photo){
                                        echo '<tr>
                                                <td><img src="../images/photo/'.$photo['photo_url'] .'" class="form-control" style="width: 70px;height: 70px;padding : 0px;"></td>
                                                <td>';
                                        if($photo['is_avatar'] == 0){
                                            echo '<a href="./action.php?key=delPhoto&uid='.$uid.'&pid='.$photo['id'].'" class="btn" rel="tooltip" title="Delete"><i class="fa fa-trash-o" style="font-size: 40px;"></i></a>';
                                        }
                                        echo '</td></tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Gallery</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="carousel slide" id="carousel1">
                                <div class="carousel-inner">
                                    <?php
                                    $count = 0;
                                    foreach($photos as $photo){
                                        if($count == 0){
                                            echo '<div class="item active">
                                                <img alt="image" class="img-responsive" src="../images/photo/'.$photo['photo_url'].'" style="height: 300px;display: block;margin-left: auto;margin-right: auto;">
                                            </div>';
                                        }else{
                                            echo '<div class="item">
                                                <img alt="image" class="img-responsive" src="../images/photo/'.$photo['photo_url'].'" style="height: 300px;display: block;margin-left: auto;margin-right: auto;">
                                            </div>';
                                        }
                                        $count ++;
                                    }
                                    ?>

                                </div>
                                <a data-slide="prev" href="#carousel1" class="left carousel-control">
                                    <span class="icon-prev"></span>
                                </a>
                                <a data-slide="next" href="#carousel1" class="right carousel-control">
                                    <span class="icon-next"></span>
                                </a>
                            </div>
                        </div>
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
