<?php include_once('inc/head.php'); ?>

<?php
function outputTermName($tcode) {
    $terminal = new Terminal;
    $terms = $terminal->getTermNameByCode($tcode);
    $tname = $terms[0]['term_name'];

    return $tname;
}
?>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include_once('inc/topbar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once('inc/sidebar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
        <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- File export -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Trip Tickets</h4>
                                <form class="mt-3">
                                    <div class="input-group mb-3">           
                                        <select id="filtertrip" name="filtertrip" class="select2 form-control custom-select col-2" style="width: 100%; height:36px;">
                                            <option value="today">Today</option>
                                            <option value="all">All</option>
                                        </select>
                                    </div>
                                </form>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-trips" class="table-responsive">

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="modal-trip-remark" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Remarks</label>
                                        <input type="hidden" id="input-trip-id">
                                        <textarea class="form-control" id="input-trip-remark"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button id="btn-modal-remark" type="button" class="btn btn-danger waves-effect waves-light">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SMS Received</h4>
                                <form class="mt-3">
                                    <div class="input-group mb-3">           
                                        <select id="filtersms" name="filtersms" class="select2 form-control custom-select col-2" style="width: 100%; height:36px;">
                                            <option value="today">Today</option>
                                            <option value="all">All</option>
                                        </select>
                                    </div>
                                </form>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-sms" class="table-responsive">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->
    <?php //include_once('inc/customizer.php'); ?>

<?php include_once('inc/footer.php'); ?>