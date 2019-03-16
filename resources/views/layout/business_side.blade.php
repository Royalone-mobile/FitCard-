<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!--
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo url('/') ."/";?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin User</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        -->
        <ul class="sidebar-menu">

            <?php
            if ($pageName == "DASHBOARD") {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            ?>
                <a href="<?php echo url('/') ."/";?>business/dashboard">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.dashboard');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "USERS") {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            ?>
                <a href="<?php echo url('/') ."/";?>business/users">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.users');?></span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
