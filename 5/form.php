<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
</head>
<body>
    <h1>Форма регистрации</h1>

    <?php
   if (!empty($messages['success'])) {
      print('<div id="messages">');
      print($messages['success']);
      print('</div>');
  }
    ?>

    <form action="index.php" method="post">
        <label for="fio">ФИО:</label>
        <input type="text" id="fio" name="fio" value="<?php echo $values['fio']; ?>">
        <br>

        <label for="tel">Телефон:</label>
        <input type="tel" id="tel" name="tel" value="<?php echo $values['tel']; ?>">
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $values['email']; ?>">
        <br>

        <label for="birth">Дата рождения (гггг-мм-дд):</label>
        <input type="text" id="birth" name="birth" value="<?php echo $values['birth']; ?>">
        <br>

        <label>Пол:</label>
        <input type="radio" id="male" name="radio_sex" value="male" <?php $values['radio_sex'] == 'male' ? print('checked') : ''; ?>>
        <label for="male">Мужской</label>
        <input type="radio" id="female" name="radio_sex" value="female" <?php $values['radio_sex'] == 'female' ? print('checked') : ''; ?>>
        <label for="female">Женский</label>
        <br>

        <label for="field_favourite_pl">Любимые языки программирования:</label>
          <select id="field_favourite_pl" name="field_favourite_pl[]" >
      <option value="1" <?php is_checked_lang($values, '1')? print('selected') : ''; ?>>Pascal</option>
      <option value="2" <?php is_checked_lang($values, '2') ? print('selected') : ''; ?>>C</option>
      <option value="3" <?php is_checked_lang($values, '3') ? print('selected') : ''; ?>>C++</option>
      <option value="4" <?php is_checked_lang($values, '4') ? print('selected') : ''; ?>>Java</option>
      <option value="5" <?php is_checked_lang($values, '5') ? print('selected') : ''; ?>>JavaScript</option>
      <option value="6" <?php is_checked_lang($values, '6') ? print('selected') : ''; ?>>PHP</option>
      <option value="7" <?php is_checked_lang($values, '7') ? print('selected') : ''; ?>>Python</option>
      <option value="8" <?php is_checked_lang($values, '8') ? print('selected') : ''; ?>>Haskell</option>
      <option value="9" <?php is_checked_lang($values, '9') ? print('selected') : ''; ?>>Clojure</option>
      <option value="10" <?php is_checked_lang($values, '10')? print('selected') : ''; ?>>Prolog</option>
      <option value="11" <?php is_checked_lang($values, '11') ? print('selected') : ''; ?>>Scala</option>
  </select>
<br>

        <label for="biography">Биография (не более 600 символов):</label><br>
        <textarea id="biography" name="biography" rows="5" cols="40"><?php echo $values['biography']; ?></textarea>
        <br>

        <input type="checkbox" id="checkbox_agree" name="checkbox_agree" <?php $values['checkbox_agree'] == 'on' ? print('checked') : ''; ?>>
        <label for="checkbox_agree">Согласен с условиями</label>
        <br>

        <input type="submit" value="Отправить">
    </form>
</body>
</html>
