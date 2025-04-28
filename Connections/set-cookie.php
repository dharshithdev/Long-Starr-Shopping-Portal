<?php
  if(isset($_SESSION['user_id'])) {
    setcookie("user_id", $_SESSION['user_id'], time() + (86400 * 30), "/");
  }
?>