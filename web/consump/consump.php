<?php

use PhpParser\Node\Expr\Ternary;

include_once('inc/head.php'); ?>
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="mt-4">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="input-import-consump" class="form-control-file" id="input-import-consump" accept=".csv">
                                            <label class="custom-file-label" for="input-import-consump">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-consump" class="btn btn-info" type="button">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                        $v = new Vehicle();
                        $vlist = $v->getAllVehicles();

                        if ($login_type != 'admin') {
                            $vlist = $v->getAllVehiclesByTermcode($login_termcode);
                        }

                    ?>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-consump">Add New Transaction</h4>
                                <form class="mt-4">
                                    <div class="form-group col-lg-6 ptrip-hidden">
                                        <input type="text" class="form-control" id="input-consump-id" name="input-consump-id" readonly>
                                    </div>
                                    <div class="form-group col-lg-6 ptrip-hidden">
                                        <input type="text" class="form-control" id="input-consump-term" name="input-consump-term" value="<?php echo $login_termcode; ?>" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <select name="consumpvehic" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                                <option value="null">Plate No</option>
                                                <?php foreach ($vlist as $key => $value) : ?>
                                                    <?php if (!empty($vlist[$key]['plate_no'])) : ?>
                                                        <option value="<?php echo $vlist[$key]['plate_no']; ?>"><?php echo $vlist[$key]['plate_no']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" class="form-control" id="datepicker_consump" name="datepicker_consump" placeholder="Date Fueled" readonly required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="number" class="form-control" id="input-consump-qty" name="input-consump-qty" placeholder="Fuel (In Liter)" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" class="form-control" id="input-consump-cost" name="input-consump-cost" placeholder="Cost" pattern="[0-9 _.,]*" required>
                                        </div>
                                    </div>
                                    
                                    <button id="btn-add-consump" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-consump" class="btn btn-danger">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                        $consump = new Consump();
                        $result = $consump->getAllConsump();

                        if ($login_type != 'admin') {
                            $result = $consump->getAllConsumpByTermcode($login_termcode);
                        }
                    ?>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Fuel Transactions</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div id="table-consump-wrapper" class="table-responsive">
                                    <table id="table-consump" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Date Fueled</th>
                                                <th>Plate No</th>
                                                <th>Fuel (Liter)</th>
                                                <th>Cost</th>
                                                <th>Cost per Liter</th>
                                                <th>Department</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($result)) : ?>
                                            <?php foreach ($result as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $result[$k]['id']; ?></td>
                                                <td class="datef"><?php echo $result[$k]['datef']; ?></td>
                                                <td class="plate"><?php echo $result[$k]['plate']; ?></td>
                                                <td class="cqty"><?php echo $result[$k]['qty']; ?></td>
                                                <td class="cost"><?php echo number_format($result[$k]['cost'], 2); ?></td>
                                                <td><?php echo number_format($result[$k]['cpl'], 2); ?></td>
                                                <td><?php echo $result[$k]['term_code']; ?></td>
                                                
                                                <td>
                                                    <button id="btn-edit-consump" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-border-color"></i></button>
                                                    <button id="btn-del-consump" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-window-close"></i></button>
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
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Generate</h4>
                                <form class="mt-3" target="_blank" action="" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" style="background-color: #fff;" class="form-control col-6" name="daterange_consump" value="" placeholder="" aria-label="" aria-describedby="basic-addon1" readonly/>
                                        <select name="genconsumpvehic" class="select2 form-control custom-select col-6" style="width: 100%; height:36px;">
                                            <option value="allplt">All Plate No</option>
                                            <?php foreach ($vlist as $key => $value) : ?>
                                                <?php if (!empty($vlist[$key]['plate_no'])) : ?>
                                                    <option value="<?php echo $vlist[$key]['plate_no']; ?>"><?php echo $vlist[$key]['plate_no']; ?></option>
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
                                <h4 class="card-title">Fuel Consumptions</h4>
                                
                                <div id="gen-consump-container" class="row">
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