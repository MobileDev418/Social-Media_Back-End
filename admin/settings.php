<?php
include ("./header.php");
?>
<body>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<div id="wrapper">
    <?php require_once("./left_navigation.php"); ?>
    <script src="js/jquery-10.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="js/locationpicker.jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/plugins/chosen/chosen.css" />

    <div id="page-wrapper" class="gray-bg">
        <?php require_once("./top_navigation.php") ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h4>Setting</h4>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="./action.php" class="form-horizontal" onsubmit="return validate();">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">User Name</label>
                                    <div class="col-sm-6"><input name="userName" type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" ></div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Password</label>
                                    <div class="col-sm-6">
                                        <input name="password" type="text" class="form-control" value="<?php echo $_SESSION['password']; ?>" readonly>
                                    </div>
                                    <div class="col-sm-3"><a class="btn btn-primary" id="btn_change" type="">Change Password</a></div>
                                </div>
                                <div class="change-password" style="display: none">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">New Password</label>
                                        <div class="col-sm-6">
                                            <input id="newPassword" name="newPassword" type="text" class="form-control" value="" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6"><button class="btn btn-primary" id="save" type="submit"><i class="fa fa-check"></i>&nbsp;Save</button></div>
                                </div>
                                <input type="hidden" name="key" value="editSetting" />
                                <input type="hidden" id="changePassword" name="changePassword" value="0" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("./footer.php"); ?>

    </div>
</div>
<!-- Mainly scripts -->

<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>

<!-- blueimp gallery -->
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>
    function validate(){
        if($("#changePassword").val() == 1){
            if($("#newPassword").val() == ""){
                alert("Please input new password");
                $("#newPassword").focus();
                return false;
            }
        }else{
            return true;
        }
    }
    $(document).ready(function(){
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        $("#btn_change").click(function(){
            if($("#changePassword").val() == 0){
                $(".change-password").css("display","block");
                $("#changePassword").val(1);
            }else{
                $(".change-password").css("display","none");
            }
        });
    });

</script>
</body>

</html>
