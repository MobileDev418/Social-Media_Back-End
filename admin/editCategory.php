<?php
include ("./header.php");
?>
<body>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<div id="wrapper">
    <?php require_once("./left_navigation.php"); ?>
    <?php
    $cid = 0;
    if(isset($_REQUEST['cid']) && $_REQUEST['cid'] > 0 ){
        $cid = $_REQUEST['cid'];
    }
    $data = getCategory($cid);
    extract($data);
    ?>
    <script src="js/jquery-10.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/plugins/chosen/chosen.css" />

    <!--    <script src="js/plugins/timepicker/lib/pikaday.js"></script>-->
    <!--    <link rel="stylesheet" type="text/css" href="js/plugins/timepicker/lib/pikaday.css" />-->

    <div id="page-wrapper" class="gray-bg">
        <?php require_once("./top_navigation.php") ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h4><?php echo $id > 0 ? "Edit" : "New"; ?> Category</h4>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="./action.php" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Icon</label>
                                    <div class="col-sm-6">
                                        <?php if($id > 0){ ?>
                                            <div class="col-sm-12"><img src="../images/category/<?php echo $icon; ?>" style="width: 200px;margin-left: auto;margin-right: auto;display: block;padding: 10px;"></div>
                                        <?php } ?>
                                        <div class="col-sm-12"><input type="file" name="icon" accept="image/*" /></div>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Background Image</label>
                                    <div class="col-sm-6">
                                        <?php if($id > 0){ ?>
                                            <div class="col-sm-12"><img src="../images/category/<?php echo $image; ?>" style="width: 200px;margin-left: auto;margin-right: auto;display: block;padding: 10px;"></div>
                                        <?php } ?>
                                        <div class="col-sm-12"><input type="file" name="image" accept="image/*" /></div>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Category Name</label>
                                    <div class="col-sm-6"><input name="catName" type="text" class="form-control" value="<?php echo $catName; ?>" ></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <textarea name="descr" type="text" class="form-control"><?php echo $descr; ?></textarea>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6"><button class="btn btn-primary " type="submit"><i class="fa fa-check"></i>&nbsp;Save</button></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <input type="hidden" name="cid" value="<?php echo $id; ?>" />
                                <input type="hidden" name="key" value="editCategory" />
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
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>

<!-- blueimp gallery -->
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>
    $(document).ready(function(){

    });
</script>
</body>

</html>
