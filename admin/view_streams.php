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
            <h2 style="font-weight: bold">Stream List</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <?php $streams = adminGetStreams(); ?>
                        <table class="table table-striped table-bordered table-hover " id="editable" >
                            <thead>
                                <tr>
                                    <th>Created</th>
                                    <th>Username</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Reported</th>
                                    <th>Blocked</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($streams as $row){
                                    extract($row);
                                    echo '<tr class="gradeU">';
                                    echo "<td>".date("m-d-Y h:i A",$created)."</td>";
                                    echo "<td>$userName</td>";
                                    echo "<td>$title</td>";
                                    echo "<td>$description</td>";
                                    echo "<td>$reported</td>";
                                    echo "<td>$blocked</td>";

                                    if($state == 0){
                                        echo "<td>Deactivate</td>";
                                        echo '<td>
                                            <a href="./action.php?key=activeStream&sid='.$id.'" class="btn" rel="tooltip" title="Activate"><i class="fa fa-refresh"></i></a>
                                            <a href="./action.php?key=delStream&sid='.$id.'" class="btn" rel="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                                          </td>';
                                    }else{
                                        echo "<td>Active</td>";
                                        echo '<td>
                                            <a href="./action.php?key=deActiveStream&sid='.$id.'" class="btn" rel="tooltip" title="Deactivate"><i class="fa fa-arrow-circle-o-down"></i></a>
                                            <a href="./action.php?key=delStream&sid='.$id.'" class="btn" rel="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                                          </td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Created</th>
                                    <th>Username</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Reported</th>
                                    <th>Blocked</th>
                                    <th>Status</th>
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
