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

                    if ($login_type != 'admin') {
                        $has_permi = false;
                    }

                ?>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- File export -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="mt-4">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="input-import-ptrips" class="form-control-file" id="input-import-ptrips" accept=".csv">
                                            <label class="custom-file-label" for="input-import-ptrips">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-ptrips" class="btn btn-info" type="button">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        // $has_permi = true;

                        // if ($login_type != 'admin') {
                        //     $has_permi = false;
                        // }

                        $d       = new Driver();
                        $l       = new Location();
                        $v       = new Vehicle();
                        $terminal = new Terminal();

                        $terms   = $terminal->getAllTerminal();
                        $dlist   = $d->getAllDrivers();
                        $loclist = $l->getAllLocation();
                        $vlist   = $v->getAllVehicles();

                        if ($login_type != 'admin') {
                            $dlist   = $d->getAllDriversByTermcode($login_termcode);
                            $loclist = $l->getAllLocationByTermcode($login_termcode);
                            $vlist   = $v->getAllVehiclesByTermcode($login_termcode);
                        }
                    ?>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-ptrips">Add New Trip</h4>
                                <form class="mt-4">
                                    <div class="form-group col-lg-6 ptrip-hidden">
                                        <input type="hidden" class="form-control" id="input-ptrips-id" name="input-ptrips-id" readonly>
                                    </div>
                                    <div class="form-group col-lg-6 ptrip-hidden">
                                        <input type="hidden" class="form-control" id="input-ptrips-termcode" name="input-ptrips-termcode" value="<?php echo $login_termcode; ?>" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" class="form-control" id="datepicker_ptrips" name="datepicker_ptrips" placeholder="Trip Date" readonly required>
                                        </div>
                                        <div class="form-group col-lg-6 d-none">
                                            <input type="text" value="0" class="form-control" id="timepicker_trips" name="timepicker_trips" placeholder="Time of Departure" readonly required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="ptripsdid" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                                <option value="null">Driver System ID</option>
                                                <?php foreach ($dlist as $key => $value) : ?>
                                                    <?php if (!empty($dlist[$key]['id'])) : ?>
                                                        <option value="<?php echo $dlist[$key]['id']; ?>"><?php echo $dlist[$key]['id'].' - '.$dlist[$key]['name']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" class="form-control" name="input-ptrips-dname" id="input-ptrips-dname" placeholder="Driver Name" readonly required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="ptripsvehic" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                                <option value="null">Plate No</option>
                                                <?php foreach ($vlist as $key => $value) : ?>
                                                    <?php if (!empty($vlist[$key]['plate_no'])) : ?>
                                                        <option value="<?php echo $vlist[$key]['id']; ?>"><?php echo $vlist[$key]['plate_no']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="ptripsorig" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                                <option value="null">Origin</option>
                                                <?php foreach ($loclist as $key => $value) : ?>
                                                    <?php if (!empty($loclist[$key]['loc_code'])) : ?>
                                                        <option value="<?php echo $loclist[$key]['loc_code']; ?>"><?php echo $loclist[$key]['loc_name']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="ptripsdest" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                                <option value="null">Destination</option>
                                                <?php foreach ($loclist as $key => $value) : ?>
                                                    <?php if (!empty($loclist[$key]['loc_code'])) : ?>
                                                        <option value="<?php echo $loclist[$key]['loc_code']; ?>"><?php echo $loclist[$key]['loc_name']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <textarea class="form-control" name="input-ptrips-compa" id="input-ptrips-compa" placeholder="Companion" required></textarea>
                                        </div>
                                    </div>
                                    
                                    <button id="btn-add-ptrips" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-ptrips" class="btn btn-danger">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Planned Trips</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="table-ptrips-wrapper" class="table-responsive">
                                    <!-- response here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Generate</h4>
                                <form class="mt-3" target="_blank" action="" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control <?php echo ($has_permi == true) ? 'col-6' : '' ?>" name="daterange_ptrip" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                        
                                        <select name="genptriptermcode" class="select2 form-control custom-select col-6 <?php echo ($has_permi == true) ? '' : 'd-none' ?>" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        
                                        <div class="input-group marginize">
                                            <button id="generate" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Trips</h4>

                                <?php
                                    // $f       = '02/13/2020';
                                    // $t       = '02/19/2020';
                                    // $ptrips  = new Ptrip();
                                    // $trips   = new Trip();
                                    // $rptrips = $ptrips->getPtripByDaterange($f, $t);

                                    // foreach ($rptrips as $key => $value) {
                                    //     $pid    = $rptrips[$key]['id'];
                                    //     $pdate  = $rptrips[$key]['dateptrips'];
                                    //     $ptime  = $rptrips[$key]['ptriptime'];
                                    //     $did    = $rptrips[$key]['ptripsdid'];
                                    //     $driver = $rptrips[$key]['ptripdname'];
                                    //     $plate  = $rptrips[$key]['ptripsvehic'];
                                    //     $porig  = $rptrips[$key]['ptripsorig'];
                                    //     $pdest  = $rptrips[$key]['ptripsdest'];

                                    //     echo $driver;
                                    //     $rtrips = $trips->getMatchingTrip($pdate, $did, $porig, $pdest);
                                        
                                    //     foreach ($rtrips as $key => $value) {
                                    //         $torig  = $rtrips[$key]['origin'];
                                    //         echo $torig;
                                    //     }
                                    // }
                                ?>
                                
                                <div id="gen-ptrips-container" class="row">
                                    <!-- code here -->
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