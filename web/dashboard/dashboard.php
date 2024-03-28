<?php include_once('inc/head.php'); ?>
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
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <canvas id="chart-time"></canvas>
                                <h5 class="chart-label-time"></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <canvas id="chart-km"></canvas>
                                <h5 class="chart-label-km"></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h5 class="card-title">Total SMS</h5>
                                <ul class="list-inline two-part">
                                    <li>
                                        <div id="sparklinedash"></div>
                                    </li>
                                    <li class="text-right"><i class="ti-arrow-up text-success"></i> <span id="total-sms" class="counter text-success">0</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h5 class="card-title">Bounce Rate</h5>
                                <ul class="list-inline two-part">
                                    <li>
                                        <div id="sparklinedash4"></div>
                                    </li>
                                    <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span id="total-bounce" class="text-danger">0%</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h5 class="card-title">Total Vehicles</h5>
                                <ul class="list-inline two-part">
                                    <li class="text-right"><i class="mdi mdi-bus" style="color: #fb987a;"></i> <span id="dash-total-vehicle" class="counter" style="font-weight: 700; color: #fb987a;">0</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h5 class="card-title">Total Drivers</h5>
                                <ul class="list-inline two-part">
                                    <li class="text-right"><i class="mdi mdi-account text-primary"></i> <span id="dash-total-driver" class="counter text-primary" style="font-weight: 700;">0</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h5 class="card-title">Total Locations</h5>
                                <ul class="list-inline two-part">
                                    <li class="text-right"><i class="mdi mdi-map-marker text-info"></i> <span id="dash-total-location" class="text-info" style="font-weight: 700;">0</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h4 class="card-title" style="color: #2962FF">Total VDL per department</h4>
                                <p><b>Total Registered Vehicles, Drivers & Locations per department.</b></p>
                                <div id="wrapper-table-rvpd" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body analytics-info">
                                <h4 class="card-title" style="color: #2962FF">Yesterday Trips & Errors</h4>
                                <p><b>Number of trips & errors recorded from yesterday.</b></p>
                                <div id="wrapper-table-dtel" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="color: #2962FF">Highest KM Run</h4>
                                <p><b>list of 20 highest KM Run.</b></p>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-hkmrun" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="color: #2962FF">Longest Travel Duration</h4>
                                <p><b>list of 20 longest travel duration.</b></p>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-ltime" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="color: #2962FF">Total Trip per driver</h4>
                                <p><b>Total trip of drivers from the start of using the application.</b></p>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-tpd" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- activity log -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="color: #2962FF">Activity Logs</h4>
                                <p><b>Record of user's activities in the system.</b></p>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-actlogs" class="table-responsive">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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