<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Витченко Влада</title>
        <link rel="stylesheet" type="text/css" href="style1.css">
    </head>
    <body>
        <nav>

            <h2>Форма:</h2>

            <form method="post" action = "/" id = "form-first">
                <label>ФИО</label><br>
                <input type="text" name = "field-name-surname"><br>
                <label>Телефон</label><br>
                <input type = "tel" name = "field-phone-number"><br>
                <label>Ваш email</label><br>
                <input type = "email" name = "field-email"><br>
                <label>Дата рождения</label><br>
                <input type = "date" name = "field-birthday"><br>
                <label>Ваш пол:</label>
                <label><input type="radio" name = "radio-sex" checked="checked" value = "Мужской">Мужской</label>
                <label><input type="radio" name = "radio-sex" value = "Женский">Женский</label><br>
                <label>Ваш любимый язык программирования:</label><br>
                <select multiple = "multiple" name = "field-favourite-pl">
                    <option value = "Pascal">Pascal</option>
                    <option value="C">C</option>
                    <option value="C++">C++</option>
                    <option value="Java">Java</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="PHP">PHP</option>
                    <option value="Python">Python</option>
                    <option value="Haskel">Haskel</option>
                    <option value="Clojure">Clojure</option>
                    <option value="Prolog">Prolog</option>
                    <option value="Scala">Scala</option>
                </select><br>
                <label>Биография</label><br>
                <textarea name = "field-biography">напишите о себе</textarea><br>
                <input type = "checkbox" name = "checkbox-agree">С контрактом ознакомлен<br>
                <input type = "submit" value="Отправить">
            </form>

        </nav>

    </body>
</html>