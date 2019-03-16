<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Small boxes (Stat box) -->

    <!-- /.row -->
    <!-- Main row -->

    <?php
    if ($pageName == "DASHBOARD") {
        ?>
        @include('business_content.dashboard')
        <?php
    }
    if ($pageName == "USERS") {
        ?>
        @include('business_content.users')
        <?php
    }
    if ($pageName == "PROFILE") {
        ?>
        @include('business_content.profile')
        <?php
    }
    ?>




    <!-- /.row (main row) -->

    <!-- /.content -->
</div>
