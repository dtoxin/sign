<?php
//регистрация скриптов view
    $this->_addJs('/static/js/signin.js');
?>
<div class="login-form">
<form class="form-container">
    <div class="form-title"><h2><?= L::t('Sign in'); ?></h2></div>
    <div class="form-help">
        <?= L::t('Please enter your credentials that you used when registering');?>
    </div>
    <div class="form-element">
        <label for="email"><?= L::t('Email'); ?><span class="form-req-field">*</span> :</label>
        <input class="form-field" type="email" name="email" id='inp-email'/>
        <div class="input-error shadow-s1" id="err-email"></div>
    </div>

    <div class="form-element">
        <label for="password"><?= L::t('Password'); ?>:</label>
        <input class="form-field" type="password" name="password" id='inp-password' />
        <div class="input-error shadow-s1" id="err-password"></div>
    </div>
    <div class="submit-container">
        <input class="btn" id='submit-login-form' type="submit" value="<?= L::t('Enter'); ?>" onclick="return false;"/>
    </div>
</form>
</div>