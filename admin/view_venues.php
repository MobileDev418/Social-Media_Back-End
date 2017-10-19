<?php
include ("./header.php");
?>
<body>

<div id="wrapper">
<?php require_once("./left_navigation.php"); ?>
    <div id="page-wrapper" class="gray-bg">
<?php require_once("./top_navigation.php") ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2 style="font-weight: bold">Venue List</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <button id="new" style="float: right;margin-bottom: 20px;" type="button" class="btn btn-w-m btn-primary">New Venue</button>
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <?php $venues = adminGetVenues(); ?>
                        <table class="table table-striped table-bordered table-hover " id="editable" >
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Venue Name</th>
                                    <th>Address</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($venues as $row){
                                    extract($row);
                                    echo '<tr class="gradeU">';
                                    echo '<th><div style="width:80px;height:60px;">
                                            <img src="../images/venues/'.$logo.'" style="max-width:100%;max-height:100%;"></div>
                                            </th>';
                                    echo "<td>$venueName</td>";
                                    echo "<td>$address</td>";
                                    echo "<td>$lot</td>";
                                    echo "<td>$lat</td>";
                                    echo '<td>
                                            <a href="./editVenue.php?key=edit&vid='.$id.'" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="./action.php?key=delVenue&vid='.$id.'" class="btn" rel="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                                          </td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Logo</th>
                                    <th>Venue Name</th>
                                    <th>Address</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

            /* Init DataTables */
            var oTable = $('#editable').dataTable();
            $("#new").click(function(){
                document.location.href = "./editVenue.php";
            });
        });

    </script>
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
</body>

</html>
