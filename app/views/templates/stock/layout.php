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
    <script type="text/javascript" src="/static/js/lng/dict.js"></script>
    <?php $this->_renderJs(); ?>
</head>
<body>
    <div class="top-bar">
        <div class="content-wrapper">
            <label for="lng"><?= L::t('Language')?>: </label>
            <select name="lng" id="select-lng">
                <option value="" selected>select language</option>
                <option value="en">en</option>
                <option value="ru">ru</option>
            </select>
            <?php if (Usr::hasCredentials()): ?>
                <div class="user-bar">
                    <div class="signed">
                        <span style='color: #000 !important; font-weight: normal !important;'><?= L::t('Signed in'); ?>:</span>
                        <span class="sp-user-name"><?= Esc::cape(Usr::getLoginAss());?></span>
                        <a href="/signout"><?= L::t('Sign out'); ?></a>
                    </div>
                </div>
            <?php endif; ?>
                <nav>
                    <a href="/"><?= L::t('Home');?></a>
                    <a href="/signup"><?= L::t('Register new user');?></a>
                    <a href="/users/profile"><?= L::t('User profile');?></a>
                </nav>
        </div>
    </div> <br><br><br>
    <div class="content-wrapper">
        <div class="content">
            <?php echo $view; ?>
        </div>
    </div>
</body>
</html>