
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">login</h2>
    </div>
    <div class="mx-auto container">
        <form id="login-form" action="<?= publicUrl('login.php'); ?>" method="post">
            <div class="form-group">
                <label>email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="email" required>
            </div>
            <div class="form-group">
                <label>password</label>
                <input type="password" class="form-control" id="login-password" name="password"
                       placeholder="password" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" value="login">
            </div>
            <?php
            if(!isset($_SESSION)) {
                session_start();
            }
            if(($_SESSION['rejectMsg']) ?? '') {
                echo "<div style='padding-top: 2rem; font-size: large' >{$_SESSION['rejectMsg']}</div>";
            }
            if(($_SESSION['inputEmailReject']) ?? '') {
                echo "<div style='padding-top: 2rem; font-size: large' >{$_SESSION['inputEmailReject']}</div>";
            }
            if (isset($_SESSION['inputPasswordReject'])) {
                echo "<div style='padding-top: 2rem; font-size: large' >{$_SESSION['inputPasswordReject']}</div>";
            }
            ?>
        </form>
    </div>
</section>





