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
                <div class="row" style="display: none;">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="mt-4">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="input-import-terminal" class="form-control-file" id="input-import-terminal" accept=".xls,.xlsx">
                                            <label class="custom-file-label" for="input-import-terminal">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-terminal" class="btn btn-info" type="button">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                
                $has_permi = true;

                if ($login_type != 'admin' || $login_uname == 'metro_audit') {
                    $has_permi = false;
                }

                ?>

                <div class="row">
                    <div class="<?php echo ($has_permi == true) ? 'col-lg-8' : 'col-lg-12' ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Terminal</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div class="table-responsive">
                                    <table id="table-terminal" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Terminal Code</th>
                                                <th>Department Name</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($result)) : ?>
                                            <?php foreach ($result as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $result[$k]['id']; ?></td>
                                                <td class="term-code"><?php echo $result[$k]['term_code']; ?></td>
                                                <td class="term-name"><?php echo $result[$k]['term_name']; ?></td>
                                                <td>
                                                    <?php if ($has_permi == true) : ?>
                                                    <button id="btn-edit-terminal" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id'] ?>"><i class="mdi mdi-border-color"></i></button>
                                                    <button id="btn-del-terminal" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id'] ?>"><i class="mdi mdi-window-close"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($has_permi == true) : ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-terminal">Add New Terminal</h4>
                                <form class="mt-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-terminal-id">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="input-terminal-code" id="input-terminal-code" placeholder="Terminal Code" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="input-terminal-name" id="input-terminal-name" placeholder="Department Name" required>
                                    </div>
                                    <button id="btn-add-terminal" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-terminal" class="btn btn-danger">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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