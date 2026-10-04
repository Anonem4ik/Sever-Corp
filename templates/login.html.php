<form class="generic-form" method="post">
<h2>Авторизация</h2>
<div class="fields-box">
    <div class="entry">
        <label for="i_name">Логин</label>
        <input type="text" name="login" id="i_name" value="">
    </div>
    <div class="entry">
        <label for="i_corp">Пароль</label>
        <input type="password" name="password" id="i_corp" value="">
    </div>
</div>
<button class="purple-box" type="submit" name="submit">Войти в систему</button>
<div class="check-entry">
    <input type="checkbox" name="is_remember" id="i_remember">
    <label>Запомнить меня</label>
</div>
</form>
<p class="alter-redirect">Ещё нет аккаунта? - <a href="register.php" class="blue-link">Регистрация</a></p>