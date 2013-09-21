<?php //@param $data array ?>
<?php $this->_addCss('/static/css/style.css'); ?>
<?php $this->_addJs('/static/js/style.js'); ?>
<?php $this->_setTitle('Заголовок!');?>
<h1>hello</h1>
<?php echo Esc::cape($data['simple']);?>