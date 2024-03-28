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
        <?php //include_once('inc/topbar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php //include_once('inc/sidebar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" >
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <p>Please Scan the <strong>Barcode</strong> on the <strong>Car Dashboard</strong></p>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12" id="container">
                            <form class="form-horizontal mt-3" id="loginform" method="POST" >
                                <div class="input-group mb-3" id="inputs">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-layout-sidebar-right"></i></span>
                                    </div>
                                    <input type="text" name="barcode" id="barcode"  class="form-control form-control-lg" placeholder="barcode" onblur="this.focus()" autofocus autocomplete="off">
                                </div>

                               <div id="loading"></div>

                                <div class="form-group mb-0 mt-2">
                                    <div class="col-sm-12 text-center text-danger" id="text-error">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    

                    <div class="row hide" id="table-content">
                        <div class="col-12">
                        <div class="table-responsive">
                                    <table id="table-masterloc" class="display responsive nowrap table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Plate No</th>
                                                <th>way</th>
                                                <th>Destination</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                      
                                    </table>
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