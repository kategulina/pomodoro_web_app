<?php
  /** Logging out */
  session_start();
  session_destroy();
  /** Redirection to the login page */
  echo("<script>location.href = 'login_page.php';</script>");
?>