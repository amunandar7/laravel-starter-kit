<?php
$selected = array_key_exists('selected', $options) ? $options['selected'] : null;
if ($selected != null && array_key_exists("ajax", $options)) {
    $options['choices'] = [
        $selected => \App\Http\Select2\Select2Ajax::getTextByKey($options['ajax'],
            $selected)
    ];
}
$emptyVal = array_key_exists('empty_value', $options) ? ['' => $options['empty_value']]
        : null;
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
        <?= Form::select($name, (array) $emptyVal + $options['choices'],
            $selected, $options['attr']) ?>
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
