<form class="generic-form" method="post">
    <h2>Регистрация</h2>
    <div class="fields-box">
        <div class="entry">
            <label for="i_login">Логин</label>
            <input type="text" name="login" id="i_login" required>
        </div>
        <div class="entry">
            <label for="i_email">Электронная почта</label>
            <input type="email" name="email" id="i_email" required>
        </div>
        <div class="entry">
            <label for="i_pwd">Пароль</label>
            <input type="password" name="password" id="i_pwd" required>
        </div>
        <div class="entry">
            <label for="i_pwdRepeat">Повторите пароль</label>
            <input type="password" name="pwd_repeat" id="i_pwdRepeat" required>
        </div>
    </div>
    <div class="check-entry">
        <input type="checkbox" name="agreement" id="i_check" required>
        <label>Я согласен на <a class="blue-link" href="#">обработку персональных данных</a></label>
    </div>
    <button class="purple-box" type="submit" name="submit">Создать аккаунт</button>
    <div class="check-entry">
        <input type="checkbox" name="is_remember" id="i_remember" checked>
        <label>Запомнить меня</label>
    </div>
</form>
<p class="alter-redirect">Уже есть аккаунт? - <a href="login.php" class="blue-link">Авторизация</a></p>