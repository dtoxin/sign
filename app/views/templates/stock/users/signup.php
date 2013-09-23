<?php
//регистрация скриптов view
$this->_addJs('/static/js/signup.js');
$this->_setTitle(L::t('Sign up'));
?>

<div class="register-form">
    <form class="form-container" method="post" action='/signup' id='frm-signup' enctype="multipart/form-data">
        <div class="form-title"><h2><?= L::t('Sign up'); ?></h2></div>
        <div class="form-help">
            <?= L::t('Please enter your details in the form below.');?>
        </div>
        <div class="form-help">
            <?= L::t('Fields marked with ');?><span class="form-req-field">*</span><?= L::t(' are required.'); ?>
        </div>
        <?php if (!empty($data['errors'])): ?>
            <div class="form-all-errors">
                <h6><?= L::t('Please correct the following errors'); ?>:</h6>
                <ul class='ul-errors'>
                    <li class='li-error'>
                    <?php foreach ($data['errors'] as $f => $error):?>
                        <span class="sp-error"><?= L::t('Field') . " " . L::t($f); ?></span>
                        <?php if(is_array($error)):?>
                            <ul>
                                <?php foreach($error as $e):?>
                                    <li class='li-error'><?= L::t($e)?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php continue; ?>
                        <?php endif;?>
                    <?= L::t($error); ?>
                    </li>
                <?php endforeach; ?>
                </ul>

            </div>
        <?php endif; ?>
        <div class="form-element">
            <label for="User[email]"><?= L::t('E-mail'); ?><span class="form-req-field">*</span> :</label>
            <input class="form-field" type="email" name="User[email]" id='inp-email'/>
            <div class="input-error shadow-s1" id="err-email"></div>
        </div>

        <div class="form-element">
            <label for="User[password]"><?= L::t('Password'); ?><span class="form-req-field">*</span>:</label>
            <input class="form-field" type="password" name="User[password]" id='inp-password' />
            <div class="input-error shadow-s1" id="err-password"></div>
        </div>

        <div class="form-element">
            <label for="User[psw_confirm]"><?= L::t('Confirm password'); ?><span class="form-req-field">*</span> :</label>
            <input class="form-field" type="password" name="User[psw_confirm]" id='inp-psw_confirm'/>
            <div class="input-error shadow-s1" id="err-psw_confirm"></div>
        </div>

        <div class="form-element">
            <label for="User[name]"><?= L::t('Name'); ?><span class="form-req-field">*</span> :</label>
            <input class="form-field" type="text" name="User[name]" id='inp-name'/>
            <div class="input-error shadow-s1" id="err-name"></div>
        </div>

        <div class="form-element">
            <label for="User[last_name]"><?= L::t('Last name'); ?><span class="form-req-field">*</span> :</label>
            <input class="form-field" type="text" name="User[last_name]" id='inp-last_name'/>
            <div class="input-error shadow-s1" id="err-last_name"></div>
        </div>
        <div class="form-element">
            <label for="User[mid_name]"><?= L::t('Middle name'); ?>:</label>
            <input class="form-field" type="text" name="User[mid_name]" id='inp-mid_name'/>
            <div class="input-error shadow-s1" id="err-mid_name"></div>
        </div>
        <div class="form-element">
            <label for="User[avatar]"><?= L::t('Image'); ?>:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input class="form-field" type="file" name="User[avatar]" id='inp-avatar'/>
            <div class="input-error shadow-s1" id="err-avatar"></div>
        </div>

        <!--addition fields-->
        <input type="hidden" value='' name='information[data]' id='inp-fullAdInfo'/>
        <div id='additions-fields'></div>
        <!--end addition fields-->

        <div class="form-element">
            <a href="#" id='lnk-add-field' onclick="return false;">Добавить поле</a>
        </div>
        <div class="inner-form">
            <div class="element">
                <label for="field-name"><?= L::t("Field name")?>: <small><?= L::t('e.g phone'); ?></small></label>
                <input type="text" name="field-name" value='' id='field-name'/>
            </div>
            <span class="ctrl-lnk"><a href="#" id='lnk-saveField' onclick="return false;">добавить</a></span>
        </div>
        <div class="submit-container">
            <input class="btn" id='reset-register-form' type="reset" value="<?= L::t('Reset'); ?>" />
            <input class="btn" id='submit-register-form' type="submit" value="<?= L::t('Complete'); ?>" onclick="return false;"/>
        </div>
    </form>
</div>