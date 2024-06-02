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
        print($login);
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
        print($password);
    }
}

$session_started = true;
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!$session_started) {
        $session_started = true;
        session_start();
    }
    ?>
    <html>
        <head>
        </head>
        <body>
            <?php 
            if ($_COOKIE['login_error'] == '1') {
                    print('<div id="messages">');
                    print('Логин или пароль неверные, попробуйте еще раз');
                    print('</div>');
            }
            if (empty($_SESSION['login'])) {
                print('<div id="messages">');
                print('Запомните логин и пароль ниже для дальнейшего входа');
                print('</div>');
                print('<div>');
                print('<a href="admin.php">Войти</a> как администратор.');
                print('</div>');
            
            }
             ?>
            <form action="" method="POST">
            <input name="login" value = "<?php set_login() ?>"/>
            <input name="password"  value = "<?php set_password() ?>"/>
            <input type="submit" name = "button_sign" value="Войти" />
            <input type = "submit" name = "button_admin" value = "Войти как администратор">
            </form>
        </body>
    </html>
    <?php


}
else if (isset($_POST['button_sign'])) {

    $user = 'u67324'; 
    $pass = '4775222'; 
    $db = new PDO(
    'mysql:host=localhost;dbname=u67324',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if (empty($_SESSION['login'])) {

        if (!$session_started) {
            $session_started = true;
            session_start();
        }

        $_SESSION['login'] = $_POST['login'];

        $stmt = $db->prepare("INSERT INTO login_and_password (login, password) VALUES (:login_value, :password_value)");

        $login = $_POST['login'];
        $password = md5($_POST['password']);

        $stmt->bindParam(':login_value', $login);
        $stmt->bindParam(':password_value', $password);

        $stmt->execute();

        header('Location: index.php');
        exit();
    }
    else {

        try {

            $stmt = $db->prepare("SELECT * FROM login_and_password WHERE login = :login_value AND password = :password_value");

            $stmt->bindParam(':login_value', $_POST['login']);
            $stmt->bindParam(':password_value', md5($_POST['password']));
    
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                setcookie('login_error', '1', time() + 60 * 60 * 24 * 365);
                header('Location: login.php');
                exit();
            } 
            else {

                if (!$session_started) {
                    session_start();
                }

                $_SESSION['login'] = $_POST['login'];

                setcookie('login_error', '', 100000);
            }            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
          }

        header('Location: index.php');
    }
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

    try {

        $stmt = $db->prepare("SELECT * FROM admin_data WHERE login = :login_value AND password = :password_value");

        $stmt->bindParam(':login_value', $_POST['login']);
        $stmt->bindParam(':password_value', md5($_POST['password']));

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            setcookie('login_error', '1', time() + 60 * 60 * 24 * 365);
            header('Location: login.php');
            exit();
        } 
        else {

            if (!$session_started) {
                session_start();
            }

            $_SESSION['login'] = $_POST['login'];

            setcookie('login_error', '', 100000);
        }            
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
        }

    header('Location: admin.php');
   
}
    

