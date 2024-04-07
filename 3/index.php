
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Витченко Влада</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<h2 class="text-center col">Форма:</h2>

<form method="post" action="action.php" id="form-first" class="body-center-form order-1 order-md-0 col">
    <label>ФИО</label><br>
    <input type="text" name="fio" id="FIO"><br>
    <label>Телефон</label><br>
    <input type="tel" name="tel" id="phone_number"><br>
    <label>Ваш email</label><br>
    <input type="email" name="email" id="email"><br>
    <label>Дата рождения</label><br>
    <input type="date" name="birth" id="birthday"><br>
    <label>Ваш пол:</label>
    <label><input type="radio" name="radio_sex" checked="checked" value="Мужской" id="radio-man">Мужской</label>
    <label><input type="radio" name="radio_sex" value="Женский" id="radio-woman">Женский</label><br>
    <label>Ваш любимый язык программирования:</label><br>
    <select multiple="multiple" name="field_favourite_pl[]" id="program_language">
        <option value="1">Pascal</option>
        <option value="2">C</option>
        <option value="3">C++</option>
        <option value="4">Java</option>
        <option value="5">JavaScript</option>
        <option value="6">PHP</option>
        <option value="7">Python</option>
        <option value="8">Haskell</option>
        <option value="9">Clojure</option>
        <option value="10">Prolog</option>
        <option value="11">Scala</option>
    </select><br>
    <label>Биография</label><br>
    <textarea name="biography" id="biography">напишите о себе</textarea><br>
    <input type="checkbox" name="checkbox-agree" id="checkbox-agree">С контрактом ознакомлен<br>
    <input type="submit" value="Отправить" id="button_submit">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
