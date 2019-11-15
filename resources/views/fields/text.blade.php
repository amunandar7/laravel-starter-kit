<?php
$type = 'text';
if(array_key_exists("type", $options)) {
    $type = $options['type'];
}
?>


<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>

    <?php if (array_key_exists("prepend", $options) || array_key_exists("append",$options)): ?>
        <div class="input-group">
        <?php if (array_key_exists("prepend", $options)): ?>
        <div class="input-group-prepend">
            <span class="input-group-text"><?= $options['prepend'] ?></span>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <?= Form::input($type, $name, $options['value'], $options['attr']) ?>

    <?php if (array_key_exists("prepend", $options) || array_key_exists("append",$options)): ?>
        <?php if (array_key_exists("append", $options)): ?>
        <div class="input-group-append">
            <span class="input-group-text"><?= $options['append'] ?></span>
        </div>
        <?php endif; ?>
        </div>
    <?php endif; ?>

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

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
