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
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- File export -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Contacts</h4>
                                <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6>
                                <div class="table-responsive">
                                    <table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Driver'Name</th>
                                                <th>Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($result)) : ?>
                                            <?php foreach ($result as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $result[$k]['id'] ?></td>
                                                <td><?php echo $result[$k]['driver_name'] ?></td>
                                                <td><?php echo $result[$k]['number'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
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
    <?php include_once('inc/customizer.php'); ?>

<?php include_once('inc/footer.php'); ?>