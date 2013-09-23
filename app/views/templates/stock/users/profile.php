<?php
$this->_setTitle(L::t('User profile'));
?>

<div class="profile-container ">
    <table class='user-info' cellspacing="5" cellpadding="10">
        <tbody>
        <tr>
            <td><img class='img-user-image' src="<?= Esc::cape($data['user']->img_path) ?>" alt="<?= Esc::cape($data['user']->name); ?>"/></td>
            <td>
                <div>
                    <span class="field"><?= L::t('Name'); ?></span>:
                    <span class="field-value"><?= Esc::cape($data['user']->name);?></span>
                </div>
                <br>
                <div>
                    <span class="field"><?= L::t('Last name'); ?></span>:
                    <span class="field-value"><?= Esc::cape($data['user']->last_name);?></span>
                </div>
                <?php if (!empty($data['user']->mid_name)): ?>
                    <br>
                    <div>
                        <span class="field"><?= L::t('Middle name'); ?></span>:
                        <span class="field-value"><?= Esc::cape($data['user']->mid_name);?></span>
                    </div>
                <?php endif; ?>
                <br>
                <div>
                    <span class="field"><?= L::t('Date of registration'); ?></span>:
                    <span class="field-value"><?= D::formatRu($data['user']->created_at);?></span>
                </div>
                <br>
                <div>
                    <span class="field"><?= L::t('Last login'); ?></span>:
                    <span class="field-value"><?= D::formatRu($data['user']->last_login);?></span>
                </div>
                <?php if (!empty($data['user']->addition) && !is_null(json_decode($data['user']->addition))): ?>
                    <?php foreach (json_decode($data['user']->addition, true) as $key => $value): ?>
                        <br>
                        <div>
                            <span class="field"><?= Esc::cape($key); ?></span>:
                            <span class="field-value"><?= Esc::cape($value);?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </td>
        </tr>
        </tbody>
    </table>
</div>