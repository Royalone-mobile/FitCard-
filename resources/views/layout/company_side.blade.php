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
            if ($pageName == "VISITORS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>company/visitors">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.visitors');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "CLASSES")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>company/classes">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.classesCompany1');?></span>            
                </a>
            </li>
            <?php
            if ($pageName == "REVIEWS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>company/reviews">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.reviews');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "PAYMENTS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>company/payments">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.payments');?></span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
