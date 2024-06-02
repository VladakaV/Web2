<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'change') {
        $user = 'u67324'; 
        $pass = '4775222'; 
        $db = new PDO(
        'mysql:host=localhost;dbname=u67324',
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $sth = $db->prepare("SELECT * FROM login_and_password where id = ?");
        $sth->execute([$_POST['id']]);
        $log_pass = $sth->fetchAll();
        session_start();
        $_SESSION['login'] = $log_pass[0]['login'];
        $_SESSION['uid'] = $_POST['id'];
        header('Location: index.php');
    }
    elseif ($_POST['action'] == 'delete') {
        try {
            $user = 'u67324'; 
            $pass = '4775222'; 
            $db = new PDO(
            'mysql:host=localhost;dbname=u67324',
            $user,
            $pass,
            [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM users where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM login_and_password where id = ?");
            $stmt->execute([$id]);

            $sth = $db->prepare("SELECT * FROM users");
            $sth->execute();
            $users = $sth->fetchAll();
         
            $countId = count($users);
            $indexU = 0;
            for ($i = 1; $i <= $countId; $i++) {
                $tempU = intval($users[$indexU]['id']);
                $stmt = $db->prepare("UPDATE users SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE login_and_password SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE users_and_languages SET id_user = ? where id_user = $tempU");
                $stmt->execute([$i]);
                $indexU++;
            }
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: admin.php');
    }
}