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

                    // echo $gettermcode;

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
                                            <input type="file" name="input-import-vehicle" class="form-control-file" id="input-import-vehicle" accept=".csv">
                                            <label class="custom-file-label" for="input-import-vehicle">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-vehicle" class="btn btn-info" type="button">Import</button>
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
                                <h4 class="card-title">Vehicles</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div class="table-responsive">
                                    <table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Plate No</th>
                                                <!-- <th>Capacity</th>
                                                <th>Department</th> -->
                                                <th>Location Code</th>
                                                <th>Current Location</th>
                                                <th>Terminal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($result)) : ?>
                                            <?php foreach ($result as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $result[$k]['id']; ?></td>
                                                <td class="plate"><?php echo $result[$k]['plate_no']; ?></td>
                                                <!-- <td><?php //echo $result[$k]['capacity']; ?></td>
                                                <td><?php //echo $result[$k]['department']; ?></td> -->
                                                <td class="loc-code"><?php echo $result[$k]['loc_code']; ?></td>
                                                <td class="loc-name"><?php echo $result[$k]['loc_name']; ?></td>
                                                <td class="term-code"><?php echo $result[$k]['term_code']; ?></td>
                                                <td>
                                                    <?php if ($has_permi == true) : ?>
                                                    <button id="btn-edit-vehicle" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id'] ?>"><i class="mdi mdi-border-color"></i></button>
                                                    <button id="btn-del-vehicle" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id'] ?>"><i class="mdi mdi-window-close"></i></button>
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
                        $loc = new Location();
                        $llist = $loc->getAllLocation();

                        $terminal = new Terminal();
                        $terms = $terminal->getAllTerminal();
                    ?>

                    <?php if ($has_permi == true) : ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-vehicle">Add New Vehicle</h4>
                                <form class="mt-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-vehicle-id">
                                    </div>
                                    <div class="form-group">
                                        <select name="input-vehicle-termcode" id="input-vehicle-termcode" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Department</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-vehicle-plate" placeholder="Plate No" required>
                                    </div>
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" id="input-vehicle-code" placeholder="Location Code" required>
                                    </div> -->
                                    <div class="form-group">
                                        <select name="input-vehicle-code" id="input-vehicle-code" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Location Code</option>
                                            <?php foreach ($llist as $key => $value) : ?>
                                                <?php if (!empty($llist[$key]['loc_code'])) : ?>
                                                    <option value="<?php echo $llist[$key]['loc_code']; ?>"><?php echo $llist[$key]['loc_code']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="input-vehicle-name" id="input-vehicle-name" placeholder="Location Name" readonly required>
                                    </div>
                                    <button id="btn-add-vehicle" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-vehicle" class="btn btn-danger">Clear</button>
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