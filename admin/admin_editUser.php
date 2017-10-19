<?php

require_once("./function.php");

check_user();
include ("header.php");
?>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">

<?php
include ("top-navigation.php");
?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <?php require_once("left-navigation.php"); ?>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
    <?php
    $action = "new";
    $user_id = 0;
    if(isset($_REQUEST['key'])){
        $action = $_REQUEST['key'];
        $user_id = $_REQUEST['uid'];
    }
    $user = getUser($user_id);
    extract($user);
    if($photo != "") $photo = SAVE_USER_PHOTO.$photo;
    ?>
	<div class="page-content-wrapper">
<!--        donjin-->
        <div id="main" class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="fa fa-th-list"></i><span style="text-transform: uppercase;"><?php echo $action;?> User</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form action="./action.php" method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered'>
                                <?php if(isset($_REQUEST['err'])){
                                    if($_REQUEST['err'] == 'error1'){
                                        $message = "Invalid input value";
                                    }elseif($_REQUEST['err'] == 'error2'){
                                        $message = "Sql error.";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="fullname" class="control-label col-sm-2 "><span style="color: red;">Alert: </span> </label>
                                        <div class="col-sm-10">
                                            <span style="color: red;"><?php  echo $message; ?></span>
                                        </div>
                                    </div>

                                    <?php

                                }
                                ?>
                                <div class="form-group">
                                    <label for="fullname" class="control-label col-sm-2">Full name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="fullname" id="fullname" placeholder="fullname" class="form-control" value="<?php  echo $fullname; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="control-label col-sm-2">User name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" id="username" placeholder="User name" class="form-control" value="<?php  echo $username; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label col-sm-2">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="control-label col-sm-2">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="new_password" id="new_password" placeholder="New password" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photo" class="control-label col-sm-2">Photo</label>
                                    <div class="col-sm-10">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                            <div class=" thumbnail"  style="width: 200px; height: 150px;">
                                                <img src="<?php echo $photo; ?>" style="width: 200px; height: 150px;">
                                            </div>
                                            <div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="photo">
													</span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="is_admin" class="control-label col-sm-2">Permission</label>
                                    <div class="col-sm-10">
                                        <select name="is_admin" id="is_admin" rows="5" class="form-control">
                                            <?php
                                            foreach($permission as $key=>$value){
                                                if($is_admin == $key) echo "<option value='".$key."' selected>$value</option>";
                                                else{echo "<option value='".$key."' >$value</option>"; }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-actions col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn">Cancel</button>
                                    <input type="hidden" name="key" value="user" />
                                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<!--donjin end-->
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2015 &copy; Indyhost.net Develop Team.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!--<script src="../assets/admin/pages/scripts/table-advanced.js"></script>-->
<script src="../assets/admin/pages/scripts/index3.js" type="text/javascript"></script>
<script src="../assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>

jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Demo.init(); // init demo features
//    TableAdvanced.init();
});
</script>

<!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>