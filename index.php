<?php
session_start();
include "blocks/header_main.php";
?>

<body>
    <section id="title">
        <!-- Nav bar -->
        <?php
        include "blocks/header_buttons.php";
        ?>

        <div class="title">
            <p>Hey, what time is it?</p>
            <h1>It's Focus Time!</h1>
        </div>
    </section>

    <section id="sign-up">
        <div class="why-to-sigh-up">
            <h2>Sign up to</h2>
            <ul>
                <li>Run your own to-do lists</li>
                <li>Use Pomodoro timer</li>
                <li>Save your lists!</li>
            </ul>
            <?php
            /** Shows Sigh up button if user is not logged in
            Otherwise shows Profile button */
            if ($_SESSION["userLoggedIn"]) {
                echo '<a href="personal_page.php" class="sign-up-btn">Profile</a>';
            } else {
                echo '<a href="login_page.php" class="sign-up-btn">Sign up</a>';
            }
            ?>
        </div>
    </section>

    <section id="features">
        <h2>Why focus time?</h2>
        <div id="features-list">
            <div class="feature-item">
                <i class="far fa-2x fa-check-circle img-features"></i>
                <h3>Easy to use</h3>
            </div>
            <div class="feature-item">
                <i class="fas fa-2x fa-users img-features"></i>
                <h3>Motivation from users</h3>
            </div>
            <div class="feature-item">
                <i class="fas fa-2x fa-smile-beam img-features"></i>
                <h3>Absolutely free</h3>
            </div>
        </div>
    </section>

    <section id="info">
        <div class="wiki-info">
            <h2>More about Pomodoro Technique</h2>
            <p>
                The Pomodoro Technique is created by Francesco Cirillo for a more productive way to work and study. The
                technique uses a timer to break down work into intervals, traditionally 25 minutes in length, separated
                by short breaks. Each interval is known as a pomodoro, from the Italian word for 'tomato', after the
                tomato-shaped kitchen timer that Cirillo used as a university student. – <a target="_blank" rel="noopener noreferrer" href="https://en.wikipedia.org/wiki/Pomodoro_Technique">Wikipedia</a>
            </p>
        </div>
        <div class="how-to-use">
            <h2>How to use Pomodoro</h2>
            <ol>
                <li>Add tasks in to-do list</li>
                <li>Set timer</li>
                <li>Start timer and focus on the task</li>
                <li>Don't forget to take a break!</li>
                <li>Success!</li>
            </ol>
        </div>
    </section>
    <!-- Footer -->
    <?php
    include "blocks/footer.php";
    ?>
</body>

</html>