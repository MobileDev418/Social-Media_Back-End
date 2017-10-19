<?php
include ("./header.php");
?>
<body>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<div id="wrapper">
    <?php require_once("./left_navigation.php"); ?>
    <?php
    $vid = 0;
    if(isset($_REQUEST['vid']) && $_REQUEST['vid'] > 0 ){
        $vid = $_REQUEST['vid'];
    }
    $new_venue = getVenue($vid);
    extract($new_venue);
    ?>
    <script src="js/jquery-10.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="js/locationpicker.jquery.min.js"></script>

    <div id="page-wrapper" class="gray-bg">
        <?php require_once("./top_navigation.php") ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h4><?php echo $id > 0 ? "Edit" : "New"; ?> Venue </h4>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="./action.php" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Logo Image</label>
                                    <div class="col-sm-6">
                                        <?php if($id > 0){ ?>
                                            <div class="col-sm-12"><img src="../images/venues/<?php echo $logo; ?>" style="width: 200px;margin-left: auto;margin-right: auto;display: block;padding: 10px;"></div>
                                        <?php } ?>
                                        <div class="col-sm-12"><input type="file" name="image" accept="image/*" /></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Venue Name</label>
                                    <div class="col-sm-6"><input name="venueName" type="text" class="form-control" value="<?php echo $venueName; ?>" ></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Address</label>
                                    <div class="col-sm-6"><input name="address" type="text" class="form-control" id="us3-address" value="<?php echo $address; ?>"  autocomplete="off"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <div class="col-sm-6" style="visibility: hidden"><input type="text" class="form-control" id="us3-radius"/></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="us3" style="width: 500px; height: 400px;"></div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix"></div>
                                        <div class="m-t-small" style="width: 100%;">
                                            <label class="p-r-small col-sm-1 control-label">Lat.:</label>

                                            <div class="col-sm-4"><input name="latitude" type="text" class="form-control" style="width: 150px" id="us3-lat" value="<?php echo $lat; ?>"/></div>
                                            <label class="p-r-small col-sm-1 control-label">Long.:</label>

                                            <div class="col-sm-4"><input name="longitude" type="text" class="form-control" style="width: 150px" id="us3-lon" value="<?php echo $lot; ?>"/></div>
                                        </div>
                                        <script>
                                            var lat = <?php echo $lat; ?>;
                                            var long = <?php echo $lot;?>;
                                            if(lat == 0) lat = 0;
                                            if(long == 0) long = 0;

                                            $('#us3').locationpicker({
                                                location: {latitude: lat, longitude: long},
                                                radius: 300,
                                                inputBinding: {
                                                    latitudeInput: $('#us3-lat'),
                                                    longitudeInput: $('#us3-lon'),
                                                    radiusInput: $('#us3-radius'),
                                                    locationNameInput: $('#us3-address')
                                                },
                                                enableAutocomplete: true,
                                                onchanged: function (currentLocation, radius, isMarkerDropped) {
                                                    //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-6"><button class="btn btn-primary" id="save" type="reset"><i class="fa fa-check"></i>&nbsp;Save</button></div>
                                </div>
                                <input type="hidden" name="vid" value="<?php echo $id; ?>" />
                                <input type="hidden" name="key" value="editVenue" />
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
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- blueimp gallery -->
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#save").click(function(){
            $("form").submit();
        });
    });
</script>
</body>

</html>
