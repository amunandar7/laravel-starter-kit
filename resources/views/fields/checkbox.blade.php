<?php
if($options['attr']['class'] == 'form-control') {
    unset($options['attr']['class']);
}
$checked = (array_key_exists('checked', $options) ? $options['checked'] : false);
$inline = (array_key_exists('inline', $options) ? $options['inline'] : false);
?>

<?php if ($showLabel && $showField && !$inline): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div class="checkbox">
    <?php endif; ?>
<?php endif; ?>

<?php if ($showField): ?>
        <label<?= ($inline) ? ' class="checkbox-inline"' : '' ?>>
    <?= Form::checkbox($name, $options['value'], $checked, $options['attr']) ?>
    {!! $options['label'] !!}
    </label>

    <?php if ($options['help_block']['text'] && !$options['is_child']): ?>
        <<?= $options['help_block']['tag'] ?> <?= $options['help_block']['helpBlockAttrs'] ?>>
            <?= $options['help_block']['text'] ?>
        </<?= $options['help_block']['tag'] ?>>
    <?php endif; ?>
<?php endif; ?>

<?php if ($showError && isset($errors)): ?>
    <?php foreach ($errors->get($nameKey) as $err): ?>
        <div <?= $options['errorAttrs'] ?>><?= $err ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($showLabel && $showField && !$inline): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
