<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (empty($_SESSION['login'])) {
        header('Location: login.php');
        exit();
    }

    $messages = array();

    if (!empty($_COOKIE['save'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('save', '', 100000);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages['success'] = 'Спасибо, результаты сохранены.';
    }

    if (!empty($_COOKIE['update'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('update', '', 100000);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages['update'] = 'Результаты обновлены.';
    }

    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birth'] = !empty($_COOKIE['birth_error']);
    $errors['radio_sex'] = !empty($_COOKIE['radio_sex_error']);
    $errors['field_favourite_pl'] = !empty($_COOKIE['field_favourite_pl_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['checkbox_agree'] = !empty($_COOKIE['checkbox_agree_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000);
        setcookie('fio_value', '', 100000);
        $messages[] = '<div class="error">Заполните имя (текстовыми символами).</div>';
    }
    if ($errors['tel']) {
        setcookie('tel_error', '', 100000);
        setcookie('tel_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон (цифрами, длиной в 11 знаков).</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните почту (по форме example@mail.ru).</div>';
    }
    if ($errors['birth']) {
        setcookie('birth_error', '', 100000);
        setcookie('birth_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату рождения (по форме год-месяц-день).</div>';
    }
    if ($errors['radio_sex']) {
        setcookie('radio_sex_error', '', 100000);
        setcookie('radio_sex_value', '', 100000);
        $messages[] = '<div class="error">Заполните ваш пол.</div>';
    }
    if ($errors['field_favourite_pl']) {
        setcookie('field_favourite_pl_error', '', 100000);
        setcookie('field_favourite_pl_value', '', 100000);
        $messages[] = '<div class="error">Выберите ваш любимый язык программирования.</div>';
    }
    if ($errors['biography']) {
        setcookie('biography_error', '', 100000);
        setcookie('biography_value', '', 100000);
        $messages[] = '<div class="error">Заполните биографию.</div>';
    }
    if ($errors['checkbox_agree']) {
        setcookie('checkbox_agree_error', '', 100000);
        setcookie('checkbox_agree_value', '', 100000);
        $messages[] = '<div class="error">Пожалуйста, поставьте галочку согласия.</div>';
    }

    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birth'] = empty($_COOKIE['birth_value']) ? '' : $_COOKIE['birth_value'];
    $values['radio_sex'] = empty($_COOKIE['radio_sex_value']) ? '' : $_COOKIE['radio_sex_value'];
    $values['field_favourite_pl'] = empty($_COOKIE['field_favourite_pl_value']) ? '' : $_COOKIE['field_favourite_pl_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['checkbox_agree'] = $_COOKIE['checkbox_agree_value'] === 'on' ? 'on' : 'off';

    function is_checked_lang($values, $value)
    {
        if (!empty($values) && !empty($values['field_favourite_pl'])) {
            foreach ($values['field_favourite_pl'] as $value_for) {
                if ($value_for == $value) {
                    print("selected");
                }
            }
        }
    }

    include('form.php');
} else {


    $errors = FALSE;

    $user = 'u67324'; 
    $pass = '4775222'; 
    $db = new PDO(
    'mysql:host=localhost;dbname=u67324',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if (empty($_POST['fio']) || !preg_match('/[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+/u', $_POST['fio']) ||
        strlen($_POST['fio']) > 150) {
        setcookie('fio_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['tel']) || !preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
        setcookie('tel_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['email']) || !preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
        setcookie('email_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['birth']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['birth'])) {
        setcookie('birth_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['radio_sex'])) {
        setcookie('radio_sex_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['field_favourite_pl'])) {
        $errors = TRUE;
    } else { 
        $sth = $db->prepare("SELECT id FROM languages");
        $sth->execute();
        $langs = $sth->fetchAll();
    
        foreach ($_POST['field_favourite_pl'] as $id_lang) {
            $error_lang = TRUE;
            foreach ($langs as $lang) {
                if ($id_lang == $lang[0]) {
                    $error_lang = FALSE;
                    break;
                }
            }
            if ($error_lang == TRUE) {
                $errors = TRUE;
                break;
            }
        }
    }

    if (empty($_POST['biography']) || strlen($_POST['biography']) > 600) {
        setcookie('biography_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    if (empty($_POST['checkbox_agree'])) {
        setcookie('checkbox_agree_error', '1', time() + 60 * 60 * 24 * 365);
        $errors = TRUE;
    }

    setcookie('fio_value', $_POST['fio'], time() + 60 * 60 * 24 * 365);
    setcookie('tel_value', $_POST['tel'], time() + 60 * 60 * 24 * 365);
    setcookie('email_value', $_POST['email'], time() + 60 * 60 * 24 * 365);
    setcookie('birth_value', $_POST['birth'], time() + 60 * 60 * 24 * 365);
    setcookie('radio_sex_value', $_POST['radio_sex'], time() + 60 * 60 * 24 * 365);
    setcookie('field_favourite_pl_value', serialize($_POST['field_favourite_pl']), time() + 12 * 30 * 24 * 60 * 60);
    setcookie('biography_value', $_POST['biography'], time() + 60 * 60 * 24 * 365);
    setcookie('checkbox_agree_value', $_POST['checkbox_agree'], time() + 60 * 60 * 24 * 365);
    

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('fio_error', '', 100000);
        setcookie('tel_error', '', time() - 3600);
        setcookie('email_error', '', time() - 3600);
        setcookie('birth_error', '', time() - 3600);
        setcookie('radio_sex_error', '', time() - 3600);
        setcookie('field_favourite_pl_error', '', time() - 3600);
        setcookie('biography_error', '', time() - 3600);
        setcookie('checkbox_agree_error', '', time() - 3600);
    }

    $checkbox_agree = isset($_POST['checkbox_agree']) && $_POST['checkbox_agree'] === 'on' ? 1 : 0;

    if (isset($_COOKIE['updated'])) {

        $stmt = $db->prepare("UPDATE users SET fio = :fio_value, tel = :tel_value, email = :email_value, birth = :birth_value, radio_sex = :radio_sex_value, biography = :biography_value, checkbox_agree = :checkbox_agree_value WHERE id = :id");

        $fio = $_POST['fio'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $formattedBirthday = DateTime::createFromFormat('Y-m-d', $_POST['birth']);
        $formattedBirthday = $formattedBirthday->format('Y-m-d');
        $radio_sex = $_POST['radio_sex'];
        $biography = $_POST['biography'];
        $checkbox_agree = $checkbox_agree;

        $stmt->bindParam(':fio_value', $fio);
        $stmt->bindParam(':tel_value', $tel);
        $stmt->bindParam(':email_value', $email);
        $stmt->bindParam(':birth_value', $formattedBirthday);
        $stmt->bindParam(':radio_sex_value', $radio_sex);
        $stmt->bindParam(':biography_value', $biography);
        $stmt->bindParam(':checkbox_agree_value', $checkbox_agree);
        $stmt->bindParam(':id', $_SESSION['user_id']);

        $stmt->execute();

        $stmt = $db->prepare("UPDATE users_and_languages SET id_user = :id_user, id_lang = :id_lang WHERE id = :id");
        foreach ($_POST['field_favourite_pl'] as $id_lang) {
            $id_user = $_SESSION['user_id'];
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_lang', $id_lang);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
        }

        setcookie('update', '1');
        header('Location: index.php');
    }
    else {

        $stmt = $db->prepare("INSERT INTO users (fio, tel, email, birth, radio_sex, biography, checkbox_agree) VALUES (:fio_value, :tel_value, :email_value, :birth_value, :radio_sex_value, :biography_value, :checkbox_agree_value)");

        $fio = $_POST['fio'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $formattedBirthday = DateTime::createFromFormat('Y-m-d', $_POST['birth']);
        $formattedBirthday = $formattedBirthday->format('Y-m-d');
        $radio_sex = $_POST['radio_sex'];
        $biography = $_POST['biography'];
        $checkbox_agree = $checkbox_agree;

        $stmt->bindParam(':fio_value', $fio);
        $stmt->bindParam(':tel_value', $tel);
        $stmt->bindParam(':email_value', $email);
        $stmt->bindParam(':birth_value', $formattedBirthday);
        $stmt->bindParam(':radio_sex_value', $radio_sex);
        $stmt->bindParam(':biography_value', $biography);
        $stmt->bindParam(':checkbox_agree_value', $checkbox_agree);

        $stmt->execute();

        $id = $db->lastInsertId();
        $_SESSION['user_id'] = $id; 

        $stmt = $db->prepare("INSERT INTO users_and_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
        foreach ($_POST['field_favourite_pl'] as $id_lang) {
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_lang', $id_lang);
            $id_user = $id;
            $stmt->execute();
        }

        setcookie('save', '1');
        setcookie('updated', '1');
        header('Location: index.php');
    }
}
?>
