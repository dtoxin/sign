<div class="login-form">
<form class="form-container">
    <div class="form-title"><h2><?= L::t('Sign in'); ?></h2></div>
    <div class="form-element">
        <label for="email"><?= L::t('Email'); ?>:</label>
        <input class="form-field" type="email" name="email" />
    </div>

    <div class="form-element">
        <label for="password"><?= L::t('Password'); ?>:</label>
        <input class="form-field" type="text" name="password" />
    </div>
    <div class="submit-container">
        <input class="btn" type="submit" value="Submit" />
    </div>
</form>
</div>