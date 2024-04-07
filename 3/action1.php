<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print("Результаты сохранены");
    }
    include('index.php');
    exit();
}

$user = 'u67324'; 
$pass = '4775222'; 
$db = new PDO(
    'mysql:host=localhost;dbname=u67324',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
); 

$errors = FALSE;

// Проверка ФИО
if (empty($_POST['fio'])) { // Изменено на 'fio', так как в форме у вас есть name="fio"
    print('Заполните поле "ФИО"!');
    $errors = TRUE;
} else {
    $fio = $_POST['fio']; // Изменено на 'fio'
    if (strlen($fio) > 150) {
        print('ФИО слишком длинное. Пожалуйста, укоротите его.');
        $errors = TRUE;
    } else if (!preg_match('/[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+/u', $fio)) {
        print('ФИО заполнено некорректно. Пожалуйста, исправьте.');
        $errors = TRUE;
    } else {
        $fioParts = explode(' ', $fio);
        if (count($fioParts) < 3) {
            print('ФИО заполнено не полностью. Пожалуйста, укажите все три части ФИО.');
            $errors = TRUE;
        }
    }
}

// Проверка телефона
if (empty($_POST['tel'])) { // Изменено на 'tel', так как в форме у вас есть name="tel"
    print('Заполните поле "Телефон"!');
    $errors = TRUE;
} else if (!preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
    print('Телефон заполнен некорректно. Пожалуйста, исправьте.');
    $errors = TRUE;
}

// Проверка почты
if (empty($_POST['email'])) { // Изменено на 'email', так как в форме у вас есть name="email"
    print('Заполните поле "Email"!');
    $errors = TRUE;
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    print('Email заполнен некорректно. Пожалуйста, исправьте.');
    $errors = TRUE;
}

// Проверка даты рождения
if (empty($_POST['birth'])) { // Изменено на 'birth', так как в форме у вас есть name="birth"
    print('Заполните поле "Дата рождения"!');
    $errors = TRUE;
} else {
    $formattedBirthday = date('Y-m-d', strtotime($_POST['birth']));
}

// Проверка пола
if (empty($_POST['radio_sex'])) { // Изменено на 'radio_sex', так как в форме у вас есть name="radio_sex"
    print('Выберите ваш пол!');
    $errors = TRUE;
}

// Проверка выбранных языков программирования
if (empty($_POST['field_favourite_pl'])) {
    print('Выберите любимый язык программирования!');
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
            print('Выбранный язык программирования не найден в базе данных!');
            $errors = TRUE;
            break;
        }
    }
}

// Проверка биографии
if (empty($_POST['biography'])) { // Изменено на 'biography', так как в форме у вас есть name="biography"
    print('Введите биографию!');
    $errors = TRUE;
}

// Проверка согласия с контрактом
if (empty($_POST['checkbox-agree']) || $_POST['checkbox-agree'] != 'on') {
    print('Ознакомьтесь с контрактом и поставьте галочку!');
    $errors = TRUE;
}

if ($errors) {
    exit();
}

// Проверяем состояние чекбокса согласия
$checkbox_agree = isset($_POST['checkbox-agree']) && $_POST['checkbox-agree'] === 'on' ? 1 : 0;

// Готовим запрос для вставки данных в базу данных
$stmt = $db->prepare("INSERT INTO users (fio, tel, email, birth, radio_sex, biography, checkbox_agree) VALUES (:fio_value, :tel_value, :email_value, :birth_value, :radio_sex_value, :biography_value, :checkbox_agree_value)");

// Привязываем параметры к переменным
$stmt->bindParam(':fio_value', $fio);
$stmt->bindParam(':tel_value', $tel);
$stmt->bindParam(':email_value', $email);
$stmt->bindParam(':birth_value', $formattedBirthday);
$stmt->bindParam(':radio_sex_value', $radio_sex);
$stmt->bindParam(':biography_value', $biography);
$stmt->bindParam(':checkbox_agree_value', $checkbox_agree);

// Устанавливаем значения переменных
$fio = $_POST['fio']; // Изменено на 'fio'
$tel = $_POST['tel']; // Изменено на 'tel'
$email = $_POST['email']; // Изменено на 'email'
$formattedBirthday = date('Y-m-d', strtotime($_POST['birth'])); // Изменено на 'birth'
$radio_sex = $_POST['radio_sex']; // Изменено на 'radio_sex'
$biography = $_POST['biography']; // Изменено на 'biography'
$checkbox_agree = $checkbox_agree; // Здесь используется значение переменной, установленное выше

$stmt->execute();

$id = $db->lastInsertId();

$stmt = $db->prepare("INSERT INTO users_and_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
foreach ($_POST['field_favourite_pl'] as $id_lang) {
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_lang', $id_lang);
    $id_user = $id;
    $stmt->execute();
}

header('Location: ?save=1');
?>