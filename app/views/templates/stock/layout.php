<!doctype html>
<html lang="en-US">
<?php //@param $this Controller ?>
<head>
    <meta charset="UTF-8">
    <title><?= Esc::cape($this->_title); ?></title>
    <!-- styles -->
    <link rel="stylesheet" href="/static/css/reset.css"/>
    <link rel="stylesheet" href="/static/css/template.css"/>
    <?php $this->_renderCss(); ?>
    <!-- scripts -->
    <script type="text/javascript" src="/static/js/lib/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/static/js/app.js"></script>
    <?php $this->_renderJs(); ?>
</head>
<body>
    <div class="top-bar">
        <div class="content-wrapper">
            <label for="lng"><?= L::t('Language')?>: </label>
            <select name="lng" id="select-lng">
                <option value="en">en</option>
                <option value="ru">ru</option>
            </select>
        </div>
    </div> <br><br><br>
    <div class="content-wrapper">
        <div class="content">
            <?php echo $view; ?>
            <?php /*ob_start(); */?><!--
            <?php /*include $content; */?>
            <?php /*$out .= ob_get_clean( ); */?>
            <?php /*echo $out; */?>
            --><?php /*ob_end_flush();*/?>
        </div>
    </div>
</body>
</html>