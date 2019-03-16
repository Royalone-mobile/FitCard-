<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Small boxes (Stat box) -->

    <!-- /.row -->
    <!-- Main row -->

    <?php
    if ($pageName == "DASHBOARD") {
        ?>
        @include('admin_content.dashboard')
        <?php
    } else if ($pageName == "COMPANY") {
        ?>
        @include('admin_content.company')
        <?php
    } else if ($pageName == "USERS") {
        ?>
        @include('admin_content.users')
        <?php
    } else if ($pageName == "GYMS") {
        ?>
        @include('admin_content.gyms')
        <?php
    } elseif ($pageName == "GYMCODE") {
        ?>
          @include('admin_content.gymcode')
        <?php
    } else if ($pageName == "CLASSES") {
        ?>
        @include('admin_content.classes')
        <?php
    } else if ($pageName == "PAYMENTS") {
        ?>
        @include('admin_content.payments')
        <?php
    } else if ($pageName == "REVIEWS") {
        ?>
        @include('admin_content.reviews')
        <?php
    } else if ($pageName == "ADDCLASS") {
        ?>
        @include('admin_content.createclass')
        <?php
    } else if ($pageName == "ADDGYM") {
        ?>
        @include('admin_content.creategym')
        <?php
    } else if ($pageName == "EDITGYM") {
        ?>
        @include('admin_content.editgym')
        <?php
    } else if ($pageName == "LOCATION") {
        ?>
        @include('admin_content.location')
        <?php
    } else if ($pageName == "ACTIVITY") {
        ?>
        @include('admin_content.activity')
        <?php
    } else if ($pageName == "STUDIO") {
        ?>
        @include('admin_content.studio')
        <?php
    } else if ($pageName == "AMENTITY") {
        ?>
        @include('admin_content.amentity')
        <?php
    } else if ($pageName == "CITY") {
        ?>
        @include('admin_content.city')
        <?php
    } else if ($pageName == "GYMCATEGORY") {
        ?>
        @include('admin_content.gymcategory')
        <?php
    } else if ($pageName == "CLASSCATEGORY") {
        ?>
        @include('admin_content.classcategory')
        <?php
    } else if ($pageName == "CREATELOCATION") {
        ?>
        @include('admin_content.createlocation')
        <?php
    } else if ($pageName == "CREATECOMPANY") {
        ?>
        @include('admin_content.createcompany')
        <?php
    } else if ($pageName == "EDITCOMPANY") {
        ?>
        @include('admin_content.editcompany')
        <?php
    } else if ($pageName == "EDITCLASS") {
        ?>
        @include('admin_content.editclass')
        <?php
    } else if ($pageName == "PLAN") {
        ?>
        @include('admin_content.plan')
        <?php
    } else if ($pageName == "USEREDIT") {
        ?>
        @include('admin_content.edituser')
        <?php
    } else if ($pageName == "INVOICE") {
        ?>
        @include('admin_content.invoice')
        <?php
    } else if ($pageName == "COUPON") {
        ?>
        @include('admin_content.coupon')
        <?php
    } else if ($pageName == "CREATEUSER") {
        ?>
        @include('admin_content.createuser')
        <?php
    } elseif ($pageName == "BUSINESS") {
        ?>
        @include('admin_content.business')
        <?php
    }
    ?>   




    <!-- /.row (main row) -->

    <!-- /.content -->
</div>
