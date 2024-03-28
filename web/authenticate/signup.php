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

        <?php
        require_once('../../database/db.php');
        require_once('../../helpers/functions.php');
        require_once('../../class/Terminal.php');

        $terminal = new Terminal();
        $termlist = $terminal->getAllTerminal();

        // var_dump($termlist);

        ?>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../../template/assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div>
                    <div class="logo">
                        <span class="db"><img src="../../template/assets/images/metro_text.png" alt="logo" /></span>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3" action="index.html">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <select name="input-user-type" id="input-user-type" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">User type</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <select name="input-user-terminal" id="input-user-terminal" class="select2 form-control custom-select col-12" style="width: 100%; height:36px;">
                                            <option value="null">Department</option>
                                            <?php foreach ($termlist as $key => $value) :  ?>
                                                <option value="<?php echo $termlist[$key]['term_code']; ?>"><?php echo $termlist[$key]['term_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input id="input-signup-pkey" class="form-control form-control-lg" type="password" required=" " placeholder="Authorization key">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input id="input-signup-aname" class="form-control form-control-lg" type="text" required=" " placeholder="Account Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input id="input-signup-username" class="form-control form-control-lg" type="text" required=" " placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input id="input-signup-password" class="form-control form-control-lg" type="password" required=" " placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input id="input-signup-confirm" class="form-control form-control-lg" type="password" required=" " placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 pb-3 ">
                                        <button id="btn-signup-submit" class="btn btn-block btn-lg btn-info" type="submit" data-type="signup">SIGN UP</button>
                                    </div>
                                </div>
                                <div class="form-group mb-0 mt-2 ">
                                    <div class="col-sm-12 text-center ">
                                        Already have an account? <a href="../../index.php" class="text-info ml-1 "><b>Sign In</b></a>
                                    </div>
                                </div>
                            </form>
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