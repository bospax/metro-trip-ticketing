<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li>
                            <!-- User Profile-->
                            <div class="user-profile d-flex no-block dropdown mt-3">
                                <div class="user-pic"><img src="../template/assets/images/users/1.jpg" alt="users" class="rounded-circle" width="40" /></div>
                                <div class="user-content hide-menu ml-2">
                                    <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <h5 class="mb-0 user-name font-medium"><?php echo $login_name; ?></h5>
                                        <span class="op-5 user-email" style="font-size: 11px;"><?php echo $login_termname; ?></span><br>
                                        <span class="op-5 user-email" style="font-size: 11px;"><?php echo $login_type; ?></span>
                                    </a>
                                </div>
                            </div>
                            <!-- End User Profile-->
                        </li>
                        
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">MENU</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-content-copy"></i><span class="hide-menu">Masterlist</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="../index.php/?action=terminal" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Terminal </span></a></li>
                                <li class="sidebar-item"><a href="../index.php/?action=vehicles" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Vehicles </span></a></li>
                                <li class="sidebar-item"><a href="../index.php/?action=drivers" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Drivers </span></a></li>
                                <!-- <li class="sidebar-item"><a href="../index.php/?action=contacts" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Contacts </span></a></li> -->
                                <li class="sidebar-item"><a href="../index.php/?action=locations" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Location </span></a></li>
                            </ul>
                        </li>
                        <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php/?action=fleet" aria-expanded="false"><i class="mdi mdi-bus"></i><span class="hide-menu">Fleet</span></a></li> -->
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php/?action=trips" aria-expanded="false"><i class="mdi mdi-ticket"></i><span class="hide-menu">Trip</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php/?action=consump" aria-expanded="false"><i class="mdi mdi-filter"></i><span class="hide-menu">Consumption</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php/?action=ptrips" aria-expanded="false"><i class="mdi mdi-map-marker-radius"></i><span class="hide-menu">Planned Trip</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../index.php/?action=reports" aria-expanded="false"><i class="mdi mdi-content-paste"></i><span class="hide-menu">Report</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="../web/authenticate/logout.php" aria-expanded="false"><i class="mdi mdi-directions"></i><span class="hide-menu">Log Out</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>