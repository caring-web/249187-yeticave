<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
           <li class="nav__item">
               <a href="pages/all-lots.html"><?=$category['category']; ?></a>
           </li>
       <?php endforeach; ?>
    </ul>
</nav>
<form class="form container<?=empty($errors) ? '' : ' form--invalid'; ?>" action="login.php" method="post" enctype="multipart/form-data">
    <h2>Вход</h2>
    <div class="form__item<?=empty($errors) ? '' : ' form__item--invalid'; ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required<?=empty($data['email']) ? '' : ' value="' . $data['email'] . '"'; ?>>
        <span class="form__error"><?=!isset($errors['email']) ? '' : $errors['email']; ?></span>
    </div>
    <div class="form__item form__item--last">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" required<?=empty($data['password']) ? '' : ' value="' . $data['password'] . '"'; ?>>
        <span class="form__error"><?=!isset($errors['password']) ? '' : $errors['password']; ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
