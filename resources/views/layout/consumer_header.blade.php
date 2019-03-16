<!--<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6 top-message">
                <p>Welcome to FitCard</p>
            </div>
            <div class="col-md-6 top-links">
                <ul class="listnone">                              
                    <li><a href="/company">Are you Company?</a></li>
                    <li><a href="/admin">Are you Admin?</a></li>
                    <?php
                    if ($isLogin == false) {
                        ?>
                        <li><a href="/consumer/login">Log in</a></li>
                        <li><a href="/consumer/register">Register</a></li>
                        <?php
                    } else {
                        ?>                     
                        <li><a href="/consumer/price">Pricing</a></li>
                        <li><a href="/consumer/profile">Profile</a></li>
                        <li><a href="/consumer/logout">Logout</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
-->