<!doctype html>
<html lang="en-US">
<?php //@param $this Controller ?>
<head>
    <meta charset="UTF-8">
    <title><?= Esc::cape($this->_title); ?></title>
    <!-- styles -->
    <?php $this->_renderCss(); ?>
    <!-- scripts -->
    <?php $this->_renderJs(); ?>
</head>
<body>
    <?php echo $content; ?>
</body>
</html>