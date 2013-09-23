<?php //@param $data array ?>
<?php $this->_addCss('/static/css/style.css'); ?>
<?php $this->_addJs('/static/js/style.js'); ?>
<?php $this->_setTitle('Главная страница');?>

<div class="main-page-container">
    <h1 class="welcome"><?= L::t('Welcome!'); ?></h1>
    <h1 class="welcome"><?= L::t('Test task'); ?></h1>
</div>
