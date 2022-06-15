<?php
include_once "process_file.php";
session_start();

/**
 * Alt cookie is created for checking, if button Save was clicked, and page is not just reloaded.
 * If Alt cookie exist and have value "true", data from ToDos will be saved.
 * After that cookie will be changed to false.
 */
if (isset($_COOKIE['isAlt']) and $_COOKIE["isAlt"] == "true" and isset($_SESSION["username"])) {
    saveTo($_SESSION["username"], $_COOKIE["doneTask"]);
    setcookie("isAlt", false, 0, "/");
    setcookie("doneTask", "", 0, "/");
}

include "blocks/header.php";
?>

<body>
    <!-- Nav bar -->
    <?php
    include "blocks/header_buttons.php";
    ?>

    <section class="work-area">
        <div class="to-do-list">
            <h2>To-do list</h2>
            <form method="post">
                <ul class="toDoList">
                    <?php
                    /** Getting data from user.json file */
                    if (isset($_SESSION["username"])) {
                        $to_do_list_raw = getTextFromFile($_SESSION["username"]);
                        $to_do_list = json_decode($to_do_list_raw, true);
                    }
                    ?>
                    <?php
                    /** Print all tasks from db */
                    foreach ($to_do_list as $todo) {
                        if ($todo["state"]) {
                            echo '<li class="checked">'.htmlspecialchars($todo["text"]).'<span class="close"> X</span></li>';
                        } else {
                            echo '<li>'.htmlspecialchars($todo["text"]).'<span class="close"> X</span></li>';
                        }
                    }
                    ?>
                </ul>
                <label for="NewTask"></label>
                <input type="text" name="NewTask" placeholder="Add a task!" class="addNewTask" id="NewTask">
                <i class="fas fa-plus addTick"></i>
                <?php
                /** Show Save button if user is logged in */
                if ($_SESSION["userLoggedIn"]) {
                    echo '<button type="submit" class="save-btn" id="save-btn">Save</button>';
                }
                ?>
            </form>
        </div>
        <div class="timer">
            <h2>Timer</h2>
            <i class="fas fa-2x fa-chevron-up" id="iconTimerUp"></i>
            <h1><span id="minutesVar">25</span> : <span id="secondsVar">00</span></h1>
            <i class="fas fa-2x fa-chevron-down" id="iconTimerDown"></i>
            <button type="button" class="start-stop-btn" id="startBtn">Start</button>
        </div>
    </section>
    <!-- Footer -->
    <?php
    include "blocks/footer.php";
    ?>
    <script src="scripts/script.js"></script>
</body>

</html>