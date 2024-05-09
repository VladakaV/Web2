<?php

header('Content-Type: text/html; charset=UTF-8');

function set_login() {
    if (empty($_SESSION['login'])) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $login = '';
        for ($i = 0; $i < 20; $i++) {
            $login .= $characters[random_int(0, $charactersLength - 1)];
        }
        print($login)
    }
}

function set_password() {
    if (empty($_SESSION['login'])) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $password = '';
        for ($i = 0; $i < 20; $i++) {
            $password .= $characters[random_int(0, $charactersLength - 1)];
        }
        print($password)
    }
}

$session_started = false;
// if ($_COOKIE[session_name()] && session_start()) {
//   $session_started = true;
//   if (!empty($_SESSION['login'])) {
//     header('Location: index.php');
//     exit();
//   }
// }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    
    <form action="" method="POST">
      <input name="login" value = <?php set_login ?>/>
      <input name="password"  value = <?php set_password ?>/>
      <input type="submit" value="Войти" />
    </form>
    
    <?php
    }
else {

    $user = 'u67324'; 
    $pass = '4775222'; 
    $db = new PDO(
    'mysql:host=localhost;dbname=u67324',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if (empty($_SESSION('login'))) {

        $_SESSION['login'] = $_POST['login'];

        $stmt = $db->prepare("INSERT INTO login_and_password (login, password) VALUES (:login_value, :password_value)");

        $stmt->bindParam(':login_value', $_POST['login']);
        $stmt->bindParam(':password_value', md5($_POST['password']));

        $stmt->execute();

        if (!$session_started) {
            session_start();
          }
    }
    else {

        $login = $_POST['login'];
        $password = md5($_POST['password']);

        $sth = $db->prepare("SELECT * FROM login_and_password");
        $sth->execute();
        $log_pass = $sth->fetchAll();
      
        $isSign = false;
        foreach ($log_pass as $l_p) {
          if ($login == $l_p['login'] && $pass == $l_p['password']) {
            $isSign = true;
            $user_id = $l_p['id'];
            break;
          }
        }
      
        if ($isSign == true) {
          if (!$session_started) {
            session_start();
          }

          $_SESSION['login'] = $_POST['login'];
        
          $_SESSION['user_id'] = $user_id; 
        
    }

    header('Location: ./');
}
}
    

