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

        <?php

        $has_permi = true;

        if ($login_type != 'admin') {
            $has_permi = false;
        }

        $terminal = new Terminal();
        $terms = $terminal->getAllTerminal();

        ?>

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
                                <h4 class="card-title">Generate Trip Ticket Report</h4>
                                <form class="mt-3" target="_blank" action="../web/reports/generate.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control <?php echo ($has_permi == true) ? 'col-6' : '' ?>" name="daterange_trip" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                        
                                        <select name="gentriptermcode" class="select2 form-control custom-select col-6 <?php echo ($has_permi == true) ? '' : 'd-none' ?>" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="input-group marginize">
                                            <button id="generate" class="btn btn-primary" >Generate</button>
                                            <button id="print" class="btn btn-info" type="submit" style="display: none;">Print</button>
                                            <button id="export" class="btn btn-success btn-hidden" style="display: none;">Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Trip Tickets</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-trips" class="table-responsive">
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
                                <h4 class="card-title">Generate Error Log Report</h4>
                                <form class="mt-3" target="_blank" action="../web/reports/generate_er.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control <?php echo ($has_permi == true) ? 'col-6' : '' ?>" name="daterange_er" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                        
                                        <select name="genertermcode" class="select2 form-control custom-select col-6 <?php echo ($has_permi == true) ? '' : 'd-none' ?>" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        
                                        <div class="input-group marginize">
                                            <button id="generate-er" class="btn btn-primary">Generate</button>
                                            <button id="print-er" class="btn btn-info" type="submit" style="display: none;">Print</button>
                                            <button id="export-er" class="btn btn-success btn-hidden" style="display: none;">Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Error Logs</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-bounce" class="table-responsive">
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
                                <h4 class="card-title">Generate Man Hour Report</h4>
                                <form class="mt-3" target="_blank" action="../web/reports/generate_mp.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control <?php echo ($has_permi == true) ? 'col-6' : '' ?>" name="daterange_mp" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                        
                                        <select name="genmptermcode" class="select2 form-control custom-select col-6 <?php echo ($has_permi == true) ? '' : 'd-none' ?>" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        
                                        <div class="input-group marginize">
                                            <button id="generate-mp" class="btn btn-primary" >Generate</button>
                                            <button id="print-mp" class="btn btn-info" type="submit" style="display: none;">Print</button>
                                            <button id="export-mp" class="btn btn-success">Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Man Hour</h4> -->
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <!-- <div id="wrapper-table-mp" class="table-responsive">
                                    <table id="table-mp" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Drivers Name</th>
                                                <th>Total Time</th>
                                            </tr>
                                        </thead>
                                        <tbody> -->
                                        <?php //if (!empty($result_mp)) : ?>
                                            <?php //foreach ($result_mp as $k => $v) : ?>
                                            <!-- <tr>
                                                <td></td>
                                                <td><?php //echo $result_mp[$k]['date']; ?></td>
                                                <td><?php //echo $result_mp[$k]['driver_name']; ?></td>

                                                <?php
                                                //$raw = $result_mp[$k]['SUM(raw_time)'];
                                                //$total_time = convertToHoursMins($raw, '%02d h %02d min');
                                                ?>
                                                
                                                <td><?php //echo $total_time; ?></td>
                                            </tr> -->
                                            <?php //endforeach; ?>
                                        <?php //endif; ?>
                                        <!-- </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Man Hours</h4>

                                <?php
                                    // $f = '12/17/2019';
                                    // $t = '12/17/2019';
                                    // $drivers = [];

                                    // $trip = new Trip();
                                    // $results = $trip->getTripRange($f, $t);   
                                    
                                    // foreach ($results as $k => $value) {
                                    //     $driver_id = $results[$k]['driver_id'];
                                        
                                    //     if (!in_array($driver_id, $drivers)) {
                                    //         $drivers[] = $driver_id;
                                    //     }
                                    // }

                                    // for ($i = 0; $i < count($drivers); $i++) { 
                                    //     $driver_id = $drivers[$i];
                                    //     $driver = new Driver();
                                    //     $results_driver = $driver->getDriver($driver_id);
                                    //     $results = $trip->getTripIndividual($driver_id, $f, $t);
                                    //     foreach ($results as $k => $value) {
                                    //         var_dump($results[$k]['driver_name']);
                                    //     }
                                    // }
                                ?>
                                
                                <div id="manhour-container" class="row">
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
                                <h4 class="card-title">Generate Idle Driver Report</h4>
                                <form class="mt-3" target="_blank" action="../web/reports/generate_idl.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control <?php echo ($has_permi == true) ? 'col-6' : '' ?>" name="daterange_idl" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                       
                                        <select name="genidltermcode" class="select2 form-control custom-select col-6 <?php echo ($has_permi == true) ? '' : 'd-none' ?>" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="input-group marginize">
                                            <button id="generate-idl" class="btn btn-primary" >Generate</button>
                                            <button id="print-idl" class="btn btn-info" type="submit" style="display: none;">Print</button>
                                            <button id="export-idl" class="btn btn-success">Export</button>
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
                                <h4 class="card-title">Idle Drivers</h4>
                                <div id="idle-container" class="row">
                                    <!-- code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    $d = new Driver();
                    $dlist = $d->getAllDrivers();

                    if ($login_type != 'admin') {
                        $dlist = $d->getAllDriversByTermcode($login_termcode);
                    }
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Generate Employee Attendance</h4>
                                <form class="mt-3" target="_blank" action="../web/reports/generate_att.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control col-6" name="daterange_att" value="" placeholder="" aria-label="" aria-describedby="basic-addon1"/>
                                        <select name="empname" class="select2 form-control custom-select col-6" style="width: 100%; height:36px;">
                                            <option value="allemp">All Employee</option>

                                            <?php foreach ($dlist as $key => $value) : ?>
                                                <option value="<?php echo $dlist[$key]['id']; ?>"><?php echo $dlist[$key]['emp_id'].'-'.$dlist[$key]['name']; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                        <div class="input-group marginize">
                                            <button id="generate-att" class="btn btn-primary" >Generate</button>
                                            <button id="print-att" class="btn btn-info" type="submit" style="display: none;">Print</button>
                                            <button id="export-att" class="btn btn-success btn-hidden" style="display: none;">Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Employee Attendance</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="wrapper-table-att" class="table-responsive">
                                    <!-- response here -->
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