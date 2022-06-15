<header>
    <a href="index.php" class="BUTTON_NCQ"><i class="fas fa-clock logo-img"></i> Focus time!</a>
    <?php
    error_reporting(0);  // hide PHP warnings
    /** Show Profile and Logout buttons if user is logged in */
    if ($_SESSION["userLoggedIn"]) {
        echo '<a href="logout.php" class="login-btn">Logout</a>';
        echo '<a href="personal_page.php" class="login-btn">Profile</a>';
    } else {
        echo '<a href="login_page.php" class="login-btn">Login</a>';
    }
    ?>
    <a href="work_page.php" class="work-btn">Work</a>
</header>