<?php
session_start();
include "blocks/header_main.php";
include "process_file.php";
?>

<body>
    <!-- Nav bar -->
    <?php
    include "blocks/header_buttons.php";
    ?>
    <section class="personal-info">
        <div class="info"></div>
        <?php
        /** Print user name */
        $user = $_SESSION["username"];
        echo "<h2>Hello, $user!</h2>";
        ?>
        <h5>Personal info</h5>
        <?php
        /** Print user e-mail */
        $userEm = $_SESSION["userEmail"];
        echo "<h3>Email: $userEm</h3>";
        ?>
    </section>

    <section class="saved-todo">
        <div class="saved-todo-div">
            <h4>Your saved to-do!</h4>
            <ul class="toDoList">
                <?php
                /** Get data from json database in db directory */
                $to_do_list_raw = getTextFromFile($_SESSION["username"]);
                $to_do_list = json_decode($to_do_list_raw, true);

                /** Pagination */
                $page = 0;
                /** Setting page var */
                if (isset($_GET["page"])) {
                    $page = intval($_GET["page"]);
                } else {
                    $page = $_GET["page"] = 0;
                }

                /** Slice all data by 3 */
                $pageTasks = array_slice($to_do_list, $page * 3, 3);
                /** Print all tasks */
                foreach ($pageTasks as $todo) {
                    if ($todo["state"]) {
                        echo '<li class="checked">' . htmlspecialchars($todo["text"]) . '</li>';
                    } else {
                        echo '<li>' . htmlspecialchars($todo["text"]) . '</li>';
                    }
                }
                /** Prev button */
                if ($page > 0) {
                    echo "<a class=\"fas fa-chevron-left right-left-btn\" href=\"personal_page.php?page=" . ($page - 1) . "\"></a>";
                }

                /** Next button */
                $remainingTasks = count($to_do_list) - 3 * ($page + 1);
                if ($remainingTasks > 0) {
                    echo "<a class=\"fas fa-chevron-right right-left-btn\" href=\"personal_page.php?page=" . ($page + 1) . "\"></a>";
                }
                ?>
            </ul>
        </div>
    </section>
    <!-- Footer -->
    <?php
    include "blocks/footer.php";
    ?>
</body>

</html>