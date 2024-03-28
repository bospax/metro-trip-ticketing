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
                <?php
                
                    $has_permi = true;

                    if ($login_type != 'admin' || $login_uname == 'metro_audit') {
                        $has_permi = false;
                    }

                ?>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- File export -->
                <div class="row <?php echo ($has_permi == true) ? '' : 'd-none' ?>">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="mt-4">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="input-import-driver" class="form-control-file" id="input-import-driver" accept=".csv">
                                            <label class="custom-file-label" for="input-import-driver">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-driver" class="btn btn-info" type="button">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="<?php echo ($has_permi == true) ? 'col-lg-8' : 'col-lg-12' ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Drivers</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="table-drivers" class="table-responsive">
                                <table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>System ID</th>
                                            <th>Driver's Name</th>
                                            <th>Employee ID</th>
                                            <th>Number</th>
                                            <th style="display: none;">Loc Code</th>
                                            <th style="display: none;">Location</th>
                                            <th>Terminal</th>
                                            <th style="display: none;">Dept Code</th>
                                            <th>Dept Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($result)) : ?>
                                        <?php foreach ($result as $k => $v) : ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $result[$k]['id']; ?></td>
                                            <td class="dname"><?php echo $result[$k]['name']; ?></td>
                                            <td class="dempid"><?php echo $result[$k]['emp_id']; ?></td>
                                            <td class="dnum"><?php echo $result[$k]['number']; ?></td>
                                            <td style="display: none;" class="lcode"><?php echo $result[$k]['lcode']; ?></td>
                                            <td style="display: none;" class="lname"><?php echo $result[$k]['lname']; ?></td>
                                            <td class="term"><?php echo $result[$k]['term']; ?></td>
                                            <td style="display: none;" class="deptcode"><?php echo $result[$k]['deptcode']; ?></td>
                                            <td class="deptname"><?php echo $result[$k]['deptname']; ?></td>
                                            <td>
                                                <?php if ($has_permi == true) : ?>
                                                <button id="btn-edit-driver" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-border-color"></i></button>
                                                <button id="btn-del-driver" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-window-close"></i></button>
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

                    <?php 
                        if ($has_permi == true) : 
                        
                        $terminal = new Terminal();
                        $terms = $terminal->getAllTerminal();

                        // var_dump($terms);
                    ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-driver">Add New Driver</h4>
                                <form class="mt-4">
                                    <div class="form-group">
                                        <select name="input-driver-term" id="input-driver-term" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_code'].' - '.$terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-driver-id">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-driver-empid" placeholder="Employee ID *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-driver-name" placeholder="Employee Name *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-driver-number" placeholder="Mobile Number (Add prefix : 63) *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-driver-lcode" placeholder="Loc Code">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-driver-lname" placeholder="Location">
                                    </div>
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" id="input-driver-term" placeholder="Terminal">
                                    </div> -->
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-driver-deptcode" placeholder="Dept Code">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="input-driver-deptname" id="input-driver-deptname" placeholder="Dept Name" readonly style="background-color: #fff">
                                    </div>
                                    <button id="btn-add-driver" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-driver" class="btn btn-danger">Clear</button>
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