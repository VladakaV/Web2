<?php

header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    header('Location: index.php');
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    
    <form action="" method="POST">
      <input name="login" />
      <input name="password" />
      <input type="submit" value="Войти" />
    </form>
    
    <?php
    }
else {
    if (!$session_started) {
    session_start();
    }
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['uid'] = 123;
    header('Location: ./');
}

