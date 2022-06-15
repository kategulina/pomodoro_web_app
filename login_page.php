<?php
session_start();

/** Check if database exists */
if (!file_exists("db/users.json")) {
    file_put_contents("db/users.json", "[]");
}

/** Get all data from user.json database */
$accounts = json_decode(file_get_contents("db/users.json"), true);

$accExists = false;  ///< flag shows if account already exists
$userLogged = false;  ///< flag of succesfull registration
$userRegistred = true;  ///< flag shows if user has already registred – used for log in
$succesfullReg = false;  ///< flag of the succesfull registration

/** Variables for checking data on the server */
$wrongUsername = false;
$passwordsMatch = true;

/** User registration */
if (isset($_POST["profileNameNew"], $_POST["profileEmailNew"], $_POST["profilePasswordNew"], $_POST["profilePasswordConfirm"])) {
    $newUser = htmlspecialchars($_POST["profileNameNew"]);  ///< new user username
    /** Check if name is longer than 3 symbols and if name is not "user" */
    if ((strlen($newUser) < 3) or ($newUser == "user")) {
        $wrongUsername = true;
    }
    $newEmail = htmlspecialchars($_POST["profileEmailNew"]);  ///< new user email
    $newPass = htmlspecialchars($_POST["profilePasswordNew"]);  ///< new user password
    $newPassConformation = htmlspecialchars($_POST["profilePasswordConfirm"]);  ///< password confirmation
    /** Check if passwords match */
    if ($newPass != $newPassConformation) {
        $passwordsMatch = false;
    }

    /** Get CSRF token for registration form */
    $token = $_POST["tokenReg"];

    if (!$token || $token !== $_SESSION["tokenReg"]) {
        /** Return 405 http status code */
        header($_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed");
        exit;
    } else {
        /** Check if this user already exists */
        foreach ($accounts as $account) {
            if ($account["email"] == $newEmail || $account["username"] == $newUser) {
                $accExists = true;
                break;
            }
        }

        /** Add new user to the db */
        if (!$accExists) {
            $passHash = password_hash($newPass, PASSWORD_DEFAULT);
            $newAcc = ["username" => $newUser, "email" => $newEmail, "password" => $passHash];  ///< create new acc
            array_push($accounts, $newAcc);
            file_put_contents("db/users.json", json_encode($accounts));
            $succesfullReg = true;
        }
    }
}

/** User log in */
if (isset($_POST["profileLogin"], $_POST["profilePassword"])) {
    $userLogin = $_POST["profileLogin"];
    $userPass = $_POST["profilePassword"];

    /** Get CSRF token for log in form */
    $token = $_POST["tokenLogin"];

    if (!$token || $token !== $_SESSION["tokenLogin"]) {
        /** Return 405 http status code */
        header($_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed");
        exit;
    } else {
        /** Finding user in db */
        foreach ($accounts as $account) {
            if ($account["username"] == $userLogin) {
                if (password_verify($userPass, $account["password"])) {
                    $userLogged = true;
                    $_SESSION["username"] = $userLogin;  ///< create session username
                    $_SESSION["userLoggedIn"] = true;  ///< session flag user logged in
                    $_SESSION["userEmail"] = $account["email"];  ///< create session user mail
                    break;
                } else {
                    echo "Wrong password!\n";
                }
            } else {
                $userRegistred = false;
            }
        }
    }
}

include "blocks/header_main.php";

/** Generating tokens for registration and log in forms */
$_SESSION["tokenReg"] = md5(uniqid(mt_rand(), true));
$_SESSION["tokenLogin"] = md5(uniqid(mt_rand(), true));
?>

<body>
    <!-- Nav bar -->
    <?php
    include "blocks/header_buttons.php";
    ?>
    <section class="login-section">
        <div class="create-acc-form">
            <h2>Are you new here?</h2>
            <form id="registrationForm" method="post">
                <h4>Create account!</h4>
                <span class="color-req">* Field is required!</span>
                <label for="newUserNameInput"></label>
                <input type="text" name="profileNameNew" id="newUserNameInput" pattern="[A-Za-z0-9]{3,}" placeholder="Username*" value="<?php echo $_POST["profileNameNew"] ?? "" ?>" required>

                <label for="newEmailInput"></label>
                <input type="email" name="profileEmailNew" id="newEmailInput" pattern="[A-Za-z0-9@.]{5,}" placeholder="Email*" value="<?php echo $_POST["profileEmailNew"] ?? "" ?>" required>

                <label for="newPasswordInput"></label>
                <input type="password" name="profilePasswordNew" id="newPasswordInput" pattern="[A-Za-z0-9@.]{6,}" placeholder="Password*" required>

                <label for="passConformationInput"></label>
                <input type="password" name="profilePasswordConfirm" id="passConformationInput" pattern="[A-Za-z0-9@.]{6,}" placeholder="Confirm password*" required>

                <label for="newUserBDInput">Date of Birth:</label>
                <input type="date" name="userBD" id="newUserBDInput" value="<?php echo $_POST["userBD"] ?? "" ?>">

                <input type="hidden" name="tokenReg" value="<?php echo $_SESSION["tokenReg"] ?? "" ?>">

                <button type="submit" class="create-btn">Create</button>
                <?php
                /** Print errors */
                if ($accExists) {
                    echo "<h4>This user exists!<h4>";
                }
                if ($succesfullReg) {
                    echo "<h4>Registration is succesfull!<h4>";
                }
                if (!$passwordsMatch) {
                    echo "<h4>Passwords don't match!<h4>";
                }
                ?>
            </form>
        </div>
        <div class="login-form">
            <h2>Already have an account?</h2>
            <form method="post">
                <h4>Welcome back!</h4>
                <span class="color-req">* Field is required!</span>
                <label for="userNameInput"></label>
                <input type="text" name="profileLogin" id="userNameInput" pattern="[A-Za-z0-9]{3,}" placeholder="Username*" value="<?php echo $_POST["profileLogin"] ?? "" ?>" required>

                <label for="passInput"></label>
                <input type="password" name="profilePassword" id="passInput" pattern="[A-Za-z0-9@.]{6,}" placeholder="Password*" required>

                <input type="hidden" name="tokenLogin" value="<?php echo $_SESSION["tokenLogin"] ?? "" ?>">

                <button type="submit" class="log-in-btn">Log in</button>
                <?php
                /** Succesfull log in */
                if ($userLogged) {
                    $msg = $_SESSION["username"];
                    echo ("<script>location.href = 'personal_page.php?msg=$msg';</script>");
                }
                /** Unseccesfull log in */
                if (!$userRegistred) {
                    echo "<h4>This user doesn't exist!<h4>";
                }
                if ($wrongUsername) {
                    echo "<h4>Username is too short!<h4>";
                }
                ?>
            </form>
        </div>
    </section>
    <!-- Footer -->
    <?php
    include "blocks/footer.php";
    ?>
    <script src="scripts/reg_input_control.js"></script>
</body>

</html>