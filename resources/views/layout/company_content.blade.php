<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Small boxes (Stat box) -->

    <!-- /.row -->
    <!-- Main row -->

    <?php
    if ($pageName == "VISITORS") {
        ?>
        @include('company_content.visitors')
        <?php
    }
    if ($pageName == "CLASSES") {
        ?>
        @include('company_content.classes')
        <?php
    } else if ($pageName == "HOURS") {
        ?>
        @include('company_content.hours')
        <?php
    } else if ($pageName == "PAYMENTS") {
        ?>
        @include('company_content.payments')
        <?php
    } else if ($pageName == "REVIEWS") {
        ?>
        @include('company_content.reviews')
        <?php
    } else if ($pageName == "ADDGYM") {
        ?>
        @include('company_content.creategym')
        <?php
    }else if ($pageName == "ADDCLASS") {
        ?>
        @include('company_content.createclass')
        <?php
    }
    else if ($pageName == "EDITGYM") {
        ?>
        @include('company_content.editgym')
        <?php
    }else if ($pageName == "EDITCLASS") {
        ?>
        @include('company_content.editclass')
        <?php
    }else if ($pageName == "PROFILE")
    {
        ?>
        @include('company_content.profile')
        <?php
    }
    
    
    ?>   




    <!-- /.row (main row) -->

    <!-- /.content -->
</div>