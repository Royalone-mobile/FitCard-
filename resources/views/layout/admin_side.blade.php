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
            if ($pageName == "DASHBOARD")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/dashboard">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.dashboard');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "COMPANY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/company">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.company');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "USERS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/users">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.users');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "GYMS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/gyms">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.gymAdmin');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "GYMCODE")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/gymCode">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.gymCode');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "BUSINESS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/business">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.businessUser');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "CLASSES")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/classes">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.classAdmin');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "COUPON")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/viewCoupon">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.couponCode');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "PAYMENTS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/payments">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.payments');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "REVIEWS")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/reviews">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.reviews');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "LOCATION")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/locationmanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.locationManage');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "ACTIVITY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/activitymanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.activityManage');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "STUDIO")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/studiomanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.studioManage');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "AMENTITY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/amentitymanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.amenityManage');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "CITY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/citymanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.cityManage');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "GYMCATEGORY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/gymcategory">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.gymCategory');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "CLASSCATEGORY")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/classcategory">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.classCategory');?></span>
                </a>
            </li>
            <?php
            if ($pageName == "PLANMANAGE")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>
                <a href="<?php echo url('/') ."/";?>admin/planmanage">
                    <i class="fa fa-table"></i> <span><?php echo trans('web.planManage');?></span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
