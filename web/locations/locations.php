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

                    $masterloc = new Masterloc();
                    $masterloc_list = $masterloc->getAllMasterloc();

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
                                        <div class="custom-file col-9">
                                            <input type="file" name="input-import-loc" class="form-control-file" id="input-import-loc" accept=".csv">
                                            <label class="custom-file-label" for="input-import-loc">Choose file</label>
                                        </div>
                                        <div class="custom-file col-3">
                                            <select name="importtype" class="select2 form-control custom-select">
                                                <option value="masterloc">Location</option>
                                                <option value="loctag">Location Tag</option>
                                            </select>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="btn-import-loc" class="btn btn-info" type="button">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="row <?php echo ($has_permi == true) ? '' : 'd-none' ?>">
                    <div class="<?php echo ($has_permi == true) ? 'col-lg-8' : 'col-lg-12' ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Locations</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div class="table-responsive">
                                    <table id="table-masterloc" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Code</th>
                                                <th>Location</th>
                                                <!-- <th>Origin</th>
                                                <th>Distance</th>
                                                <th>Duration</th> -->
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($masterloc_list)) : ?>
                                            <?php foreach ($masterloc_list as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $masterloc_list[$k]['id']; ?></td>
                                                <td class="mastercode"><?php echo $masterloc_list[$k]['mastercode']; ?></td>
                                                <!--this is the original code below-->
                                                <td class="mastername"><?php echo $masterloc_list[$k]['mastername']; ?></td>
                                                <!--add the code below for Ñ-->
                                                <!--<td class="mastername"><?php echo  mb_convert_encoding($masterloc_list[$k]['mastername'], "UTF-8", "ISO-8859-1"); ?> -->
                                               
                                                <!-- <td><?php //echo $result[$k]['origin'] ?></td>
                                                <td><?php //echo $result[$k]['distance'] ?></td>
                                                <td><?php //echo $result[$k]['duration'] ?></td> -->
                                                <td>
                                                    <?php if ($has_permi == true) : ?>
                                                    <button id="btn-edit-masterloc" class="btn btn-success btn-xs" data-id="<?php echo $masterloc_list[$k]['id']; ?>"><i class="mdi mdi-border-color"></i></button>
                                                    <button id="btn-del-masterloc" class="btn btn-danger btn-xs" data-id="<?php echo $masterloc_list[$k]['id']; ?>"><i class="mdi mdi-window-close"></i></button>
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

                    <?php if ($has_permi == true) : 
                        
                        // $terminal = new Terminal();
                        // $terms = $terminal->getAllTerminal();

                    ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-masterloc">Add New Location</h4>
                                <form class="mt-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-masterloc-id">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-masterloc-code" placeholder="Location Code" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="input-masterloc-name" placeholder="Location Name" required>
                                    </div>
                                    <button id="btn-add-masterloc" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-masterloc" class="btn btn-danger">Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="<?php echo ($has_permi == true) ? 'col-lg-8' : 'col-lg-12' ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Location Tagging</h4>
                                <!-- <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6> -->
                                <div class="table-responsive">
                                    <table id="table-trips" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID</th>
                                                <th>Code</th>
                                                <th>Location</th>
                                                <th>Terminal</th>
                                                <!-- <th>Origin</th>
                                                <th>Distance</th>
                                                <th>Duration</th> -->
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($result)) : ?>
                                            <?php foreach ($result as $k => $v) : ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $result[$k]['id']; ?></td>
                                                <td class="lcode"><?php echo $result[$k]['loc_code']; ?></td>
                                                <td class="lname"><?php echo $result[$k]['loc_name']; ?></td>
                                                <th class="tcode"><?php echo $result[$k]['term_code']; ?></th>
                                                <!-- <td><?php //echo $result[$k]['origin'] ?></td>
                                                <td><?php //echo $result[$k]['distance'] ?></td>
                                                <td><?php //echo $result[$k]['duration'] ?></td> -->
                                                <td>
                                                    <?php if ($has_permi == true) : ?>
                                                    <button id="btn-edit-loc" class="btn btn-success btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-border-color"></i></button>
                                                    <button id="btn-del-loc" class="btn btn-danger btn-xs" data-id="<?php echo $result[$k]['id']; ?>"><i class="mdi mdi-window-close"></i></button>
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

                    <?php if ($has_permi == true) : 
                        
                        $terminal = new Terminal();
                        $terms = $terminal->getAllTerminal();

                    ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title card-title-loc">Tag New Location</h4>
                                <form class="mt-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-loc-id">
                                    </div>
                                    <div class="form-group">
                                        <select name="input-loc-termcode" id="input-loc-termcode" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Terminal</option>
                                            <?php foreach ($terms as $key => $value) : ?>
                                                <?php if (!empty($terms[$key]['term_code'])) : ?>
                                                    <option value="<?php echo $terms[$key]['term_code']; ?>"><?php echo $terms[$key]['term_code'].' - '.$terms[$key]['term_name']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- <input type="text" class="form-control" id="input-loc-code" placeholder="Location Code" required> -->
                                        <select name="input-loc-code" id="input-loc-code" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Location Code</option>
                                            <?php foreach ($masterloc_list as $key => $value) : ?>
                                                <?php if (!empty($masterloc_list[$key]['mastercode'])) : ?>
                                                    <option value="<?php echo $masterloc_list[$key]['mastercode']; ?>"><?php echo $masterloc_list[$key]['mastercode'].' - '.$masterloc_list[$key]['mastername']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="input-loc-name" placeholder="Location Name" style="background-color: #fff;" readonly required>
                                    </div>
                                    <button id="btn-add-loc" class="btn btn-info" data-type="add">Save</button>
                                    <button id="btn-clear-loc" class="btn btn-danger">Clear</button>
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